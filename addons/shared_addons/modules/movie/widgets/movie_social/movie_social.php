<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show a list of movie social.
 *
 * @author        Stephen Cozart
 * @author        PyroCMS Dev Team
 * @package       PyroCMS\Core\Modules\Movie\Widgets
 */
class Widget_Movie_social extends Widgets
{
	public $author = 'Stephen Cozart';

	public $website = 'http://github.com/clip/';

	public $version = '1.0.0';

	public $title = array(
		'en' => 'Movie Social',
		'br' => 'Socials do Movie',
		'pt' => 'Socials do Movie',
		'el' => 'Κατηγορίες Ιστολογίου',
		'fr' => 'Catégories du Movie',
		'ru' => 'Категории Блога',
		'id' => 'Kateori Movie',
            'fa' => 'مجموعه های بلاگ',
	);

	public $description = array(
		'en' => 'Show a list of movie social',
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
		/*$this->load->driver('Streams');	
			'stream'		=> 'b',
		$posts = $this->streams->entries->get_entries(array(
			'namespace'		=> 'movies',
			'limit'			=> 3,
			'where'			=> "`status` = 'live'",
			'paginate'		=> 'no',
			'pag_base'		=> site_url('movie/page'),
			'pag_segment'   => 3
		));
		$rtn=array('posts' => $posts,'tenlast' => $tenlast,'cmsn' => $cmsn);*/
	}

}
