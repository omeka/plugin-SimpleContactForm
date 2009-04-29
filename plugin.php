<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2008
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package SimpleContactForm
 */

// Define Constants.
define('SIMPLE_CONTACT_FORM_PLUGIN_VERSION', get_plugin_ini('SimpleContactForm', 'version'));
define('SIMPLE_CONTACT_FORM_PAGE_PATH', 'contact/');
define('SIMPLE_CONTACT_FORM_CONTACT_PAGE_TITLE', 'Contact Us');
define('SIMPLE_CONTACT_FORM_CONTACT_PAGE_INSTRUCTIONS', 'Please send us your comments and suggestions.');
define('SIMPLE_CONTACT_FORM_THANKYOU_PAGE_TITLE', 'Thank You For Your Feedback');
define('SIMPLE_CONTACT_FORM_THANKYOU_PAGE_MESSAGE', 'We appreciate your comments and suggestions.');
define('SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_SUBJECT', 'A User Has Contacted You');
define('SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_MESSAGE_HEADER', 'A user has sent you the following message:');
define('SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_SUBJECT', 'Thank You');
define('SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_MESSAGE_HEADER', 'Thank you for sending us the following message:');
define('SIMPLE_CONTACT_FORM_ADD_TO_MAIN_NAVIGATION', 1);

// Add plugin hooks.
add_plugin_hook('install', 'simple_contact_form_install');
add_plugin_hook('uninstall', 'simple_contact_form_uninstall');
add_plugin_hook('define_routes', 'simple_contact_form_define_routes');
add_plugin_hook('config_form', 'simple_contact_form_config_form');
add_plugin_hook('config', 'simple_contact_form_config');

// Add filters.
add_filter('public_navigation_main', 'simple_contact_form_public_navigation_main');


function simple_contact_form_install()
{
	set_option('simple_contact_form_version', SIMPLE_CONTACT_FORM_VERSION);	
	set_option('simple_contact_form_reply_from_email', get_option('administrator_email'));
	set_option('simple_contact_form_forward_to_email', get_option('administrator_email'));	
	set_option('simple_contact_form_admin_notification_email_subject', SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_SUBJECT);
	set_option('simple_contact_form_admin_notification_email_message_header', SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_MESSAGE_HEADER);
	set_option('simple_contact_form_user_notification_email_subject', SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_SUBJECT);
	set_option('simple_contact_form_user_notification_email_message_header', SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_MESSAGE_HEADER);
	set_option('simple_contact_form_contact_page_title', SIMPLE_CONTACT_FORM_CONTACT_PAGE_TITLE);
	set_option('simple_contact_form_contact_page_instructions', SIMPLE_CONTACT_FORM_CONTACT_PAGE_INSTRUCTIONS);
	set_option('simple_contact_form_thankyou_page_title', SIMPLE_CONTACT_FORM_THANKYOU_PAGE_TITLE);
	set_option('simple_contact_form_thankyou_page_message', SIMPLE_CONTACT_FORM_THANKYOU_PAGE_MESSAGE);	
	set_option('simple_contact_form_add_to_main_navigation', SIMPLE_CONTACT_FORM_ADD_TO_MAIN_NAVIGATION);	
	
}

function simple_contact_form_uninstall()
{
	delete_option('simple_contact_form_version');	
	delete_option('simple_contact_form_reply_from_email');
	delete_option('simple_contact_form_forward_to_email');	
	delete_option('simple_contact_form_admin_notification_email_subject');
	delete_option('simple_contact_form_admin_notification_email_message_header');
	delete_option('simple_contact_form_user_notification_email_subject');
	delete_option('simple_contact_form_user_notification_email_message_header');
	delete_option('simple_contact_form_contact_page_title');
	delete_option('simple_contact_form_contact_page_instructions');
	delete_option('simple_contact_form_thankyou_page_title');
	delete_option('simple_contact_form_add_to_main_navigation');	
}

/**
 * Adds 2 routes for the form and the thank you page.
 **/
function simple_contact_form_define_routes($router)
{   
	$router->addRoute(
	    'simple_contact_form_form', 
	    new Zend_Controller_Router_Route(
	        SIMPLE_CONTACT_FORM_PAGE_PATH, 
	        array('module'       => 'simple-contact-form')
	    )
	);
		
	$router->addRoute(
	    'simple_contact_form_thankyou', 
	    new Zend_Controller_Router_Route(
	        SIMPLE_CONTACT_FORM_PAGE_PATH . 'thankyou', 
	        array(
	            'module'       => 'simple-contact-form', 
	            'controller'   => 'index', 
	            'action'       => 'thankyou', 
	        )
	    )
	);

}

function simple_contact_form_config_form() 
{
	include 'config_form.php';
}

function simple_contact_form_config()
{
	set_option('simple_contact_form_reply_from_email', $_POST['reply_from_email']);
	set_option('simple_contact_form_forward_to_email', $_POST['forward_to_email']);	
	set_option('simple_contact_form_admin_notification_email_subject', $_POST['admin_notification_email_subject']);
	set_option('simple_contact_form_admin_notification_email_message_header', $_POST['admin_notification_email_message_header']);
	set_option('simple_contact_form_user_notification_email_subject', $_POST['user_notification_email_subject']);
	set_option('simple_contact_form_user_notification_email_message_header', $_POST['user_notification_email_message_header']);
	set_option('simple_contact_form_contact_page_title', $_POST['contact_page_title']);
	set_option('simple_contact_form_contact_page_instructions',$_POST['contact_page_instructions']);
	set_option('simple_contact_form_thankyou_page_title', $_POST['thankyou_page_title']);
	set_option('simple_contact_form_thankyou_page_message', $_POST['thankyou_page_message']);
	set_option('simple_contact_form_add_to_main_navigation', $_POST['add_to_main_navigation']);
	set_option('simple_contact_form_recaptcha_public_key', $_POST['recaptcha_public_key']);
	set_option('simple_contact_form_recaptcha_private_key', $_POST['recaptcha_private_key']);
}

function simple_contact_form_public_navigation_main($nav)
{
	$contact_title = get_option('simple_contact_form_contact_page_title');
	$contact_add_to_navigation = get_option('simple_contact_form_add_to_main_navigation');
	if ($contact_add_to_navigation) {
	    $nav[$contact_title] = uri(array(), 'simple_contact_form_form');
	}

    return $nav;
}