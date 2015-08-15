<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Commentmovies Plugin
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Commentmovies\Plugins
 */
class Plugin_Commentmovies extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Commentmovies',
		'br' => 'Comentários',
            'fa'  => 'نظرات',
	);
	public $description = array(
		'en' => 'Display information about site commentmovies.',
		'br' => 'Exibe informações sobre comentários no site.',
            'fa' => 'نمایش اطلاعاتی در مورد کامنت های سایت',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncommentmovie the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'count' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Display the number of commentmovies for the specified item.',
					'br' => 'Exibe o número de comentários sobre o item especificado.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'entry_id' => array(// this is the order-dir="asc" attribute
						'type' => 'number|text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',
						'default' => '0',// attribute defaults to this if no value is given
						'required' => true,// is this attribute required?
					),
					'entry_key' => array(
						'type' => 'text|lang',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'module' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => 'current module',
						'required' => false,
					),
				),
			),// end first method
			'count_string' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Display the commentmovie count as a translated string.',
					'br' => 'Exibe a contagem de comentários como uma string traduzida.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'entry_id' => array(// this is the order-dir="asc" attribute
						'type' => 'number|text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',
						'default' => '0',// attribute defaults to this if no value is given
						'required' => true,// is this attribute required?
					),
					'entry_key' => array(
						'type' => 'text|lang',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'module' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => 'current module',
						'required' => false,
					),
				),
			),// end second method
			'display' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output the commentmovies html for the specified item.',
					'br' => 'Exibe o código HTML dos comentários do item especificado.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'entry_id' => array(// this is the order-dir="asc" attribute
						'type' => 'number|text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',
						'default' => '0',// attribute defaults to this if no value is given
						'required' => true,// is this attribute required?
					),
					'entry_key' => array(
						'type' => 'text|lang',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'module' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => 'current module',
						'required' => false,
					),
				),
			),// end third method
		);
	
		return $info;
	}

	/**
	 * Count
	 *
	 * Usage:
	 * {{ commentmovies:count entry_id=page:id entry_key="pages:page" [module="pages"] }}
	 *
	 * @param array
	 * @return array
	 */
	public function count()
	{
		$entry_id 	= $this->attribute('entry_id', $this->attribute('item_id'));
		$entry_key 	= $this->attribute('entry_key');
		$module  	= $this->attribute('module', $this->module);
		
		$this->load->library('commentmovies/commentmovies', 
			array(
				'entry_id' => $entry_id, 
				'singular' => $entry_key, 
				'module' => $module
				)
			);
		
		return $this->commentmovies->count();
	}

	/**
	 * Count and return a translated string
	 *
	 * Usage:
	 * {{ commentmovies:count_string entry_id=page:id entry_key="pages:page" [module="pages"] }}
	 *
	 * @param array
	 * @return array
	 */
	public function count_string()
	{
		// Are we passing a number directly?
		if ($commentmovie_count = $this->attribute('count')) {
			$this->load->library('commentmovies/commentmovies');
			return $this->commentmovies->count_string($commentmovie_count);
		}

		$entry_id 		= $this->attribute('entry_id', $this->attribute('item_id'));
		$entry_key 		= $this->attribute('entry_key');
		$entry_plural 	= $this->attribute('entry_plural');
		$module  		= $this->attribute('module', $this->module);
		
		$this->load->library('commentmovies/commentmovies', 
			array(
				'entry_id' => $entry_id, 
				'singular' => $entry_key,
				'plural' => $entry_plural,
				'module' => $module
				)
			);
		
		return $this->commentmovies->count_string();
	}

	/**
	 * Display
	 *
	 * Usage:
	 * {{ commentmovies:display entry_id=page:id entry_key="pages:page" [module="pages"] }}
	 *
	 * @param array
	 * @return array
	 */
	public function display()
	{
		$entry_id 	= $this->attribute('entry_id', $this->attribute('item_id'));
		$entry_key 	= $this->attribute('entry_key');
		$module  	= $this->attribute('module', $this->module);
		
		$this->load->library('commentmovies/commentmovies', 
			array(
				'entry_id' => $entry_id, 
				'singular' => $entry_key, 
				'module' => $module
				)
			);
		
		return $this->commentmovies->display();
	}
}

/* End of file plugin.php */
