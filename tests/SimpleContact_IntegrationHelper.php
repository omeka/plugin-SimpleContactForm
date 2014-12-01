<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2014
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package SimpleContact
 */
class SimpleContact_IntegrationHelper
{
    const PLUGIN_NAME = 'SimpleContact';

    public function setUpPlugin()
    {
        $pluginHelper = new Omeka_Test_Helper_Plugin;
        $this->_addPluginHooksAndFilters($pluginHelper->pluginBroker, self::PLUGIN_NAME);
        $pluginHelper->setUp(self::PLUGIN_NAME);
    }

    public function _addPluginHooksAndFilters($pluginBroker, $pluginName)
    {
        // Set the current plugin so the add_plugin_hook function works
        $pluginBroker->setCurrentPluginDirName($pluginName);

        // Add plugin hooks.
        add_plugin_hook('install', 'simple_contact_install');
        add_plugin_hook('uninstall', 'simple_contact_uninstall');
        add_plugin_hook('define_routes', 'simple_contact_define_routes');
        add_plugin_hook('config_form', 'simple_contact_config_form');
        add_plugin_hook('config', 'simple_contact_config');

        // Add filters.
        add_filter('public_navigation_main', 'simple_contact_public_navigation_main');
    }
}
