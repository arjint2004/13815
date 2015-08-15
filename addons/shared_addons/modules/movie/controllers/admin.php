<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Movie\Controllers
 */
class Admin extends Admin_Controller
{
	/** @var string The current active section */
	protected $section = 'posts';
	var $inserted_id_imdbx=array();
	var $genre=array();
	/** @var array The validation rules */
	protected $validation_rules = array(
		'title' => array(
			'field' => 'title',
			'label' => 'lang:global:title',
			'rules' => 'trim|htmlspecialchars|required|max_length[200]|callback__check_title'
		),
		'slug' => array(
			'field' => 'slug',
			'label' => 'lang:global:slug',
			'rules' => 'trim|required|alpha_dot_dash|max_length[200]|callback__check_slug'
		),
		array(
			'field' => 'category_id',
			'label' => 'lang:movie:category_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'keywords',
			'label' => 'lang:global:keywords',
			'rules' => 'trim'
		),
		array(
			'field' => 'body',
			'label' => 'lang:movie:content_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'status',
			'label' => 'lang:movie:status_label',
			'rules' => 'trim|alpha'
		),
		array(
			'field' => 'created_on',
			'label' => 'lang:movie:date_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'created_on_hour',
			'label' => 'lang:movie:created_hour',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'created_on_minute',
			'label' => 'lang:movie:created_minute',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'commentmovies_enabled',
			'label' => 'lang:movie:commentmovies_enabled_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'preview_hash',
			'label' => '',
			'rules' => 'trim'
		)
	);

	/**
	 * Every time this controller controller is called should:
	 * - load the movie and movie_categories models
	 * - load the keywords and form validation libraries
	 * - set the hours, minutes and categories template variables.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->config('movie/movie');
		$this->genre=config_item('genre');
	
		$this->load->model(array('movie_m', 'movie_categories_m'));
		$this->lang->load(array('movie', 'categories'));

		$this->load->library(array('keywords/keywords', 'form_validation'));

		$_categories = array();
		if ($categories = $this->movie_categories_m->order_by('title')->get_all())
		{
			foreach ($categories as $category)
			{
				$_categories[$category->id] = $category->title;
			}
		}

		// Date ranges for select boxes
		$this->template
			->set('hours', array_combine($hours = range(0, 23), $hours))
			->set('minutes', array_combine($minutes = range(0, 59), $minutes))
			->set('categories', $_categories)

			->append_css('module::movie.css');
	}

	/**
	 * Show all created movie posts
	 */
	public function index()
	{
		//set the base/default where clause
		$base_where = array('show_future' => true, 'status' => 'all');

		//add post values to base_where if f_module is posted
		if ($this->input->post('f_category'))
		{
			$base_where['category'] = $this->input->post('f_category');
		}

		if ($this->input->post('f_status'))
		{
			$base_where['status'] = $this->input->post('f_status');
		}

		if ($this->input->post('f_keywords'))
		{
			$base_where['keywords'] = $this->input->post('f_keywords');
		}

		// Create pagination links
		$total_rows = $this->movie_m->count_by($base_where);
		$pagination = create_pagination('admin/movie/index', $total_rows);

		// Using this data, get the relevant results
		$movie = $this->movie_m
			->limit($pagination['limit'], $pagination['offset'])
			->get_many_by($base_where);

		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set_partial('filters', 'admin/partials/filters')
			->set('pagination', $pagination)
			->set('movie', $movie);

		$this->input->is_ajax_request()
			? $this->template->build('admin/tables/posts')
			: $this->template->build('admin/index');

	}

	/**
	 * sedoot imdb
	 */
	private function insertfile($namafile="",$filesize=0,$mimetype='',$ext=''){
				$this->db->query("DELETE FROM default_files WHERE name='".$namafile."'");
				$idf=substr(md5(microtime() . $namafile), 0, 15);
				$data = array(
					'id'			=> $idf,
					'folder_id'		=> 1,
					'user_id'		=> 1,
					'type'			=> "d",
					'name'			=> $namafile,
					'path'			=> '{{ url:site }}uploads/default/files/'.$namafile,
					'description'	=> '',
					'alt_attribute'	=> "undefined",
					'filename'		=> $namafile,
					'extension'		=> '.'.$ext,
					'mimetype'		=> $mimetype,
					'filesize'		=> $filesize,
					'width'			=> 0,
					'height'		=> 0,
					'date_added'	=> now()
				);
				//$this->db->where('name',$namafile);
				if($namafile!=""){
					$this->db->insert('default_files',$data);
					return $idf;
				}else{
				return 0;
				}
				
	}
	private function saveIMDB($data=array())
	{	
		$data=(array)$data;
		
		if(!in_array($data['ID IMDB'],$this->inserted_id_imdbx)){
			$created_on=strtotime(sprintf('%s %s:%s', date('Y-m-d'), date('H'), date('i')));
			role_or_die('movie', 'put_live');
			$hash = "";
			$extra = array(
				'title'            => utf8_encode($data['TITLE']),
				'slug'             => utf8_encode(str_replace(" ","_",strtolower($data['TITLE']))),
				'category_id'      => 1,
				'keywords'         => utf8_encode(Keywords::process(str_replace(" ","",$data['GENRE']).','.str_replace(" ",",",$data['TITLE']))),
				'body'             => utf8_encode($data['DESCRIPTION']),
				'status'           => 'live',
				'created_on'       => $created_on,
				'created'		   => date('Y-m-d H:i:s', $created_on),
				'commentmovies_enabled' => 'always',
				'author_id'        => $this->current_user->id,
				'type'             => 'markdown',
				'parsed'           => ('markdown' == 'markdown') ? parse_markdown(utf8_encode($data['DESCRIPTION'])) : '',
				'preview_hash'     => $hash
			);
			
				$namef=explode("/",$data['POSTER']);
				$namefc=end($namef);
				unset($namef);
				//$this->pr(end($namefc));
				$contentp = file_get_contents($data['POSTER']);
				$dir=getcwd()."/uploads/default/files/".$namefc;

				if(file_put_contents($dir, $contentp)){
					$idf=$this->insertfile($namefc,filesize($dir),$this->mime_content_type($dir),pathinfo($dir, PATHINFO_EXTENSION));
				}
				
			$_POST= array(
						'title' => utf8_encode($data['TITLE']),
						'slug' => utf8_encode(str_replace(" ","_",strtolower($data['TITLE']))),
						'status' => 'live',
						'type' => 'markdown',
						'body' => utf8_encode($data['DESCRIPTION']),
						'preview_hash' => '',
						'id_imdb' => utf8_encode($data['ID IMDB']),
						'id_tmdb' => utf8_encode($data['ID TMDB']),
						'poster' => utf8_encode($data['POSTER']),
						'genre' => utf8_encode($data['GENRE']),
						'director' => utf8_encode($data['DIRECTOR']),
						'star' => utf8_encode(str_replace(" ","",$data['STAR'])),
						'country' => utf8_encode($data['COUNTRY']),
						'language' => utf8_encode($data['LANGUAGE']),
						'release_date' => utf8_encode($data['RELEASE DATE']),
						'runtime' => utf8_encode($data['RUNTIME']),
						'backdrop' => utf8_encode($data['BACKDROP']),
						'trailer' => utf8_encode($data['TRAILER']),
						'image' => $idf,
						'category_id' => 1,
						'keywords' => utf8_encode(str_replace(" ","",$data['GENRE']).','.str_replace(" ",",",$data['TITLE'])),
						'created_on' => date('Y-m-d'),
						'created_on_hour' => date('H'),
						'created_on_minute' => date('i'),
						'commentmovies_enabled' => 'always',
						'row_edit_id' => '',
						'btnAction' => 'save'
			);
			//$this->pr($extra);
			//$this->pr($_POST);

			if ($id = $this->streams->entries->insert_entry($_POST, 'movie', 'movies', array('created'), $extra)){}
					
		}
		

	}
	
	public function sync($genrex='action',$page=null)
    { 

		$inserted_id_imdb=$this->db->query("SELECT id_imdb FROM default_movie")->result_array();
		foreach($inserted_id_imdb as $dtidmdb){
			$this->inserted_id_imdbx[]=$dtidmdb['id_imdb'];
		}
		/*$dataload=$this->crawls($genrex,2);
		
		if(!empty($dataload['movie list'])){
			foreach($dataload['movie list'] as $datatosave){
				//save to databae
				$this->saveIMDB($datatosave);
			}
		}
		$this->pr($this->inserted_id_imdbx);
		die();*/
		
		if($genrex=='All'){
			unset($this->genre[0]);
			foreach($this->genre as $genre){
				$this->crawls($genre);
			}
		}else{
			$this->crawls($genrex);
		}
    }


	private function crawls($genre='action',$page=null){
		
		if($page==null){
			$json_decode=(array)json_decode(file_get_contents('http://idmovapi.com/genre/'.$genre.'/1000'));

			for($i=0;$i<$json_decode['total movie'];$i++){
				$json_decodemovie=(array)json_decode(file_get_contents('http://idmovapi.com/genre/'.$genre.'/'.$i.''));
				foreach($json_decodemovie['movie list'] as $cx=>$datatosave){
					//save to databae
					if($cx<3){
						$this->saveIMDB($datatosave);
					}
				}
			}
		}else{
			$json_decodemovie=(array)json_decode(file_get_contents('http://idmovapi.com/genre/'.$genre.'/'.$page.''));
				foreach($json_decodemovie['movie list'] as $datatosave){
					//save to databae
					$this->saveIMDB($datatosave);
				}
		}


		//return $json_decodemovie;
	}
	private function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = @strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
	private function pr($data=array()){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	/**
	 * Create new post
	 */
	public function create()
	{

		// They are trying to put this live
		if ($this->input->post('status') == 'live')
		{
			role_or_die('movie', 'put_live');

			$hash = "";
		}
		else
		{
			$hash = $this->_preview_hash();
		}

		$post = new stdClass();

		// Get the movie stream.
		$this->load->driver('Streams');
		$stream = $this->streams->streams->get_stream('movie', 'movies');
		$stream_fields = $this->streams_m->get_stream_fields($stream->id, $stream->stream_namespace);

		// Get the validation for our custom movie fields.
		$movie_validation = $this->streams->streams->validation_array($stream->stream_slug, $stream->stream_namespace, 'new');
		
		// Combine our validation rules.
		$rules = array_merge($this->validation_rules, $movie_validation);

		// Set our validation rules
		$this->form_validation->set_rules($rules);

		if ($this->input->post('created_on'))
		{
			$created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
		}
		else
		{
			$created_on = now();
		}

		if ($this->form_validation->run())
		{
			// Insert a new movie entry.
			// These are the values that we don't pass through streams processing.
			$extra = array(
				'title'            => $this->input->post('title'),
				'slug'             => $this->input->post('slug'),
				'category_id'      => $this->input->post('category_id'),
				'keywords'         => Keywords::process($this->input->post('keywords')),
				'body'             => $this->input->post('body'),
				'status'           => $this->input->post('status'),
				'created_on'       => $created_on,
				'created'		   => date('Y-m-d H:i:s', $created_on),
				'commentmovies_enabled' => $this->input->post('commentmovies_enabled'),
				'author_id'        => $this->current_user->id,
				'type'             => $this->input->post('type'),
				'parsed'           => ($this->input->post('type') == 'markdown') ? parse_markdown($this->input->post('body')) : '',
				'preview_hash'     => $hash
			);
			
			if ($id = $this->streams->entries->insert_entry($_POST, 'movie', 'movies', array('created'), $extra))
			{
				$this->pyrocache->delete_all('movie_m');
				$this->session->set_flashdata('success', sprintf($this->lang->line('movie:post_add_success'), $this->input->post('title')));

				// Movie article has been updated, may not be anything to do with publishing though
				Events::trigger('post_created', $id);

				// They are trying to put this live
				if ($this->input->post('status') == 'live')
				{
					// Fire an event, we're posting a new movie!
					Events::trigger('post_published', $id);
				}
			}
			else
			{
				$this->session->set_flashdata('error', lang('movie:post_add_error'));
			}

			// Redirect back to the form or main page
			($this->input->post('btnAction') == 'save_exit') ? redirect('admin/movie') : redirect('admin/movie/edit/'.$id);
		}
		else
		{
			// Go through all the known fields and get the post values
			$post = new stdClass;
			foreach ($this->validation_rules as $key => $field)
			{
				$post->$field['field'] = set_value($field['field']);
			}
			$post->created_on = $created_on;

			// if it's a fresh new article lets show them the advanced editor
			$post->type or $post->type = 'wysiwyg-advanced';
		}

		// Set Values
		$values = $this->fields->set_values($stream_fields, null, 'new');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		$this->template
			->title($this->module_details['name'], lang('movie:create_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('jquery/jquery.tagsinput.js')
			->append_js('module::movie_form.js')
			->append_js('module::movie_category_form.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values))
			->set('post', $post)
			->build('admin/form');
	}

	/**
	 * Edit movie post
	 *
	 * @param int $id The ID of the movie post to edit
	 */
	public function edit($id = 0)
	{
		$id or redirect('admin/movie');

		$post = $this->movie_m->get($id);
		
		// They are trying to put this live
		if ($post->status != 'live' and $this->input->post('status') == 'live')
		{
			role_or_die('movie', 'put_live');
		}
		
		// If we have keywords before the update, we'll want to remove them from keywords_applied
		$old_keywords_hash = (trim($post->keywords) != '') ? $post->keywords : null;

		$post->keywords = Keywords::get_string($post->keywords);

		// If we have a useful date, use it
		if ($this->input->post('created_on'))
		{
			$created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
		}
		else
		{
			$created_on = $post->created_on;
		}

		// Load up streams
		$this->load->driver('Streams');
		$stream = $this->streams->streams->get_stream('movie', 'movies');
		$stream_fields = $this->streams_m->get_stream_fields($stream->id, $stream->stream_namespace);

		// Get the validation for our custom movie fields.
		$movie_validation = $this->streams->streams->validation_array($stream->stream_slug, $stream->stream_namespace, 'new');
		
		$movie_validation = array_merge($this->validation_rules, array(
			'title' => array(
				'field' => 'title',
				'label' => 'lang:global:title',
				'rules' => 'trim|htmlspecialchars|required|max_length[100]|callback__check_title['.$id.']'
			),
			'slug' => array(
				'field' => 'slug',
				'label' => 'lang:global:slug',
				'rules' => 'trim|required|alpha_dot_dash|max_length[100]|callback__check_slug['.$id.']'
			),
		));

		// Merge and set our validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $movie_validation));

		$hash = $this->input->post('preview_hash');

		if ($this->input->post('status') == 'draft' and $this->input->post('preview_hash') == '')
		{
			$hash = $this->_preview_hash();
		}
		//it is going to be published we don't need the hash
		elseif ($this->input->post('status') == 'live')
		{
			$hash = '';
		}

		if ($this->form_validation->run())
		{
			$author_id = empty($post->display_name) ? $this->current_user->id : $post->author_id;

			$extra = array(
				'title'            => $this->input->post('title'),
				'slug'             => $this->input->post('slug'),
				'category_id'      => $this->input->post('category_id'),
				'keywords'         => Keywords::process($this->input->post('keywords'), $old_keywords_hash),
				'body'             => $this->input->post('body'),
				'status'           => $this->input->post('status'),
				'created_on'       => $created_on,
				'updated_on'       => $created_on,
				'created'		   => date('Y-m-d H:i:s', $created_on),
				'updated'		   => date('Y-m-d H:i:s', $created_on),
				'commentmovies_enabled' => $this->input->post('commentmovies_enabled'),
				'author_id'        => $author_id,
				'type'             => $this->input->post('type'),
				'parsed'           => ($this->input->post('type') == 'markdown') ? parse_markdown($this->input->post('body')) : '',
				'preview_hash'     => $hash,
			);

			if ($this->streams->entries->update_entry($id, $_POST, 'movie', 'movies', array('updated'), $extra))
			{
				$this->session->set_flashdata(array('success' => sprintf(lang('movie:edit_success'), $this->input->post('title'))));

				// Movie article has been updated, may not be anything to do with publishing though
				Events::trigger('post_updated', $id);

				// They are trying to put this live
				if ($post->status != 'live' and $this->input->post('status') == 'live')
				{
					// Fire an event, we're posting a new movie!
					Events::trigger('post_published', $id);
				}
			}
			else
			{
				$this->session->set_flashdata('error', lang('movie:edit_error'));
			}

			// Redirect back to the form or main page
			($this->input->post('btnAction') == 'save_exit') ? redirect('admin/movie') : redirect('admin/movie/edit/'.$id);
		}

		// Go through all the known fields and get the post values
		foreach ($this->validation_rules as $key => $field)
		{
			if (isset($_POST[$field['field']]))
			{
				$post->$field['field'] = set_value($field['field']);
			}
		}

		$post->created_on = $created_on;

		// Set Values
		$values = $this->fields->set_values($stream_fields, $post, 'edit');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		$this->template
			->title($this->module_details['name'], sprintf(lang('movie:edit_title'), $post->title))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('jquery/jquery.tagsinput.js')
			->append_js('module::movie_form.js')
			->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values, $post->id))
			->append_css('jquery/jquery.tagsinput.css')
			->set('post', $post)
			->build('admin/form');
	}

	/**
	 * Preview movie post
	 *
	 * @param int $id The ID of the movie post to preview
	 */
	public function preview($id = 0)
	{
		$post = $this->movie_m->get($id);

		$this->template
			->set_layout('modal', 'admin')
			->set('post', $post)
			->build('admin/preview');
	}

	/**
	 * Helper method to determine what to do with selected items from form post
	 */
	public function action()
	{
		switch ($this->input->post('btnAction'))
		{
			case 'publish':
				$this->publish();
				break;

			case 'delete':
				$this->delete();
				break;

			default:
				redirect('admin/movie');
				break;
		}
	}

	/**
	 * Publish movie post
	 *
	 * @param int $id the ID of the movie post to make public
	 */
	public function publish($id = 0)
	{
		role_or_die('movie', 'put_live');

		// Publish one
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		if ( ! empty($ids))
		{
			// Go through the array of slugs to publish
			$post_titles = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($post = $this->movie_m->get($id))
				{
					$this->movie_m->publish($id);

					// Wipe cache for this model, the content has changed
					$this->pyrocache->delete('movie_m');
					$post_titles[] = $post->title;
				}
			}
		}

		// Some posts have been published
		if ( ! empty($post_titles))
		{
			// Only publishing one post
			if (count($post_titles) == 1)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('movie:publish_success'), $post_titles[0]));
			}
			// Publishing multiple posts
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('movie:mass_publish_success'), implode('", "', $post_titles)));
			}
		}
		// For some reason, none of them were published
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('movie:publish_error'));
		}

		redirect('admin/movie');
	}

	/**
	 * Delete movie post
	 *
	 * @param int $id The ID of the movie post to delete
	 */
	public function delete($id = 0)
	{
		$this->load->model('commentmovies/comment_m');
		$this->load->library('files/files');
		role_or_die('movie', 'delete_live');

		// Delete one
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		$id_file = ($id) ? array($id) : $this->input->post('id_file');

		// Go through the array of slugs to delete
		if ( ! empty($ids))
		{
			$post_titles = array();
			$deleted_ids = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($post = $this->movie_m->get($id))
				{
					if ($this->movie_m->delete($id))
					{
						$this->comment_m->where('module', 'movie')->delete_by('entry_id', $id);
						$this->pr($this->files->delete_file($id_file[$id]));
						// Wipe cache for this model, the content has changed
						$this->pyrocache->delete('movie_m');
						$post_titles[] = $post->title;
						$deleted_ids[] = $id;
					}
				}
			}

			// Fire an event. We've deleted one or more movie posts.
			Events::trigger('post_deleted', $deleted_ids);
		}

		// Some pages have been deleted
		if ( ! empty($post_titles))
		{
			// Only deleting one page
			if (count($post_titles) == 1)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('movie:delete_success'), $post_titles[0]));
			}
			// Deleting multiple pages
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('movie:mass_delete_success'), implode('", "', $post_titles)));
			}
		}
		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata('notice', lang('movie:delete_error'));
		}

		redirect('admin/movie');
	}

	/**
	 * Callback method that checks the title of an post
	 *
	 * @param string $title The Title to check
	 * @param string $id
	 *
	 * @return bool
	 */
	public function _check_title($title, $id = null)
	{
		$this->form_validation->set_message('_check_title', sprintf(lang('movie:already_exist_error'), lang('global:title')));

		return $this->movie_m->check_exists('title', $title, $id);
	}

	/**
	 * Callback method that checks the slug of an post
	 *
	 * @param string $slug The Slug to check
	 * @param null   $id
	 *
	 * @return bool
	 */
	public function _check_slug($slug, $id = null)
	{
		$this->form_validation->set_message('_check_slug', sprintf(lang('movie:already_exist_error'), lang('global:slug')));

		return $this->movie_m->check_exists('slug', $slug, $id);
	}

	/**
	 * Generate a preview hash
	 *
	 * @return bool
	 */
	private function _preview_hash()
	{
		return md5(microtime() + mt_rand(0, 1000));
	}
}
