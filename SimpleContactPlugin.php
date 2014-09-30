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
    );

    /**
     * @var array Options and their default values.
     */
    protected $_filters = array(
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
     *
     * @return void
     */
    public function hookConfigForm()
    {
        echo get_view()->partial(
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
                    'action' => 'index',
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
     * Adds contact us in navigation.
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
