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

add_plugin_hook('initialize', 'simple_contact_form_initialize');

add_plugin_hook('add_routes', 'simple_contact_form_routes');
add_plugin_hook('config_form', 'simple_contact_form_config_form');
add_plugin_hook('config', 'simple_contact_form_config');
add_plugin_hook('install', 'simple_contact_form_install');

function simple_contact_form_install() {
	set_option('simple_contact_form_version', SIMPLE_CONTACT_FORM_VERSION);	
	set_option('simple_contact_form_reply_to_email', get_option('administrator_email'));
	set_option('simple_contact_form_forward_to_email', get_option('administrator_email'));	
}

function simple_contact_form_initialize() {
	add_controllers('controllers');
	add_theme_pages('theme', 'public');
}

function simple_contact_form_routes($router) {
	 
	$router->addRoute('contact', new Zend_Controller_Router_Route('contact', array('controller'=>'simple-contact-form', 'action'=>'add')));
}

function simple_contact_form_config_form() {
        ?>
		<label for="simple_contact_form_forward_to_email">Forward-To Email Address:</label>
		<p class="instructionText">Please enter the email address to where you would like to forward all notification emails from users who have contacted you.  Leave this field blank if you would not like to receive notifications when users contact you.</p>
		<input type="text" name="simple_contact_form_forward_to_email" value="<?php echo settings('simple_contact_form_forward_to_email'); ?>" />
		<br/>
		<br/>
		<label for="simple_contact_form_reply_to_email">Reply-To Email Address:</label>
		<p class="instructionText">Please enter the email address that you would like to appear in the 'From' field for all notification emails to users who have contacted you.  Leave this field blank if you would not like to email confirmations to users when they contact you.</p>
		<input type="text" name="simple_contact_form_reply_to_email" value="<?php echo settings('simple_contact_form_reply_to_email'); ?>" />
		<br/>
	    <br/>
	<?php
}

function simple_contact_form_config($post) {
	$post = $_POST;
	set_option('simple_contact_form_forward_to_email', $post['simple_contact_form_forward_to_email']);
	set_option('simple_contact_form_reply_to_email', $post['simple_contact_form_reply_to_email']);
}
