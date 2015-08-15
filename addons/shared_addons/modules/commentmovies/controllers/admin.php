<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Commentmovies\Controllers
 */
class Admin extends Admin_Controller {

	/**
	 * Array that contains the validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'user_name',
			'label' => 'lang:commentmovies:name_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'user_email',
			'label' => 'lang:global:email',
			'rules' => 'trim|valid_email'
		),
		array(
			'field' => 'user_website',
			'label' => 'lang:commentmovies:website_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'commentmovie',
			'label' => 'lang:commentmovies:send_label',
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

		// Load the required libraries, models, etc
		$this->load->library('form_validation');
		$this->load->library('commentmovies');
		$this->load->helper('user');
		$this->load->model(array('commentmovie_m', 'commentmovie_blacklists_m'));
		$this->lang->load('commentmovies');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * Index
	 * 
	 * @return void
	 */
	public function index()
	{
		// Only show is_active = 0 if we are moderating commentmovies
		$base_where = array('commentmovies.is_active' => (int) ! Settings::get('moderate_commentmovies'));

		//capture active
		$base_where['commentmovies.is_active'] = is_int($this->session->flashdata('is_active')) ? $this->session->flashdata('is_active') : $base_where['commentmovies.is_active'];
		$base_where['commentmovies.is_active'] = $this->input->post('f_active') ? (int) $this->input->post('f_active') : $base_where['commentmovies.is_active'];

		//capture module slug
		$base_where = $this->input->post('module_slug') ? $base_where + array('module' => $this->input->post('module_slug')) : $base_where;

		// Create pagination links
		$total_rows = $this->commentmovie_m->count_by($base_where);
		$pagination = create_pagination('admin/commentmovies/index', $total_rows);

		$commentmovies = $this->commentmovie_m
			->limit($pagination['limit'], $pagination['offset'])
			->order_by('commentmovies.created_on', 'desc')
			->get_many_by($base_where);

		$content_title = $base_where['commentmovies.is_active'] ? lang('commentmovies:active_title') : lang('commentmovies:inactive_title');

		$this->input->is_ajax_request() && $this->template->set_layout(false);

		$module_list = $this->commentmovie_m->get_slugs();

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set('module_list',		$module_list)
			->set('content_title',		$content_title)
			->set('commentmovies',			$this->commentmovies->process($commentmovies))
			->set('commentmovies_active',	$base_where['commentmovies.is_active'])
			->set('pagination',			$pagination);
			
		$this->input->is_ajax_request() ? $this->template->build('admin/tables/commentmovies') : $this->template->build('admin/index');
	}

	/**
	 * Action method, called whenever the user submits the form
	 * 
	 * @return void
	 */
	public function action()
	{
		$action = strtolower($this->input->post('btnAction'));

		if ($action)
		{
			// Get the id('s)
			$id_array = $this->input->post('action_to');

			// Call the action we want to do
			if (method_exists($this, $action))
			{
				$this->{$action}($id_array);
			}
		}

		redirect('admin/commentmovies');
	}

	/**
	 * Edit an existing commentmovie
	 * 
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id or redirect('admin/commentmovies');

		// Get the commentmovie based on the ID
		$commentmovie = $this->commentmovie_m->get($id);

		// Validate the results
		if ($this->form_validation->run())
		{
			if ($commentmovie->user_id > 0)
			{
				$commentmovieer['user_id'] = $this->input->post('user_id');
			}
			else
			{
				$commentmovieer['user_name']	= $this->input->post('user_name');
				$commentmovieer['user_email'] = $this->input->post('user_email');
			}

			$commentmovie = array_merge($commentmovieer, array(
				'user_website' => $this->input->post('user_website'),
				'commentmovie' => $this->input->post('commentmovie'),
			));

			// Update the commentmovie
			$this->commentmovie_m->update($id, $commentmovie)
				? $this->session->set_flashdata('success', lang('commentmovies:edit_success'))
				: $this->session->set_flashdata('error', lang('commentmovies:edit_error'));

			// Fire an event. A commentmovie has been updated.
			Events::trigger('commentmovie_updated', $id);

			redirect('admin/commentmovies');
		}

		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== null)
			{
				$commentmovie->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('commentmovies:edit_title'), $commentmovie->id))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->set('commentmovie', $commentmovie)
			->build('admin/form');
	}

	// Admin: report a commentmovie to local tables/Akismet as spam
	public function report($id)
	{
		$api_key = Settings::get('akismet_api_key_movie');
		$commentmovie = $this->commentmovie_m->get($id);
		if ( ! empty($api_key))
		{	
			$akismet = $this->load->library('akismet');
			$commentmovie_array = array(
				'user_name' => $commentmovie->user_name,
				'user_website' => $commentmovie->user_website,
				'user_email' => $commentmovie->user_email,
				'body' => $commentmovie->commentmovie
			);
      
			$config = array(
				'blog_url' => BASE_URL,
				'api_key' => $api_key,
				'commentmovie' => $commentmovie_array
			);

			$akismet->init($config);

			//expecting to see $commentmovie as an array not an object...
			$akismet->submit_spam();          
		}
            
		$this->commentmovie_blacklists_m->save(array(
			'website' => $commentmovie->user_website,
			'email' => $commentmovie->user_email
		));

		$this->delete($id);

		redirect('admin/commentmovies');	
	}

        // Admin: Delete a commentmovie
	public function delete($ids)
	{
		// Check for one
		$ids = ( ! is_array($ids)) ? array($ids) : $ids;

		// Go through the array of ids to delete
		$commentmovies = array();
		foreach ($ids as $id)
		{
			// Get the current commentmovie so we can grab the id too
			if ($commentmovie = $this->commentmovie_m->get($id))
			{
				$this->commentmovie_m->delete((int) $id);

				// Wipe cache for this model, the content has changed
				$this->pyrocache->delete('commentmovie_m');
				$commentmovies[] = $commentmovie->id;
			}
		}

		// Some commentmovies have been deleted
		if ( ! empty($commentmovies))
		{
			(count($commentmovies) == 1)
				? $this->session->set_flashdata('success', sprintf(lang('commentmovies:delete_single_success'), $commentmovies[0]))				/* Only deleting one commentmovie */
				: $this->session->set_flashdata('success', sprintf(lang('commentmovies:delete_multi_success'), implode(', #', $commentmovies )));	/* Deleting multiple commentmovies */
		
			// Fire an event. One or more commentmovies were deleted.
			Events::trigger('commentmovie_deleted', $commentmovies);
		}

		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata('error', lang('commentmovies:delete_error'));
		}

		redirect('admin/commentmovies');
	}

	/**
	 * Approve a commentmovie
	 * 
	 * @param  mixed $ids		id or array of ids to process
	 * @param  bool $redirect	optional if a redirect should be done
	 * @return void
	 */
	public function approve($id = 0, $redirect = true)
	{
		$id && $this->_do_action($id, 'approve');

		$redirect AND redirect('admin/commentmovies');
	}

	/**
	 * Unapprove a commentmovie
	 * 
	 * @param  mixed $ids		id or array of ids to process
	 * @param  bool $redirect	optional if a redirect should be done
	 * @return void
	 */
	public function unapprove($id = 0, $redirect = true)
	{
		$id && $this->_do_action($id, 'unapprove');

		if ($redirect)
		{
			$this->session->set_flashdata('is_active', 1);

			redirect('admin/commentmovies');
		}
	}

	/**
	 * Do the actual work for approve/unapprove
	 * @access protected
	 * @param  int|array $ids	id or array of ids to process
	 * @param  string $action	action to take: maps to model
	 * @return void
	 */
	protected function _do_action($ids, $action)
	{
		$ids		= ( ! is_array($ids)) ? array($ids) : $ids;
		$multiple	= (count($ids) > 1) ? '_multiple' : null;
		$status		= 'success';

		foreach ($ids as $id)
		{
			if ( ! $this->commentmovie_m->{$action}($id))
			{
				$status = 'error';
				break;
			}

			if ($action == 'approve')
			{
				// add an event so third-party devs can hook on
				Events::trigger('commentmovie_approved', $this->commentmovie_m->get($id));
			}
			else
			{
				Events::trigger('commentmovie_unapproved', $id);
			}
		}

		$this->session->set_flashdata(array($status => lang('commentmovies:' . $action . '_' . $status . $multiple)));
	}

	public function preview($id = 0)
	{
		$this->template
			->set_layout(false)
			->set('commentmovie', $this->commentmovie_m->get($id))
			->build('admin/preview');
	}

}
