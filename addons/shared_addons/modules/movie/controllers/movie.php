<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Public Movie module controller
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Movie\Controllers
 */
class Movie extends Public_Controller
{
	public $stream;

	/**
	 * Every time this controller is called should:
	 * - load the movie and movie_categories models.
	 * - load the keywords library.
	 * - load the movie language file.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('movie_m');
		$this->load->model('movie_categories_m');
		$this->load->library(array('keywords/keywords'));
		$this->lang->load('movie');
		$this->load->config('movie/movie');
		$this->load->driver('Streams');

		// We are going to get all the categories so we can
		// easily access them later when processing posts.
		$cates = $this->db->get('movie_categories')->result_array();
		$this->categories = array();
	
		foreach ($cates as $cate)
		{
			$this->categories[$cate['id']] = $cate;
		}

		// Get movie stream. We use this to set the template
		// stream throughout the movie module.
		$this->stream = $this->streams_m->get_stream('movie', true, 'movies');
	}

	/**
	 * Index
	 *
	 * List out the movie posts.
	 *
	 * URIs such as `movie/page/x` also route here.
	 */
	public function homec($page=1)
	{
		$_GET['page']=$page;
		$post[0]['headfoot']='home_movie';		
		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb(lang('movie:movie_title'))
			->set_metadata('og:title', $this->module_details['name'], 'og')
			->set_metadata('og:type', 'movie', 'og')
			->set_metadata('og:url', current_url(), 'og')
			//->set_metadata('og:description', $meta['description'], 'og')
			//->set_metadata('description', $meta['description'])
			//->set_metadata('keywords', $meta['keywords'])
			->set_stream($this->stream->stream_slug, $this->stream->stream_namespace)
			->set('post', $post)
			//->set('genre', config_item('genre'))
			//->set('pagination', $posts['pagination'])
			->build('home');
	}

	public function search()
	{
		$like="";
		if(isset($_POST['searchtype'])){
			switch($_POST['searchtype']){
				case"category":
					$like=" AND genre LIKE '%".$_POST['search-input']."%'";
				break;
				case"title":
					$like=" AND title LIKE '%".$_POST['search-input']."%'";
				break;
				case"actor":
					$like=" AND star LIKE '%".$_POST['search-input']."%'";
				break;
				case"director":
					$like=" AND director LIKE '%".$_POST['search-input']."%'";
				break;
				case"country":
					$like=" AND country LIKE '%".$_POST['search-input']."%'";
				break;
			}
		}
		// Get our comment count whil we're at it.
		$this->row_m->sql['select'][] = "(SELECT COUNT(id) FROM ".
				$this->db->protect_identifiers('comments', true)." WHERE module='movie'
				AND is_active='1' AND entry_key='movie:post' AND entry_plural='movie:posts'
				AND entry_id=".$this->db->protect_identifiers('movie.id', true).") as `comment_count`";

		// Get the latest movie posts
		$posts = $this->streams->entries->get_entries(array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live' ".$like."",
			'paginate'		=> 'yes',
			'pag_base'		=> site_url('movie/search'),
			'pag_segment'   => 3
		));

		// Process posts
		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		$data = array(
			'pagination' => $posts['pagination'],
			'posts' => $posts['entries']
		);

		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb(lang('movie:movie_title'))
			->set_metadata('og:title', $this->module_details['name'], 'og')
			->set_metadata('og:type', 'movie', 'og')
			->set_metadata('og:url', current_url(), 'og')
			->set_metadata('og:description', $meta['description'], 'og')
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->set_stream($this->stream->stream_slug, $this->stream->stream_namespace)
			->set('posts', $posts['entries'])
			->set('genre', config_item('genre'))
			->set('pagination', $posts['pagination'])
			->build('posts');
	}	
	public function index($genre=null)
	{ 
		if($genre!=null){$like=" AND genre LIKE '%".$genre."%'";}else{$like="";}
		if(isset($_GET['genre'])){$like=" AND genre LIKE '%".$_GET['genre']."%'"; 
		}elseif(isset($_GET['year'])){$like=" AND year(release_date)='".$_GET['year']."'";
		}elseif(isset($_GET['date'])){$like=" AND release_date='".$_GET['date']."'";}else{$like="";}
		
		//print_r($like);		
		// Get our comment count whil we're at it.
		$this->row_m->sql['select'][] = "(SELECT COUNT(id) FROM ".
				$this->db->protect_identifiers('comments', true)." WHERE module='movie'
				AND is_active='1' AND entry_key='movie:post' AND entry_plural='movie:posts'
				AND entry_id=".$this->db->protect_identifiers('movie.id', true).") as `comment_count`";

		// Get the latest movie posts
		$posts = $this->streams->entries->get_entries(array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live' ".$like."",
			'paginate'		=> 'yes',
			'pag_base'		=> site_url('movie/page'),
			'pag_segment'   => 3
		));

		// Process posts
		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		$data = array(
			'pagination' => $posts['pagination'],
			'posts' => $posts['entries']
		);

		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb(lang('movie:movie_title'))
			->set_metadata('og:title', $this->module_details['name'], 'og')
			->set_metadata('og:type', 'movie', 'og')
			->set_metadata('og:url', current_url(), 'og')
			->set_metadata('og:description', $meta['description'], 'og')
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->set_stream($this->stream->stream_slug, $this->stream->stream_namespace)
			->set('posts', $posts['entries'])
			->set('genre', config_item('genre'))
			->set('pagination', $posts['pagination'])
			->build('posts');
	}

	/**
	 * Lists the posts in a specific category.
	 *
	 * @param string $slug The slug of the category.
	 */
	public function category($slug = '')
	{
		$slug or redirect('movie');

		// Get category data
		$category = $this->movie_categories_m->get_by('slug', $slug) OR show_404();

		// Get the movie posts
		$params = array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live' AND `category_id` = '{$category->id}'",
			'paginate'		=> 'yes',
			'pag_segment'	=> 4
		);
		$posts = $this->streams->entries->get_entries($params);

		// Process posts
		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		// Build the page
		$this->template->title($this->module_details['name'], $category->title)
			->set_metadata('description', $category->title.'. '.$meta['description'])
			->set_metadata('keywords', $category->title)
			->set_breadcrumb(lang('movie:movie_title'), 'movie')
			->set_breadcrumb($category->title)
			->set('pagination', $posts['pagination'])
			->set_stream($this->stream->stream_slug, $this->stream->stream_namespace)
			->set('posts', $posts['entries'])
			->set('category', (array)$category)
			->build('posts');
	}

	/**
	 * Lists the posts in a specific year/month.
	 *
	 * @param null|string $year  The year to show the posts for.
	 * @param string      $month The month to show the posts for.
	 */
	public function archive($year = null, $month = '01')
	{
		$year or $year = date('Y');
		$month_date = new DateTime($year.'-'.$month.'-01');

		// Get the movie posts
		$params = array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live'",
			'year'			=> $year,
			'month'			=> $month,
			'paginate'		=> 'yes',
			'pag_segment'	=> 5
		);
		$posts = $this->streams->entries->get_entries($params);

		$month_year = format_date($month_date->format('U'), lang('movie:archive_date_format'));

		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);
		
		$this->template
			->title($month_year, lang('movie:archive_title'), lang('movie:movie_title'))
			->set_metadata('description', $month_year.'. '.$meta['description'])
			->set_metadata('keywords', $month_year.', '.$meta['keywords'])
			->set_breadcrumb(lang('movie:movie_title'), 'movie')
			->set_breadcrumb(lang('movie:archive_title').': '.format_date($month_date->format('U'), lang('movie:archive_date_format')))
			->set('pagination', $posts['pagination'])
			->set_stream($this->stream->stream_slug, $this->stream->stream_namespace)
			->set('posts', $posts['entries'])
			->set('month_year', $month_year)
			->build('archive');
	}

	/**
	 * View a post
	 *
	 * @param string $slug The slug of the movie post.
	 */
	public function view($slug = '')
	{
		// We need a slug to make this work.
		if ( ! $slug)
		{
			redirect('movie');
		}
		$this->row_m->sql['select'][] = "(SELECT COUNT(id) FROM ".
				$this->db->protect_identifiers('comments', true)." WHERE module='movie'
				AND is_active='1' AND entry_key='movie:post' AND entry_plural='movie:posts'
				AND entry_id=".$this->db->protect_identifiers('movie.id', true).") as `comment_count`";
		$params = array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> 1,
			'where'			=> "`slug` = '{$slug}'"
		);
		$data = $this->streams->entries->get_entries($params);
		$post = (isset($data['entries'][0])) ? $data['entries'][0] : null;
		$post['headfoot']='detail_movie';
		if ( ! $post or ($post['status'] !== 'live' and ! $this->ion_auth->is_admin()))
		{
			redirect('movie');
		}
		$ognr=explode("&#44; ",$post['genre']);

		$post['others']=$this->db->query("SELECT m.created_on,m.slug,m.title,m.id_imdb,f.path,f.filename FROM  ".$this->db->protect_identifiers('movie', true)." m JOIN ".$this->db->protect_identifiers('files', true)." f ON m.image=f.id WHERE m.genre LIKE '%".$ognr[0]."%' ORDER BY RAND() LIMIT 10")->result_array();
		//echo "<pre>";
		//print_r($other);
		$this->_single_view($post);
	}

	/**
	 * Preview a post
	 *
	 * @param string $hash the preview_hash of post
	 */
	public function preview($hash = '')
	{
		if ( ! $hash)
		{
			redirect('movie');
		}

		$params = array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> 1,
			'where'			=> "`preview_hash` = '{$hash}'"
		);
		$data = $this->streams->entries->get_entries($params);
		$post = (isset($data['entries'][0])) ? $data['entries'][0] : null;

		if ( ! $post)
		{
			redirect('movie');
		}

		if ($post['status'] === 'live')
		{
			redirect('movie/'.date('Y/m', $post['created_on']).'/'.$post['slug']);
		}

		// Set index nofollow to attempt to avoid search engine indexing
		$this->template->set_metadata('index', 'nofollow');

		$this->_single_view($post);
	}

	/**
	 * Tagged Posts
	 *
	 * Displays movie posts tagged with a
	 * tag (pulled from the URI)
	 *
	 * @param string $tag
	 */
	public function tagged($tag = '')
	{
		// decode encoded cyrillic characters
		$tag = rawurldecode($tag) or redirect('movie');

		// Here we need to add some custom joins into the
		// row query. This shouldn't be in the controller, but
		// we need to figure out where this sort of stuff should go.
		// Maybe the entire movie moduel should be replaced with stream
		// calls with items like this. Otherwise, this currently works.
		$this->row_m->sql['join'][] = 'JOIN '.$this->db->protect_identifiers('keywords_applied', true).' ON '.
			$this->db->protect_identifiers('keywords_applied.hash', true).' = '.
			$this->db->protect_identifiers('movie.keywords', true);

		$this->row_m->sql['join'][] = 'JOIN '.$this->db->protect_identifiers('keywords', true).' ON '.
			$this->db->protect_identifiers('keywords.id', true).' = '.
			$this->db->protect_identifiers('keywords_applied.keyword_id', true);	

		$this->row_m->sql['where'][] = $this->db->protect_identifiers('keywords.name', true)." = '".str_replace('-', ' ', $tag)."'";

		// Get the movie posts
		$params = array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live'",
			'paginate'		=> 'yes',
			'pag_segment'	=> 4
		);
		$posts = $this->streams->entries->get_entries($params);

		// Process posts
		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		$name = str_replace('-', ' ', $tag);

		// Build the page
		$this->template
			->title($this->module_details['name'], lang('movie:tagged_label').': '.$name)
			->set_metadata('description', lang('movie:tagged_label').': '.$name.'. '.$meta['description'])
			->set_metadata('keywords', $name)
			->set_breadcrumb(lang('movie:movie_title'), 'movie')
			->set_breadcrumb(lang('movie:tagged_label').': '.$name)
			->set('pagination', $posts['pagination'])
			->set_stream($this->stream->stream_slug, $this->stream->stream_namespace)
			->set('posts', $posts['entries'])
			->set('tag', $tag)
			->build('posts');
	}

	/**
	 * Process Post
	 *
	 * Process data that was not part of the 
	 * initial streams call.
	 *
	 * @return 	void
	 */
	private function _process_post(&$post)
	{
		$this->load->helper('text');

		// Keywords array
		$keywords = Keywords::get($post['keywords']);
		$formatted_keywords = array();
		$keywords_arr = array();

		foreach ($keywords as $key)
		{
			$formatted_keywords[] 	= array('keyword' => $key->name);
			$keywords_arr[] 		= $key->name;

		}
		$post['keywords'] = $formatted_keywords;
		$post['keywords_arr'] = $keywords_arr;

		// Full URL for convenience.
		$post['url'] = site_url('movie/'.date('Y/m', $post['created_on']).'/'.$post['slug']);
	
		// What is the preview? If there is a field called intro,
		// we will use that, otherwise we will cut down the movie post itself.
		$post['preview'] = (isset($post['intro'])) ? $post['intro'] : $post['body'];

		// Category
		if ($post['category_id'] > 0 and isset($this->categories[$post['category_id']]))
		{
			$post['category'] = $this->categories[$post['category_id']];
		}
	}

	/**
	 * Posts Metadata
	 *
	 * @param array $posts
	 *
	 * @return array keywords and description
	 */
	private function _posts_metadata(&$posts = array())
	{
		$keywords = array();
		$description = array();

		// Loop through posts and use titles for meta description
		if ( ! empty($posts))
		{
			foreach ($posts as &$post)
			{
				if (isset($post['category']) and ! in_array($post['category']['title'], $keywords))
				{
					$keywords[] = $post['category']['title'];
				}

				$description[] = $post['title'];
			}
		}

		return array(
			'keywords' => implode(', ', $keywords),
			'description' => implode(', ', $description)
		);
	}

	/**
	 * Single View
	 *
	 * Generate a page for viewing a single
	 * movie post.
	 *
	 * @access 	private
	 * @param 	array $post The post to view
	 * @return 	void
	 */
	private function _single_view($post)
	{
		// if it uses markdown then display the parsed version
		if ($post['type'] === 'markdown')
		{
			$post['body'] = $post['parsed'];
		}

		$this->session->set_flashdata(array('referrer' => $this->uri->uri_string()));

		$this->template->set_breadcrumb(lang('movie:movie_title'), 'movie');

		if ($post['category_id'] > 0)
		{
			// Get the category. We'll just do it ourselves
			// since we need an array.
			if ($category = $this->db->limit(1)->where('id', $post['category_id'])->get('movie_categories')->row_array())
			{
				$this->template->set_breadcrumb($category['title'], 'movie/category/'.$category['slug']);

				// Set category OG metadata			
				$this->template->set_metadata('article:section', $category['title'], 'og');

				// Add to $post
				$post['category'] = $category;
			}
		}

		$this->_process_post($post);

		// Add in OG keywords
		foreach ($post['keywords_arr'] as $keyword)
		{
			$this->template->set_metadata('article:tag', $keyword, 'og');
		}

		// If comments are enabled, go fetch them all
		if (Settings::get('enable_comments'))
		{
			// Load Comments so we can work out what to do with them
			$this->load->library('comments/comments', array(
				'entry_id' => $post['id'],
				'entry_title' => $post['title'],
				'module' => 'movie',
				'singular' => 'movie:post',
				'plural' => 'movie:posts',
			));

			// Comments enabled can be 'no', 'always', or a strtotime compatable difference string, so "2 weeks"
			$this->template->set('form_display', (
				$post['comments_enabled'] === 'always' or
					($post['comments_enabled'] !== 'no' and time() < strtotime('+'.$post['comments_enabled'], $post['created_on']))
			));
		}

		$this->template
			->title($post['title'], lang('movie:movie_title'))
			->set_metadata('og:type', 'article', 'og')
			->set_metadata('og:url', current_url(), 'og')
			->set_metadata('og:title', $post['title'], 'og')
			->set_metadata('og:site_name', Settings::get('site_name'), 'og')
			->set_metadata('og:description', $post['preview'], 'og')
			->set_metadata('article:published_time', date(DATE_ISO8601, $post['created_on']), 'og')
			->set_metadata('article:modified_time', date(DATE_ISO8601, $post['updated_on']), 'og')
			->set_metadata('description', $post['preview'])
			->set_metadata('keywords', implode(', ', $post['keywords_arr']))
			->set_breadcrumb($post['title'])
			->set_stream($this->stream->stream_slug, $this->stream->stream_namespace)
			->set('post', array($post))
			->build('view');
	}
}
