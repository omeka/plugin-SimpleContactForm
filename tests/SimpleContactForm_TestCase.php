<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 **/
class SimpleContactForm_TestCase extends Omeka_Test_AppTestCase
{
    const PLUGIN_NAME = 'SimpleContactForm';
    
    public function setUp()
    {
        parent::setUp();
        
        // Authenticate and set the current user 
        $this->user = $this->db->getTable('User')->find(1);
        $this->_authenticateUser($this->user);
        Omeka_Context::getInstance()->setCurrentUser($this->user);
                
        // Add the plugin hooks and filters (including the install hook)
        $pluginBroker = get_plugin_broker();
        $this->_addPluginHooksAndFilters($pluginBroker, self::PLUGIN_NAME);
        
        // Install the plugin
        $plugin = $this->_installPlugin(self::PLUGIN_NAME);
        $this->assertTrue($plugin->isInstalled());
        
        // Initialize the core resource plugin hooks and filters (like the initialize hook)
        $this->_initializeCoreResourcePluginHooksAndFilters($pluginBroker, self::PLUGIN_NAME);
    }
        
    public function _addPluginHooksAndFilters($pluginBroker, $pluginName)
    {   
        // Set the current plugin so the add_plugin_hook function works
        $pluginBroker->setCurrentPluginDirName($pluginName);
        
        // Add plugin hooks.
        add_plugin_hook('install', 'simple_contact_form_install');
        add_plugin_hook('uninstall', 'simple_contact_form_uninstall');
        add_plugin_hook('define_routes', 'simple_contact_form_define_routes');
        add_plugin_hook('config_form', 'simple_contact_form_config_form');
        add_plugin_hook('config', 'simple_contact_form_config');

        // Add filters.
        add_filter('public_navigation_main', 'simple_contact_form_public_navigation_main');       
    }

}