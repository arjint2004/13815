<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show a list of movie listbox.
 *
 * @author        Stephen Cozart
 * @author        PyroCMS Dev Team
 * @package       PyroCMS\Core\Modules\Movie\Widgets
 */
class Widget_Movie_listbox extends Widgets
{
	public $author = 'Stephen Cozart';

	public $website = 'http://github.com/clip/';

	public $version = '1.0.0';

	public $title = array(
		'en' => 'Movie Listbox',
		'br' => 'Listboxs do Movie',
		'pt' => 'Listboxs do Movie',
		'el' => 'Κατηγορίες Ιστολογίου',
		'fr' => 'Catégories du Movie',
		'ru' => 'Категории Блога',
		'id' => 'Kateori Movie',
            'fa' => 'مجموعه های بلاگ',
	);

	public $description = array(
		'en' => 'Show a list of movie listbox',
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
		$this->row_m->sql['select'][] = "(SELECT COUNT(id) FROM ".
				$this->db->protect_identifiers('comments', true)." WHERE module='movie'
				AND is_active='1' AND entry_key='movie:post' AND entry_plural='movie:posts'
				AND entry_id=".$this->db->protect_identifiers('movie.id', true).") as `comment_count`";
		$posts = $this->streams->entries->get_entries(array(
			'stream'		=> 'movie',
			'namespace'		=> 'movies',
			'limit'			=> 24,
			'where'			=> "`status` = 'live'",
			'sort'			=> "random",
			'paginate'		=> 'no',
			'pag_base'		=> site_url('movie/page'),
			'pag_segment'   => 3
		));

		$rtn=array('posts' => $posts,'tenlast' => $tenlast,'cmsn' => $cmsn);

		return $rtn;
	}

}
