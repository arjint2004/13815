<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Movieslider module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Movieslider
 */
class Module_Movieslider extends Module
{
	public $version = '2.0.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Movieslider',
				'ar' => 'المدوّنة',
				'br' => 'Movieslider',
				'pt' => 'Movieslider',
				'el' => 'Ιστολόγιο',
                            'fa' => 'بلاگ',
				'he' => 'בלוג',
				'id' => 'Movieslider',
				'lt' => 'Movieslideras',
				'pl' => 'Movieslider',
				'ru' => 'Блог',
				'tw' => '文章',
				'cn' => '文章',
				'hu' => 'Movieslider',
				'fi' => 'Movieslideri',
				'th' => 'บล็อก',
				'se' => 'Moviesliderg',
			),
			'description' => array(
				'en' => 'Post movieslider entries.',
				'ar' => 'أنشر المقالات على مدوّنتك.',
				'br' => 'Escrever publicações de movieslider',
				'pt' => 'Escrever e editar publicações no movieslider',
				'cs' => 'Publikujte nové články a příspěvky na movieslider.', #update translation
				'da' => 'Skriv moviesliderindlæg',
				'de' => 'Veröffentliche neue Artikel und Movieslider-Einträge', #update translation
				'sl' => 'Objavite movieslider prispevke',
				'fi' => 'Kirjoita movieslideri artikkeleita.',
				'el' => 'Δημιουργήστε άρθρα και εγγραφές στο ιστολόγιο σας.',
				'es' => 'Escribe entradas para los artículos y movieslider (web log).', #update translation
                                'fa' => 'مقالات منتشر شده در بلاگ',
				'fr' => 'Poster des articles d\'actualités.',
				'he' => 'ניהול בלוג',
				'id' => 'Post entri movieslider',
				'it' => 'Pubblica notizie e post per il movieslider.', #update translation
				'lt' => 'Rašykite naujienas bei movieslider\'o įrašus.',
				'nl' => 'Post nieuwsartikelen en moviesliders op uw site.',
				'pl' => 'Dodawaj nowe wpisy na movieslideru',
				'ru' => 'Управление записями блога.',
				'tw' => '發表新聞訊息、部落格等文章。',
				'cn' => '发表新闻讯息、部落格等文章。',
				'th' => 'โพสต์รายการบล็อก',
				'hu' => 'Movieslider bejegyzések létrehozása.',
				'se' => 'Inlägg i movieslidergen.',
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
					'name' => 'movieslider:posts_title',
					'uri' => 'admin/movieslider',
					'shortcuts' => array(
						array(
							'name' => 'movieslider:create_title',
							'uri' => 'admin/movieslider/create',
							'class' => 'add',
						),
					),
				),
				'categories' => array(
					'name' => 'cat:list_title',
					'uri' => 'admin/movieslider/categories',
					'shortcuts' => array(
						array(
							'name' => 'cat:create_title',
							'uri' => 'admin/movieslider/categories/create',
							'class' => 'add',
						),
					),
				),
			),
		);

		if (function_exists('group_has_role'))
		{
			if(group_has_role('movieslider', 'admin_movieslider_fields'))
			{
				$info['sections']['fields'] = array(
							'name' 	=> 'global:custom_fields',
							'uri' 	=> 'admin/movieslider/fields',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'streams:add_field',
										'uri' 	=> 'admin/movieslider/fields/create',
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
		$this->dbforge->drop_table('movieslider_categories');

		$this->load->driver('Streams');
		$this->streams->utilities->remove_namespace('moviesliders');

		// Just in case.
		$this->dbforge->drop_table('movieslider');

		if ($this->db->table_exists('data_streams'))
		{
			$this->db->where('stream_namespace', 'moviesliders')->delete('data_streams');
		}

		// Create the movieslider categories table.
		$this->install_tables(array(
			'movieslider_categories' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
			),
		));

		$this->streams->streams->add_stream(
			'lang:movieslider:movieslider_title',
			'movieslider',
			'moviesliders',
			null,
			null
		);

		// Add the intro field.
		// This can be later removed by an admin.
		$intro_field = array(
			'name'		=> 'lang:movieslider:intro_label',
			'slug'		=> 'intro',
			'namespace' => 'moviesliders',
			'type'		=> 'wysiwyg',
			'assign'	=> 'movieslider',
			'extra'		=> array('editor_type' => 'simple', 'allow_tags' => 'y'),
			'required'	=> true
		);
		$this->streams->fields->add_field($intro_field);

		// Ad the rest of the movieslider fields the normal way.
		$movieslider_fields = array(
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
		return $this->dbforge->add_column('movieslider', $movieslider_fields);
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
