<?php
namespace Settings\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class LanguagesControllerTest extends IntegrationTestCase {

	public $fixtures = array(
		'plugin.users.acos',
		'plugin.users.aros',
		'plugin.users.aros_acos',
		'plugin.blocks.blocks',
		'plugin.comments.comments',
		'plugin.contacts.contacts',
		'plugin.translate.i18ns',
		'plugin.settings.languages',
		'plugin.menus.links',
		'plugin.menus.menus',
		'plugin.contacts.messages',
		'plugin.meta.metas',
		'plugin.nodes.nodes',
		'plugin.taxonomy.model_taxonomies',
		'plugin.blocks.regions',
		'plugin.users.roles',
		'plugin.settings.settings',
		'plugin.taxonomy.taxonomies',
		'plugin.taxonomy.terms',
		'plugin.taxonomy.types',
		'plugin.taxonomy.types_vocabularies',
		'plugin.users.users',
		'plugin.taxonomy.vocabularies'
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LanguagesController = $this->generate('Settings.Languages', array(
			'methods' => array(
				'redirect',
			),
			'components' => array(
				'Auth' => array('user'),
				'Session',
			),
		));
		$this->LanguagesController->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->LanguagesController);
	}

/**
 * testAdminIndex
 *
 * @return void
 */
	public function testAdminIndex() {
		$this->testAction('/admin/languages/index');
		$this->assertNotEmpty($this->vars['languages']);
	}

/**
 * testAdminAdd
 *
 * @return void
 */
	public function testAdminAdd() {
		$this->expectFlashAndRedirect('The Language has been saved');
		$this->testAction('/admin/languages/add', array(
			'data' => array(
				'Language' => array(
					'title' => 'Bengali',
					'alias' => 'ben',
				),
			),
		));
		$ben = $this->LanguagesController->Language->findByAlias('ben');
		$this->assertEqual($ben['Language']['title'], 'Bengali');
	}

/**
 * testAdminEdit
 *
 * @return void
 */
	public function testAdminEdit() {
		$this->expectFlashAndRedirect('The Language has been saved');
		$this->testAction('/admin/languages/edit/1', array(
			'data' => array(
				'Language' => array(
					'id' => 1,
					'title' => 'English [modified]',
					'alias' => 'eng',
				),
			),
		));
		$result = $this->LanguagesController->Language->findByAlias('eng');
		$this->assertEquals('English [modified]', $result['Language']['title']);
	}

/**
 * testAdminDelete
 *
 * @return void
 */
	public function testAdminDelete() {
		$this->expectFlashAndRedirect('Language deleted');
		$this->testAction('/admin/languages/delete/1'); // ID of English
		$hasAny = $this->LanguagesController->Language->hasAny(array(
			'Language.alias' => 'eng',
		));
		$this->assertFalse($hasAny);
	}

/**
 * testAdminMoveUp
 *
 * @return void
 */
	public function testAdminMoveUp() {
		$id = $this->_addLanguages();
		$this->assertEqual(3, $id, __d('croogo', 'Could not add a new language.'));

		// move up
		$this->expectFlashAndRedirect('Moved up successfully');
		$this->testAction("/admin/languages/moveup/$id");

		$list = $this->LanguagesController->Language->find('list', array(
			'order' => 'Language.weight ASC',
		));
		$this->assertEqual($list, array(
			'1' => 'English',
			'3' => 'German',
			'2' => 'Bengali',
		));
	}

/**
 * testAdminMoveUpWithSteps
 *
 * @return void
 */
	public function testAdminMoveUpWithSteps() {
		$id = $this->_addLanguages();
		$this->assertEqual(3, $id, __d('croogo', 'Could not add a new language.'));

		// move up with steps
		$this->expectFlashAndRedirect('Moved up successfully');
		$this->testAction("/admin/languages/moveup/$id/2");

		$list = $this->LanguagesController->Language->find('list', array(
			'order' => 'Language.weight ASC',
		));
		$this->assertEqual($list, array(
			'3' => 'German',
			'2' => 'Bengali',
			'1' => 'English',
		));
	}

/**
 * testAdminMoveDown
 *
 * @return void
 */
	public function testAdminMoveDown() {
		$id = $this->_addLanguages();

		$this->expectFlashAndRedirect('Moved down successfully');
		$this->testAction('/admin/languages/movedown/1');

		$list = $this->LanguagesController->Language->find('list', array(
			'order' => 'Language.weight ASC',
		));
		$this->assertEqual($list, array(
			'2' => 'Bengali',
			'3' => 'German',
			'1' => 'English',
		));
	}

/**
 * testAdminMoveDownWithSteps
 *
 * @return void
 */
	public function testAdminMoveDownWithSteps() {
		$id = $this->_addLanguages();

		$this->expectFlashAndRedirect('Moved down successfully');
		$this->testAction('/admin/languages/movedown/1/2');

		$list = $this->LanguagesController->Language->find('list', array(
			'order' => 'Language.weight ASC',
		));
		$this->assertEqual($list, array(
			'3' => 'German',
			'2' => 'Bengali',
			'1' => 'English',
		));
	}

/**
 * testAdminSelect
 *
 * @return void
 */
	public function testAdminSelect() {
		$this->LanguagesController
			->expects($this->once())
			->method('redirect');
		$this->testAction('/admin/languages/select');

		$this->testAction('/admin/languages/select/1/Node');
		$this->assertEqual(1, $this->vars['id']);
		$this->assertEqual('Node', $this->vars['modelAlias']);
		$this->assertEqual('English', $this->vars['languages']['0']['Language']['title']);
		$this->assertEqual('eng', $this->vars['languages']['0']['Language']['alias']);
	}

/**
 * Helper for adding languages
 *
 * @return integer id of last added
 */
	protected function _addLanguages() {
		$this->LanguagesController->Language->create();
		$this->LanguagesController->Language->save(array(
			'title' => 'Bengali',
			'alias' => 'ben',
		));
		$this->LanguagesController->Language->create();
		$this->LanguagesController->Language->save(array(
			'title' => 'German',
			'alias' => 'deu',
		));
		return $this->LanguagesController->Language->id;
	}

}
