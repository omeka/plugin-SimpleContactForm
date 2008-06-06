<?php
/** 
*
* SimpleContactForm Plugin
* 
* @author CHNM  
* @copyright CHNM, 2 June, 2009 
* @package SimpleContactForm 
*
**/
require_once('models/SimpleContactFormEntry.php');

define('SIMPLE_CONTACT_FORM_VERSION', 0.1);
define('SIMPLE_CONTACT_FORM_PAGE_PATH', 'contact/'); //this can be overwritten in the admin panel, but will be used as the default if no page path is given


add_plugin_hook('initialize', 'simple_contact_form_initialize');

add_plugin_hook('add_routes', 'simple_contact_form_routes');
add_plugin_hook('config_form', 'simple_contact_form_config_form');
add_plugin_hook('config', 'simple_contact_form_config');
add_plugin_hook('install', 'simple_contact_form_install');
add_plugin_hook('theme_header', 'simple_contact_form_css');

// the css style for the configure settings
function simple_contact_form_settings_css() {
	echo '<style type="text/css" media="screen">';
	
	echo '#simple_contact_form_settings label, #simple_contact_form_settings input, #simple_contact_form_settings textarea {';
	echo 'display:block;';
	echo 'float:none;';
	echo '}';
	
	echo '#simple_contact_form_settings input, #simple_contact_form_settings textarea {';
	echo 'margin-bottom:1em;';
	echo '}';
	
	echo '</style>';
}

//the css style for the contact page
function simple_contact_form_css() {
	echo '<style type="text/css" media="screen">';
	
	echo '#simple_contact_form label, #simple_contact_form input, #simple_contact_form textarea {';
	echo 'display:block;';
	echo 'float:none;';
	echo '}';
	
	echo '#simple_contact_form input, #simple_contact_form textarea {';
	echo 'margin-bottom:1em;';
	echo '}';
	
	echo '</style>';
}

function simple_contact_form_install() {
	set_option('simple_contact_form_version', SIMPLE_CONTACT_FORM_VERSION);	
	set_option('simple_contact_form_reply_from_email', get_option('administrator_email'));
	set_option('simple_contact_form_forward_to_email', get_option('administrator_email'));
	set_option('simple_contact_form_page_path', SIMPLE_CONTACT_FORM_PAGE_PATH);	
}

function simple_contact_form_initialize() {
	add_controllers('controllers');
	add_theme_pages('theme', 'public');
}

function simple_contact_form_routes($router) {
	//if the page path is empty then make it the default page path
	if (trim(get_option('simple_contact_form_page_path')) == '') {
		set_option('simple_contact_form_page_path', SIMPLE_CONTACT_FORM_PAGE_PATH);
	}
	
	//add the contact page route
	$froute_contact = get_option('simple_contact_form_page_path');
	$router->addRoute($froute_contact, new Zend_Controller_Router_Route($froute_contact, array('controller'=>'simple-contact-form', 'action'=>'add')));
	
	//add the thankyou page route
	//the thankyou_route will be the contact_route plus '/thankyou' 
	if (substr($froute_contact, strlen($froute_contact) - 1, 1) != '/') {
		$froute_thankyou = $froute_contact . '/' . 'thankyou';
	} else {
		$froute_thankyou = $froute_contact . 'thankyou';
	}
	set_option('simple_contact_form_thank_you_path', $froute_thankyou);
	$router->addRoute($froute_thankyou, new Zend_Controller_Router_Route($froute_thankyou, array('controller'=>'simple-contact-form', 'action'=>'thankyou')));
}

function simple_contact_form_config_form() {
        	simple_contact_form_settings_css(); //this styling needs to be associated with appropriate hook
		?>
		<div id="simple_contact_form_settings">
			<label for="simple_contact_form_forward_to_email">Forward-To Email Address:</label>
			<p class="instructionText">Please enter the email address to where you would like to forward all notification emails from users who have contacted you.  Leave this field blank if you would not like to receive notifications when users contact you.</p>
			<input type="text" name="simple_contact_form_forward_to_email" value="<?php echo settings('simple_contact_form_forward_to_email'); ?>" />
			<label for="simple_contact_form_reply_from_email">Reply-From Email Address:</label>
			<p class="instructionText">Please enter the email address that you would like to appear in the 'From' field for all notification emails to users who have contacted you.  Leave this field blank if you would not like to email confirmations to users when they contact you.</p>
			<input type="text" name="simple_contact_form_reply_from_email" value="<?php echo settings('simple_contact_form_reply_from_email'); ?>" />
			<label for="simple_contact_form_page_path">Relative Page Path From Project Root:</label>
			<p class="instructionText">Please enter the relative page path from the project root where you want the contact page to be located. Use forward slashes to indicate subdirectories, but do not begin with a forward slash.</p>
			<input type="text" name="simple_contact_form_page_path" value="<?php echo settings('simple_contact_form_page_path'); ?>" />
		</div>
	<?php
}

function simple_contact_form_config() {
	set_option('simple_contact_form_forward_to_email', $_POST['simple_contact_form_forward_to_email']);
	set_option('simple_contact_form_reply_from_email', $_POST['simple_contact_form_reply_from_email']);
	set_option('simple_contact_form_page_path', $_POST['simple_contact_form_page_path']);	
}
