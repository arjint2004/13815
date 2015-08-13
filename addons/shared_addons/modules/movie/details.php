<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Movie module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Movie
 */
class Module_Movie extends Module
{
	public $version = '2.0.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Movie',
				'ar' => 'المدوّنة',
				'br' => 'Movie',
				'pt' => 'Movie',
				'el' => 'Ιστολόγιο',
                            'fa' => 'بلاگ',
				'he' => 'בלוג',
				'id' => 'Movie',
				'lt' => 'Movieas',
				'pl' => 'Movie',
				'ru' => 'Блог',
				'tw' => '文章',
				'cn' => '文章',
				'hu' => 'Movie',
				'fi' => 'Moviei',
				'th' => 'บล็อก',
				'se' => 'Movieg',
			),
			'description' => array(
				'en' => 'Post movie entries.',
				'ar' => 'أنشر المقالات على مدوّنتك.',
				'br' => 'Escrever publicações de movie',
				'pt' => 'Escrever e editar publicações no movie',
				'cs' => 'Publikujte nové články a příspěvky na movie.', #update translation
				'da' => 'Skriv movieindlæg',
				'de' => 'Veröffentliche neue Artikel und Movie-Einträge', #update translation
				'sl' => 'Objavite movie prispevke',
				'fi' => 'Kirjoita moviei artikkeleita.',
				'el' => 'Δημιουργήστε άρθρα και εγγραφές στο ιστολόγιο σας.',
				'es' => 'Escribe entradas para los artículos y movie (web log).', #update translation
                                'fa' => 'مقالات منتشر شده در بلاگ',
				'fr' => 'Poster des articles d\'actualités.',
				'he' => 'ניהול בלוג',
				'id' => 'Post entri movie',
				'it' => 'Pubblica notizie e post per il movie.', #update translation
				'lt' => 'Rašykite naujienas bei movie\'o įrašus.',
				'nl' => 'Post nieuwsartikelen en movies op uw site.',
				'pl' => 'Dodawaj nowe wpisy na movieu',
				'ru' => 'Управление записями блога.',
				'tw' => '發表新聞訊息、部落格等文章。',
				'cn' => '发表新闻讯息、部落格等文章。',
				'th' => 'โพสต์รายการบล็อก',
				'hu' => 'Movie bejegyzések létrehozása.',
				'se' => 'Inlägg i moviegen.',
			),
			'frontend' => true,
			'backend' => true,
			'skip_xss' => true,
			'menu' => 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'posts' => array(
					'name' => 'movie:posts_title',
					'uri' => 'admin/movie',
					'shortcuts' => array(
						array(
							'name' => 'movie:create_title',
							'uri' => 'admin/movie/create',
							'class' => 'add',
						),
					),
				),
				'categories' => array(
					'name' => 'cat:list_title',
					'uri' => 'admin/movie/categories',
					'shortcuts' => array(
						array(
							'name' => 'cat:create_title',
							'uri' => 'admin/movie/categories/create',
							'class' => 'add',
						),
					),
				),
			),
		);

		if (function_exists('group_has_role'))
		{
			if(group_has_role('movie', 'admin_movie_fields'))
			{
				$info['sections']['fields'] = array(
							'name' 	=> 'global:custom_fields',
							'uri' 	=> 'admin/movie/fields',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'streams:add_field',
										'uri' 	=> 'admin/movie/fields/create',
										'class' => 'add'
										)
									)
							);
			}
		}

		return $info;
	}

	public function install()
	{
		$this->dbforge->drop_table('movie_categories');

		$this->load->driver('Streams');
		$this->streams->utilities->remove_namespace('movies');

		// Just in case.
		$this->dbforge->drop_table('movie');

		if ($this->db->table_exists('data_streams'))
		{
			$this->db->where('stream_namespace', 'movies')->delete('data_streams');
		}

		// Create the movie categories table.
		$this->install_tables(array(
			'movie_categories' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
			),
		));

		$this->streams->streams->add_stream(
			'lang:movie:movie_title',
			'movie',
			'movies',
			null,
			null
		);

		// Add the intro field.
		// This can be later removed by an admin.
		$intro_field = array(
			'name'		=> 'lang:movie:intro_label',
			'slug'		=> 'intro',
			'namespace' => 'movies',
			'type'		=> 'wysiwyg',
			'assign'	=> 'movie',
			'extra'		=> array('editor_type' => 'simple', 'allow_tags' => 'y'),
			'required'	=> true
		);
		$this->streams->fields->add_field($intro_field);

		// Ad the rest of the movie fields the normal way.
		$movie_fields = array(
				'title' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false, 'unique' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false),
				'category_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'body' => array('type' => 'TEXT'),
				'parsed' => array('type' => 'TEXT'),
				'keywords' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
				'author_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'created_on' => array('type' => 'INT', 'constraint' => 11),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'comments_enabled' => array('type' => 'ENUM', 'constraint' => array('no','1 day','1 week','2 weeks','1 month', '3 months', 'always'), 'default' => '3 months'),
				'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
				'preview_hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => ''),
		);
		return $this->dbforge->add_column('movie', $movie_fields);
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}
