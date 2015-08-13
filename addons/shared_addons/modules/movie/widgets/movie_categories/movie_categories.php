<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show a list of movie categories.
 *
 * @author        Stephen Cozart
 * @author        PyroCMS Dev Team
 * @package       PyroCMS\Core\Modules\Movie\Widgets
 */
class Widget_Movie_categories extends Widgets
{
	public $author = 'Stephen Cozart';

	public $website = 'http://github.com/clip/';

	public $version = '1.0.0';

	public $title = array(
		'en' => 'Movie Categories',
		'br' => 'Categorias do Movie',
		'pt' => 'Categorias do Movie',
		'el' => 'Κατηγορίες Ιστολογίου',
		'fr' => 'Catégories du Movie',
		'ru' => 'Категории Блога',
		'id' => 'Kateori Movie',
            'fa' => 'مجموعه های بلاگ',
	);

	public $description = array(
		'en' => 'Show a list of movie categories',
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
		$this->load->model('movie/movie_categories_m');

		$categories = $this->movie_categories_m->order_by('title')->get_all();

		return array('categories' => $categories);
	}

}
