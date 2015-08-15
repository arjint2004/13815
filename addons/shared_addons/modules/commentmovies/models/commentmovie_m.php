<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Commentmovie model
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Commentmovies\Models
 */
class Commentmovie_m extends MY_Model
{
    /**
     * Get a commentmovie based on the ID
	 * 
	 * @param int $id The ID of the commentmovie
	 * @return array
     */
  	public function get($id)
  	{
		return $this->db->select('c.*')
    		->select('IF(c.user_id > 0, m.display_name, c.user_name) as user_name', false)
    		->select('IF(c.user_id > 0, u.email, c.user_email) as user_email', false)
    		->select('u.username')
    		->from('commentmovies c')
    		->join('users u', 'c.user_id = u.id', 'left')
    		->join('profiles m', 'm.user_id = u.id', 'left')
    	
			// If there is a commentmovie user id, make sure the user still exists
			->where('IF(c.user_id > 0, c.user_id = u.id, 1)')
    		->where('c.id', $id)
    		->get()
    		->row();
  	}
  	
	/**
	 * Get recent commentmovies
	 *
	 * 
	 * @param int $limit The amount of commentmovies to get
	 * @param int $is_active set default to only return active commentmovies
	 * @return array
	 */
  	public function get_recent($limit = 10, $is_active = 1)
  	{
		$this->_get_all_setup();
		
    	$this->db
    		->where('c.is_active', $is_active)
    		->order_by('c.created_on', 'desc');
    	
    	if ($limit > 0)
    	{
	    	$this->db->limit($limit);
    	}
    	
    	return $this->get_all();
  	}
  	
	/**
	 * Get something based on a module item
	 *
	 * @param string $module The name of the module
	 * @param int $entry_key The singular key of the entry (E.g: blog:post or pages:page)
	 * @param int $entry_id The ID of the entry
	 * @param bool $is_active Is the commentmovie active?
	 * @return array
	 */
  	public function get_by_entry($module, $entry_key, $entry_id, $is_active = true)
  	{
		$this->_get_all_setup();
		
    	$this->db
    		->where('c.module', $module)
    		->where('c.entry_id', $entry_id)
    		->where('c.entry_key', $entry_key)
    		->where('c.is_active', $is_active)
    		->order_by('c.created_on', Settings::get('commentmovie_order'));
    	
	    return $this->get_all();
  	}
	
	/**
	 * Insert a new commentmovie
	 *
	 * @param array $input The data to insert
	 * @return bool
	 */
	public function insert($input, $skip_validation = false)
	{	
		return parent::insert(array(
			'user_id'		=> isset($input['user_id']) 	? 	$input['user_id'] 									:  0,
			'user_name'		=> isset($input['user_name'])	&& !isset($input['user_id'])	? 	ucwords(strtolower(strip_tags($input['user_name']))) : '',
			'user_email'	=> isset($input['user_email'])	&& !isset($input['user_id']) 	? 	strtolower($input['user_email']) 					: '',
			'user_website'	=> isset($input['user_website']) ? 	prep_url(strip_tags($input['user_website'])) 		: '',
			'is_active'		=> ! empty($input['is_active']),
			'commentmovie'		=> htmlspecialchars($input['commentmovie'], null, false),
			'parsed'		=> parse_markdown(htmlspecialchars($input['commentmovie'], null, false)),
			'module'		=> $input['module'],
			'entry_id'		=> $input['entry_id'],
			'entry_title'	=> $input['entry_title'],
			'entry_key'		=> $input['entry_key'],
			'entry_plural'	=> $input['entry_plural'],
			'uri'			=> ! empty($input['uri']) ? $input['uri'] : null,
			'cp_uri'		=> ! empty($input['cp_uri']) ? $input['cp_uri'] : null,
			'created_on' 	=> now(),
			'ip_address'	=> $this->input->ip_address(),
		));
	}
	
	/**
	 * Update an existing commentmovie
	 *
	 * @param int $id The ID of the commentmovie to update
	 * @param array $input The array containing the data to update
	 * @return void
	 */
	public function update($id, $input, $skip_validation = false)
	{
		return parent::update($id, array(
			'user_name'		=> isset($input['user_name']) 	? 	ucwords(strtolower(strip_tags($input['user_name']))) : '',
			'user_email'	=> isset($input['user_email']) 	? 	strtolower($input['user_email']) 					 : '',
			'user_website'	=> isset($input['user_website']) ? 	prep_url(strip_tags($input['user_website'])) 		 : '',
			'commentmovie'		=> htmlspecialchars($input['commentmovie'], null, false),
			'parsed'		=> parse_markdown(htmlspecialchars($input['commentmovie'], null, false)),
		));
	}
	
	/**
	 * Approve a commentmovie
	 *
	 * @param int $id The ID of the commentmovie to approve
	 * @return mixed
	 */
	public function approve($id)
	{
		return parent::update($id, array('is_active' => true));
	}
	
	/**
	 * Unapprove a commentmovie
	 *
	 * @param int $id The ID of the commentmovie to unapprove
	 * @return mixed
	 */
	public function unapprove($id)
	{
		return parent::update($id, array('is_active' => false));
	}

	public function get_slugs()
	{
		$this->db
			->select('commentmovies.module, modules.name')
			->distinct()
			->join('modules', 'commentmovies.module = modules.slug', 'left');

		$slugs = parent::get_all();

		$options = array();
		
		if ( ! empty($slugs))
		{
			foreach ($slugs as $slug)
			{
				if ( ! $slug->name and ($pos = strpos($slug->module, '-')) !== false)
				{
					$slug->ori_module	= $slug->module;
					$slug->module		= substr($slug->module, 0, $pos);
				}

				if ( ! $slug->name and $module = $this->module_m->get_by('slug', plural($slug->module)))
				{
					$slug->name = $module->name;
				}

				//get the module name
				if ($slug->name and $module_names = unserialize($slug->name))
				{
					if (array_key_exists(CURRENT_LANGUAGE, $module_names))
					{
						$slug->name = $module_names[CURRENT_LANGUAGE];
					}
					else
					{
						$slug->name = $module_names['en'];
					}

					if (isset($slug->ori_module))
					{
						$options[$slug->ori_module] = $slug->name . " ($slug->ori_module)";
					}
					else
					{
						$options[$slug->module] = $slug->name;
					}
				}
				else
				{
					if (isset($slug->ori_module))
					{
						$options[$slug->ori_module] = $slug->ori_module;
					}
					else
					{
						$options[$slug->module] = $slug->module;
					}
				}
			}
		}

		asort($options);

		return $options;
	}

	/**
	 * Get something based on a module item
	 *
	 * @param string $module The name of the module
	 * @param int $entry_key The singular key of the entry (E.g: blog:post or pages:page)
	 * @param int $entry_id The ID of the entry
	 * @return bool
	 */
  	public function delete_by_entry($module, $entry_key, $entry_id)
	{
    	return $this->db
    		->where('module', $module)
    		->where('entry_id', $entry_id)
    		->where('entry_key', $entry_key)
    		->delete('commentmovies');
 	}
	
	/**
	 * Setting up the query for the get* functions
	 */
	private function _get_all_setup()
	{
		$this->_table = null;
    	$this->db
    		->select('c.*')
			->from('commentmovies c')
    		->select('IF(c.user_id > 0, m.display_name, c.user_name) as user_name', false)
    		->select('IF(c.user_id > 0, u.email, c.user_email) as user_email', false)
    		->select('u.username, m.display_name')
    		->join('users u', 'c.user_id = u.id', 'left')
    		->join('profiles m', 'm.user_id = u.id', 'left');
	}
}
