<?php
namespace Settings\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Settings\Model\Table\SettingsTable;

/**
 * Settings\Model\Table\SettingsTable Test Case
 */
class SettingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Settings\Model\Table\SettingsTable
     */
    public $Settings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.settings.settings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Settings') ? [] : ['className' => SettingsTable::class];
        $this->Settings = TableRegistry::get('Settings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Settings);

        parent::tearDown();
    }

    public function testWriteNew()
    {
        $this->Settings->write('Prefix.key', 'value');
        $prefixAnything = $this->Settings->findByKey('Prefix.key')->first();
        $this->assertEquals('value', $prefixAnything->value);
    }

    public function testWriteUpdate()
    {
        $this->Settings->write('Site.title', 'My new site title', ['editable' => 1]);
        $siteTitle = $this->Settings->findByKey('Site.title')->first();
        $this->assertEquals('My new site title', $siteTitle->value);

        $this->Settings->write('Site.title', 'My new site title', ['input_type' => 'checkbox']);
        $siteTitle = $this->Settings->findByKey('Site.title')->first();
        $this->assertTrue($siteTitle->editable);

        $this->Settings->write('Site.title', 'My new site title', ['input_type' => 'textarea', 'editable' => false]);
        $siteTitle = $this->Settings->findByKey('Site.title')->first();
        $this->assertEquals('textarea', $siteTitle->input_type);
        $this->assertFalse($siteTitle->editable);
    }

    public function testDeleteKey()
    {
        $this->Settings->write('Prefix.key', 'value');
        $this->Settings->deleteKey('Prefix.key');
        $hasAny = $this->Settings->exists([
            'key' => 'Prefix.key',
        ]);
        $this->assertFalse($hasAny);
    }
}
