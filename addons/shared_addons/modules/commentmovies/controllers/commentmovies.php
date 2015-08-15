<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Commentmovies controller (frontend)
 *
 * @package		PyroCMS\Core\Modules\Commentmovies\Controllers
 * @author		PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class Commentmovies extends Public_Controller
{
	/**
	 * An array containing the validation rules
	 * 
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:commentmovies:name_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'email',
			'label' => 'lang:global:email',
			'rules' => 'trim|valid_email'
		),
		array(
			'field' => 'website',
			'label' => 'lang:commentmovies:website_label',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'commentmovie',
			'label' => 'lang:commentmovies:message_label',
			'rules' => 'trim|required'
		),
	);

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('commentmovie_m');
		$this->lang->load('commentmovies');
	}

	/**
	 * Create a new commentmovie
	 *
	 * @param type $module The module that has a commentmovie-able model.
	 * @param int $id The id for the respective commentmovie-able model of a module.
	 */
	public function create($module = null)
	{
		if ( ! $module or ! $this->input->post('entry')) 
		{
			show_404();
		}

		// Get information back from the entry hash
		// @HACK This should be part of the controllers lib, but controllers & libs cannot share a name
		$entry = unserialize($this->encrypt->decode($this->input->post('entry')));

		$commentmovie = array(
			'module' 		=> $module,
			'entry_id' 		=> $entry['id'],
			'entry_title' 	=> $entry['title'],
			'entry_key' 	=> $entry['singular'],
			'entry_plural' 	=> $entry['plural'],
			'uri' 			=> $entry['uri'],
			'commentmovie' 		=> $this->input->post('commentmovie'),
			'is_active' 	=> (bool) ((isset($this->current_user->group) and $this->current_user->group == 'admin') or ! Settings::get('moderate_commentmovies')),
		);
		//echo "<pre>";print_r($commentmovie);die();
		// Logged in? in which case, we already know their name and email
		if ($this->current_user)
		{
			$commentmovie['user_id'] = $this->current_user->id;
			$commentmovie['user_name'] = $this->current_user->display_name;
			$commentmovie['user_email'] = $this->current_user->email;
			$commentmovie['user_website'] = $this->current_user->website;

			if (isset($this->current_user->website))
			{
				$commentmovie['website'] = $this->current_user->website;
			}
		}
		else
		{
			$this->validation_rules[0]['rules'] .= '|required';
			$this->validation_rules[1]['rules'] .= '|required';

			$commentmovie['user_name'] = $this->input->post('name');
			$commentmovie['user_email'] = $this->input->post('email');
			$commentmovie['user_website'] = $this->input->post('website');
		}

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Validate the results
		if ($this->form_validation->run())
		{
			// ALLOW ZEH COMMENTS!? >:D
			$result = $this->_allow_commentmovie();

			foreach ($commentmovie as &$data)
			{
				// Remove {pyro} tags and html
				$data = escape_tags($data);
			}

			// Run Akismet or the crazy CSS bot checker
			if ($result['status'] !== true)
			{
				$this->session->set_flashdata('commentmovie', $commentmovie);
				$this->session->set_flashdata('error', $result['message']);

				$this->_repopulate_commentmovie();
			}
			else
			{
				// Save the commentmovie
				if ($commentmovie_id = $this->commentmovie_m->insert($commentmovie))
				{
					// Approve the commentmovie straight away
					if (!$this->settings->moderate_commentmovies or (isset($this->current_user->group) and $this->current_user->group == 'admin'))
					{
						$this->session->set_flashdata('success', lang('commentmovies:add_success'));

						// Add an event so third-party devs can hook on
						Events::trigger('commentmovie_approved', $commentmovie);
					}

					// Do we need to approve the commentmovie?
					else
					{
						$this->session->set_flashdata('success', lang('commentmovies:add_approve'));
					}

					$commentmovie['commentmovie_id'] = $commentmovie_id;

					// If markdown is allowed we will parse the body for the email
					if (Settings::get('commentmovie_markdown'))
					{
						$commentmovie['commentmovie'] = parse_markdown($commentmovie['commentmovie']);
					}

					// Send the notification email
					$this->_send_email($commentmovie, $entry);
				}

				// Failed to add the commentmovie
				else
				{
					$this->session->set_flashdata('error', lang('commentmovies:add_error'));

					$this->_repopulate_commentmovie();
				}
			}
		}

		// The validation has failed
		else
		{
			$this->session->set_flashdata('error', validation_errors());

			$this->_repopulate_commentmovie();
		}


		// If for some reason the post variable doesnt exist, just send to module main page
		$uri = ! empty($entry['uri']) ? $entry['uri'] : $module;

		// If this is default to pages then just send it home instead
		$uri === 'pages' and $uri = '/';

		redirect($uri);
	}

	/**
	 * Repopulate Commentmovie
	 *
	 * There are a few places where we need to repopulate
	 * the commentmovies.
	 *
	 * @access 	private
	 * @return 	void
	 */
	private function _repopulate_commentmovie()
	{
		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== false)
			{
				$commentmovie[$rule['field']] = escape_tags($this->input->post($rule['field']));
			}
		}
		$this->session->set_flashdata('commentmovie', $commentmovie);
	}

	/**
	 * Method to check whether we want to allow the commentmovie or not
	 * 
	 * @return array
	 */
	private function _allow_commentmovie()
	{
		// Dumb-check
		$this->load->library('user_agent');
		$this->load->model('commentmovie_blacklists_m');

		// Sneaky bot-check
		if ($this->agent->is_robot() or $this->input->post('d0ntf1llth1s1n'))
		{
			return array('status' => false, 'message' => 'You are probably a robot.');
		}

		// Check Akismet if an API key exists
		if (Settings::get('akismet_api_key_movie'))
		{
			$this->load->library('akismet');

			$commentmovie = array(
				'author' => $this->current_user ? $this->current_user->display_name : $this->input->post('name'),
				'email' => $this->current_user ? $this->current_user->email : $this->input->post('email'),
				'website' => (isset($this->current_user->website)) ? $this->current_user->website : $this->input->post('website'),
				'body' => $this->input->post('body')
			);

			$config = array(
				'blog_url' => BASE_URL,
				'api_key' => Settings::get('akismet_api_key_movie'),
				'commentmovie' => $commentmovie
			);
                        
			$this->akismet->init($config);

			if ($this->akismet->is_spam())
			{
				return array('status' => false, 'message' => 'Looks like this is spam. If you believe this is incorrect please contact the site administrator.');
			}

			if ($this->akismet->errors_exist())
			{
				return array('status' => false, 'message' => implode('<br />', $this->akismet->get_errors()));
			}
		}
	
		// Do our own blacklist check.
		$blacklist = array(
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website')
		);
	
		if ($this->commentmovie_blacklists_m->is_blacklisted($blacklist))
		{
			return array('status' => false, 'message' => 'The website or email address posting this commentmovie has been blacklisted.');
		}

		// F**k knows, its probably fine...
		return array('status' => true);
	}

	/**
	 * Send an email
	 *
	 * @param array $commentmovie The commentmovie data.
	 * @param array $entry The entry data.
	 * @return boolean 
	 */
	private function _send_email($commentmovie, $entry)
	{
		$this->load->library('email');
		$this->load->library('user_agent');

		// Add in some extra details
		$commentmovie['slug'] = 'commentmovies';
		$commentmovie['sender_agent'] = $this->agent->browser().' '.$this->agent->version();
		$commentmovie['sender_ip'] = $this->input->ip_address();
		$commentmovie['sender_os'] = $this->agent->platform();
		$commentmovie['redirect_url'] = anchor(ltrim($entry['uri'], '/').'#'.$commentmovie['commentmovie_id']);
		$commentmovie['reply-to'] = $commentmovie['user_email'];

		//trigger the event
		return (bool) Events::trigger('email', $commentmovie);
	}

}
