<?php

namespace Test\Case\Model;

class SettingTest extends CroogoTestCase {

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

	public function setUp() {
		parent::setUp();
		$this->Setting = ClassRegistry::init('Settings.Setting');
		$this->Setting->settingsPath = TESTS . 'test_app' . DS . 'Config' . DS . 'settings.json';
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->Setting);
	}

	public function testWriteNew() {
		$this->Setting->write('Prefix.key', 'value');
		$prefixAnything = $this->Setting->findByKey('Prefix.key');
		$this->assertEqual('value', $prefixAnything['Setting']['value']);
	}

	public function testWriteUpdate() {
		$this->Setting->write('Site.title', 'My new site title', array('editable' => 1));
		$siteTitle = $this->Setting->findByKey('Site.title');
		$this->assertEquals('My new site title', $siteTitle['Setting']['value']);

		$this->Setting->write('Site.title', 'My new site title', array('input_type' => 'checkbox'));
		$siteTitle = $this->Setting->findByKey('Site.title');
		$this->assertTrue($siteTitle['Setting']['editable']);

		$this->Setting->write('Site.title', 'My new site title', array('input_type' => 'textarea', 'editable' => false));
		$siteTitle = $this->Setting->findByKey('Site.title');
		$this->assertEquals('textarea', $siteTitle['Setting']['input_type']);
		$this->assertFalse($siteTitle['Setting']['editable']);
	}

	public function testDeleteKey() {
		$this->Setting->write('Prefix.key', 'value');
		$this->Setting->deleteKey('Prefix.key');
		$hasAny = $this->Setting->hasAny(array(
			'Setting.key' => 'Prefix.key',
		));
		$this->assertFalse($hasAny);
	}

	public function testWriteConfiguration() {
		$this->Setting->writeConfiguration();
		$this->assertEqual(Configure::read('Site.title'), 'Croogo - Test');
	}
}
