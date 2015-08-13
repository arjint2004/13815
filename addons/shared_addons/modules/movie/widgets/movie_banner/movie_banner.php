<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show a list of movie banner.
 *
 * @author        Stephen Cozart
 * @author        PyroCMS Dev Team
 * @package       PyroCMS\Core\Modules\Movie\Widgets
 */
class Widget_Movie_banner extends Widgets
{
	public $author = 'Stephen Cozart';

	public $website = 'http://github.com/clip/';

	public $version = '1.0.0';

	public $title = array(
		'en' => 'Movie Banner',
		'br' => 'Banners do Movie',
		'pt' => 'Banners do Movie',
		'el' => 'Κατηγορίες Ιστολογίου',
		'fr' => 'Catégories du Movie',
		'ru' => 'Категории Блога',
		'id' => 'Kateori Movie',
            'fa' => 'مجموعه های بلاگ',
	);

	public $description = array(
		'en' => 'Show a list of movie banner',
		'br' => 'Mostra uma lista de navegação com as categorias do Movie',
		'pt' => 'Mostra uma lista de navegação com as categorias do Movie',
		'el' => 'Προβάλει την λίστα των κατηγοριών του ιστολογίου σας',
		'fr' => 'Permet d\'afficher la liste de Catégories du Movie',
		'ru' => 'Выводит список категорий блога',
		'id' => 'Menampilkan daftar kategori tulisan',
            'fa' => 'نمایش لیستی از مجموعه های بلاگ',
	);

	public function run()
	{
		$this->load->driver('Streams');

		$posts = $this->streams->entries->get_entries(array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> 1,
			'where'			=> "`status` = 'live'",
			'sort'	=> "random",
			'paginate'		=> 'no',
			'pag_base'		=> site_url('movie/page'),
			'pag_segment'   => 3
		));
		$tenlast = $this->streams->entries->get_entries(array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> 10,
			'where'			=> "`status` = 'live'",
			'order_by'			=> "release_date",
			'paginate'		=> 'no',
			'pag_base'		=> site_url('movie/page'),
			'pag_segment'   => 3
		));
		$cmsn = $this->streams->entries->get_entries(array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> 10,
			'where'			=> "`status` = 'live' AND date(release_date)>".date('Y-m-d')."",
			'order_by'			=> "release_date",
			'paginate'		=> 'no',
			'pag_base'		=> site_url('movie/page'),
			'pag_segment'   => 3
		));
		$rtn=array('posts' => $posts,'tenlast' => $tenlast,'cmsn' => $cmsn);

		return $rtn;
	}

}
