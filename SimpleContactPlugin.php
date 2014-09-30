<?php
/**
 * SimpleContactPlugin class - represents the Simple Contact Form plugin
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @package SimpleContact
 */

// Define Constants.
define('SIMPLE_CONTACT_PATH', 'contact');

class SimpleContactPlugin extends Omeka_Plugin_AbstractPlugin
{
    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array(
        'initialize',
        'install',
        'upgrade',
        'uninstall',
        'config_form',
        'config',
        'define_routes',
        'define_acl',
    );

    /**
     * @var array Options and their default values.
     */
    protected $_filters = array(
        'admin_navigation_main',
        'public_navigation_main',
    );

    /**
     * @var array Options and their default values.
     */
    protected $_options = array(
        'simple_contact_page_contact_title' => 'Contact Us',
        'simple_contact_page_contact_text' => 'Please send us your comments and suggestions.',
        'simple_contact_page_contact_add_to_main_navigation' => 1,
        'simple_contact_page_thankyou_title' => 'Thank You For Your Feedback',
        'simple_contact_page_thankyou_text' => 'We appreciate your comments and suggestions.',
        'simple_contact_notification_admin_to' => '',
        'simple_contact_notification_admin_subject' => 'A User Has Contacted You',
        'simple_contact_notification_admin_header' => 'A user has sent you the following message:',
        'simple_contact_notification_user_from' => '',
        'simple_contact_notification_user_subject' => 'Thank You',
        'simple_contact_notification_user_header' => 'Thank you for sending us the following message:',
        'simple_contact_save_into_base' => false,
        'simple_contact_manage_roles' => 'a:1:{i:0;s:5:"admin";}',
        'simple_contact_wpapi_key' => '',
    );

    /**
     * Initialize this plugin.
     */
    public function hookInitialize()
    {
        // Add translation.
        add_translation_source(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'languages');

        if (version_compare(OMEKA_VERSION, '2.2', '>=')) {
            add_shortcode('simple_contact', array($this, 'shortcodeSimpleContact'));
        }
    }

    /**
     * Installs the plugin.
     */
    public function hookInstall()
    {
        $this->_installTable();
        $this->_options['simple_contact_notification_admin_to'] = get_option('administrator_email');
        $this->_options['simple_contact_notification_user_from'] = get_option('administrator_email');
        $this->_installOptions();
    }

    /**
     * Upgrade the plugin.
     */
    public function hookUpgrade($args)
    {
        $oldVersion = $args['old_version'];
        $newVersion = $args['new_version'];

        if (version_compare($oldVersion, '0.6', '<')) {
            set_option('simple_contact_page_contact_title', get_option('simple_contact_form_contact_page_title'));
            set_option('simple_contact_page_contact_text', get_option('simple_contact_form_contact_page_instructions'));
            set_option('simple_contact_page_contact_add_to_main_navigation', get_option('simple_contact_form_add_to_main_navigation'));
            set_option('simple_contact_page_thankyou_title', get_option('simple_contact_form_thankyou_page_title'));
            set_option('simple_contact_page_thankyou_text', get_option('simple_contact_form_thankyou_page_message'));
            set_option('simple_contact_notification_admin_to', get_option('simple_contact_form_forward_to_email'));
            set_option('simple_contact_notification_admin_subject', get_option('simple_contact_form_user_notification_email_subject'));
            set_option('simple_contact_notification_admin_header', get_option('simple_contact_form_admin_notification_email_message_header'));
            set_option('simple_contact_notification_user_from', get_option('simple_contact_form_reply_from_email'));
            set_option('simple_contact_notification_user_subject', get_option('simple_contact_form_user_notification_email_subject'));
            set_option('simple_contact_notification_user_header' , get_option('simple_contact_form_user_notification_email_message_header'));
        }

        if (version_compare($oldVersion, '0.7', '<')) {
            $this->_installTable();
            set_option('simple_contact_save_into_base', $this->_options['simple_contact_save_into_base']);
            set_option('simple_contact_manage_roles', $this->_options['simple_contact_manage_roles']);
            set_option('simple_contact_wpapi_key', $this->_options['simple_contact_wpapi_key']);
        }
    }

    /**
     * Helper to install the base.
     */
    protected function _installTable()
    {
        $db = $this->_db;
        $sql = "
            CREATE TABLE IF NOT EXISTS `$db->SimpleContact` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `status` enum('received', 'answered') NOT NULL DEFAULT 'received',
            `is_spam` tinyint(1) NOT NULL DEFAULT '0',
            `email` tinytext COLLATE utf8_unicode_ci,
            `name` tinytext COLLATE utf8_unicode_ci,
            `message` text COLLATE utf8_unicode_ci NOT NULL,
            `path` tinytext COLLATE utf8_unicode_ci NOT NULL,
            `ip` tinytext COLLATE utf8_unicode_ci,
            `user_agent` tinytext COLLATE utf8_unicode_ci,
            `user_id` int(11) DEFAULT NULL,
            `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ";
        $db->query($sql);
    }

    /**
     * Uninstalls the plugin.
     */
    public function hookUninstall()
    {
        $this->_uninstallOptions();
    }

    /**
     * Shows plugin configuration page.
     */
    public function hookConfigForm($args)
    {
        $view = $args['view'];
        echo $view->partial(
            'plugins/simple-contact-config-form.php',
            array(
                'page_contact_title' => get_option('simple_contact_page_contact_title'),
                'page_contact_text' => get_option('simple_contact_page_contact_text'),
                'page_contact_add_to_main_navigation' => get_option('simple_contact_page_contact_add_to_main_navigation'),
                'page_thankyou_title' => get_option('simple_contact_page_thankyou_title'),
                'page_thankyou_text' => get_option('simple_contact_page_thankyou_text'),
                'notification_admin_from' => get_option('simple_contact_notification_admin_to'),
                'notification_admin_subject' => get_option('simple_contact_notification_admin_subject'),
                'notification_admin_header' => get_option('simple_contact_notification_admin_header'),
                'notification_user_from' => get_option('simple_contact_notification_user_from'),
                'notification_user_subject' => get_option('simple_contact_notification_user_subject'),
                'notification_user_header' => get_option('simple_contact_notification_user_header'),
                'save_into_base' => (boolean) get_option('simple_contact_save_into_base'),
                'manage_roles' => unserialize(get_option('simple_contact_manage_roles')),
                'wpapi_key' => get_option('simple_contact_wpapi_key'),
            )
        );
    }

    /**
     * Processes the configuration form.
     *
     * @return void
     */
    public function hookConfig($args)
    {
        $post = $args['post'];
        foreach (array(
                'simple_contact_manage_roles',
            ) as $posted) {
            $post[$posted] = isset($post[$posted])
                ? serialize($post[$posted])
                : serialize(array());
        }
        foreach ($post as $key => $value) {
            set_option($key, $value);
        }
    }

    /**
     * Adds 2 routes for the form and the thank you page.
     */
    function hookDefineRoutes($args)
    {
        // Don't add these routes on the admin side to avoid conflicts.
        if (is_admin_theme()) {
            return;
        }

        $router = $args['router'];

        $router->addRoute(
            'simple_contact_form',
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_PATH,
                array(
                    'module' => 'simple-contact',
                    'controller' => 'index',
                    'action' => 'write',
                )
            )
        );

        $router->addRoute(
            'simple_contact_thankyou',
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_PATH . '/thankyou',
                array(
                    'module' => 'simple-contact',
                    'controller' => 'index',
                    'action' => 'thankyou',
                )
            )
        );
    }

    /**
     * Defines the plugin's access control list.
     *
     * @param object $args
     */
    public function hookDefineAcl($args)
    {
        // Everybody can write, of course. By default, only admin can manage.
        $acl = $args['acl'];
        $acl->addResource('SimpleContact_Contact');
        $acl->allow(null, 'SimpleContact_Contact', array(
            'write',
            'thankyou',
        ));

        // Check that all the roles exist, in case a plugin-added role has
        // been removed (e.g. GuestUser).
        $manageRoles = unserialize(get_option('simple_contact_manage_roles'));
        foreach ($manageRoles as $role) {
            if ($acl->hasRole($role)) {
                $acl->allow($role, 'SimpleContact_Contact', array(
                    'browse',
                    'update',
                    'delete',
                ));
            }
        }
    }

    /**
     * Adds browse in admin navigation.
     */
    public function filterAdminNavigationMain($nav)
    {
        if (get_option('simple_contact_save_into_base') || total_records('SimpleContact') > 0) {
            $nav[] = array(
                'uri' => url('simple-contact/index/browse'),
                'label' => __('Simple Contacts'),
            );
        }

        return $nav;
    }

    /**
     * Adds contact us in public navigation.
     */
    public function filterPublicNavigationMain($nav)
    {
        if (get_option('simple_contact_page_contact_add_to_main_navigation')) {
            $nav[] = array(
                'label' => get_option('simple_contact_page_contact_title'),
                'uri' => url(SIMPLE_CONTACT_PATH),
                // 'resource' => 'SimpleContact_Index',
                'visible' => true,
            );
        }
        return $nav;
    }

    /**
     * Shortcode to a simple contact form.
     *
     * @param array $args
     * @param Omeka_View $view
     * @return string
     */
    public function shortcodeSimpleContact($args, $view)
    {
        return $view->simpleContactForm((array) $args);
    }
}
