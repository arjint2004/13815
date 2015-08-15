<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Commentmovies library
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Commentmovies\Libraries
 */

class Commentmovies
{
	/**
	 * The name of the module in use
	 * 
	 * @var	string
	 */
	protected $module;

	/**
	 * Singular language key
	 * 
	 * @var	string
	 */
	protected $singular;

	/**
	 * Plural language key
	 * 
	 * @var	string
	 */
	protected $plural;

	/**
	 * Entry for this, be it an auto increment id or string
	 * 
	 * @var	string|int
	 */
	protected $entry_id;

	/**
	 * Title of the entry
	 * 
	 * @var	string
	 */
	protected $entry_title;

	/**
	 * What is the URL of this entry?
	 * 
	 * @var	string
	 */
	protected $entry_uri;

	/**
	 * Encrypted hash containing title, singular and plural keys
	 * 
	 * @var	bool
	 */
	protected $entry_hash;

	/**
	 * Commentmovie Count
	 *
	 * Setting to 0 by default.
	 *
	 * @var 	int
	 */
	protected $count = 0;

	/**
	 * Function to display a commentmovie
	 *
	 * Reference is a actually an object reference, a.k.a. categorization of the commentmovies table rows.
	 * The reference id is a further categorization on this. (For example, for example for
	 *
	 * @param	string	$module		The name of the module in use
	 * @param	string	$singular	Singular language key
	 * @param	string	$plural		Plural language key
	 * @param	string|int	$entry_id	Entry for this, be it an auto increment id or string, or null
	 */
	public function __construct($params)
	{
		ci()->load->model('commentmovies/commentmovie_m');
		ci()->lang->load('commentmovies/commentmovies');

		// This shouldnt be required if static loading was possible, but its not in CI
		if (is_array($params))
		{
			// Required
			$this->module = $params['module'];
			$this->singular = $params['singular'];
			$this->plural = $params['plural'];

			// Overridable
			$this->entry_uri = isset($params['uri']) ? $params['uri'] : uri_string();

			// Optional
			isset($params['entry_id']) and $this->entry_id = $params['entry_id'];
			isset($params['entry_title']) and $this->entry_title = $params['entry_title'];
		}
	}
	
	/**
	 * Display commentmovies
	 *
	 * @return	string	Returns the HTML for any existing commentmovies
	 */
	public function display()
	{
		// Fetch commentmovies, then process them
		$commentmovies = $this->process(ci()->commentmovie_m->get_by_entry($this->module, $this->singular, $this->entry_id));
		
		// Return the awesome commentmovies view
		return $this->load_view('display', compact(array('commentmovies')));
	}
	
	/**
	 * Display form
	 *
	 * @return	string	Returns the HTML for the commentmovie submission form
	 */
	public function form()
	{
		// Return the awesome commentmovies view
		return $this->load_view('form', array(
			'module'		=>	$this->module,
			'entry_hash'	=>	$this->encode_entry(),
			'commentmovie'		=>  ci()->session->flashdata('commentmovie'),
		));
	}

	/**
	 * Count commentmovies
	 *
	 * @return	int	Return the number of commentmovies for this entry item
	 */
	public function count()
	{
		return (int) ci()->db->where(array(
			'module'	=> $this->module,
			'entry_key'	=> $this->singular,
			'entry_id'	=> $this->entry_id,
			'is_active'	=> true,
		))->count_all_results('commentmovies');
	}

	/**
	 * Count commentmovies as string
	 *
	 * @return	string 	Language string with the total in it
	 */
	public function count_string($commentmovie_count = null)
	{
		$total = ($commentmovie_count) ? $commentmovie_count : $this->count;

		switch ($total)
		{
			case 0:
				$line = 'none';
				break;
			case 1:
				$line = 'singular';
				break;
			default:
				$line = 'plural';
		}

		return sprintf(lang('commentmovies:counter_'.$line.'_label'), $total);
	}

	/**
	 * Function to process the items in an X amount of commentmovies
	 *
	 * @param array $commentmovies The commentmovies to process
	 * @return array
	 */
	public function process($commentmovies)
	{
		// Remember which modules have been loaded
		static $modules = array();

		foreach ($commentmovies as &$commentmovie)
		{
			// Override specified website if they are a user
			if ($commentmovie->user_id and Settings::get('enable_profiles'))
			{
				$commentmovie->website = 'user/'.$commentmovie->user_name;
			}

			// We only want to load a lang file once
			if ( ! isset($modules[$commentmovie->module]))
			{
				if (ci()->module_m->exists($commentmovie->module))
				{
					ci()->lang->load("{$commentmovie->module}/{$commentmovie->module}");

					$modules[$commentmovie->module] = true;
				}
				// If module doesn't exist (for whatever reason) then sssh!
				else
				{
					$modules[$commentmovie->module] = false;
				}
			}

			$commentmovie->singular = lang($commentmovie->entry_key) ? lang($commentmovie->entry_key) : humanize($commentmovie->entry_key);
			$commentmovie->plural = lang($commentmovie->entry_plural) ? lang($commentmovie->entry_plural) : humanize($commentmovie->entry_plural);

			// work out who did the commentmovieing
			if ($commentmovie->user_id > 0)
			{
				$commentmovie->user_name = anchor('admin/users/edit/'.$commentmovie->user_id, $commentmovie->user_name);
			}

			// Security: Escape any Lex tags
			foreach ($commentmovie as $field => $value)
			{
				$commentmovie->{$field} = escape_tags($value);
			}
		}
		
		return $commentmovies;
	}

	/**
	 * Load View
	 *
	 * @return	string	HTML of the commentmovies and form
	 */
	protected function load_view($view, $data)
	{
		$ext = pathinfo($view, PATHINFO_EXTENSION) ? '' : '.php';
		
		if (file_exists(ci()->template->get_views_path().'modules/commentmovies/'.$view.$ext))
		{
			// look in the theme for overloaded views
			$path = ci()->template->get_views_path().'modules/commentmovies/';
		}
		else
		{
			// or look in the module
			list($path, $view) = Modules::find($view, 'commentmovies', 'views/');
		}
		
		// add this view location to the array
		ci()->load->set_view_path($path);
		ci()->load->vars($data);

		return ci()->load->_ci_load(array('_ci_view' => $view, '_ci_return' => true));
	}

	/**
	 * Encode Entry
	 *
	 * @return	string	Return a hash of entry details, so we can send it via a form safely.
	 */
	protected function encode_entry()
	{
		return ci()->encrypt->encode(serialize(array(
			'id'			=>	$this->entry_id,
			'title'			=> 	$this->entry_title,
			'uri'			=>	$this->entry_uri,
			'singular'		=>	$this->singular,
			'plural'		=>	$this->plural,
		)));
	}

}