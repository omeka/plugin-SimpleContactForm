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
	
	$db = get_db();

	$db->exec("CREATE TABLE IF NOT EXISTS {$db->prefix}simple_contact_form (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`message` TEXT NOT NULL,
		`email` VARCHAR(100) NOT NULL,
		`name` TEXT NOT NULL ,
		INDEX ( `id` )
		) ENGINE = MYISAM");
	
	set_option('simple_contact_form_version', SIMPLE_CONTACT_FORM_VERSION);	
}

function simple_contact_form_initialize() {
	add_controllers('controllers');
	add_theme_pages('theme', 'public');
}

function simple_contact_form_entry() {
	$db = get_db(); 
	
	$entry = new SimpleContactFormEntry(); // Like a row in the database.
	
	return $entry;
}

function contribution_routes($router)
{ 
	$router->addRoute('contact', new Zend_Controller_Router_Route('contact/', array('controller'=>'simplecontactform', 'action'=>'add')));
}

function save_simple_contact_form_entry($entry) {
	
	$db = get_db();
	
	$message = $_POST['message'];
	$email = $_POST['email'];
	$name = $_POST['name'];
	
	if (array_key_exists('email', $_POST)) {
		
		$entry = simple_contact_form_entry();
				
		if(!empty($text)) {
										
			$entry->message = $message; 
			$entry->email = $email;
			$entry->name = $name;
			$entry->save();
	
		} 
	}	
}

function simple_contact_form_html() {
	
	$html .= '<form name="simple_contact_form" method="post">';
	$html .= '<label for="message">Your Message:</label>';
	$html .= '<textarea id="message" name="message" value=""></textarea>';
	$html .= text(array('name'=>'name', 'id'=>'name', 'class'=>'textinput'), 'Name:');
	$html .= text(array('name'=>'email', 'id'=>'email', 'class'=>'textinput'), 'Email:');
	$html .= submit();
	$html .= '</form>';
	
	return $html;
	
}

function simple_contact_form_config_form()
{
        ?>
	<label for="simple_contact_form_notification_email">SimpleContactForm Notificaton Email Address:</label><p class="instructionText">Please enter the email address that you would like to appear in the 'From' field for all notification emails for new contact submissions.  Leave this field blank if you would not like to email a user  whenever he/she makes a submission.</p>
	
	<input type="text" name="simple_contact_form_notification_email" value="<?php settings('simple_contact_form_notification_email'); ?>" />
	<?php
}

function simple_contact_form_config($post)
{
	set_option('simple_contact_form_notification_email', $post['simple_contact_form_notification_email']);
}
