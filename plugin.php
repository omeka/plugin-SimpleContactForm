<?php

define('SIMPLE_CONTACT_FORM_VERSION', 0.1);

add_plugin_hook('install', 'simple_contact_form_install');

get_db()->addTable('SimpleContactFormEntry', 'simple_contact_form');

class SimpleContactFormEntry extends Omeka_Record {
	public $exhibit_id;
	public $text;
	public $email;
	public $name;
}

function simple_contact_form_install() {
	
	$db = get_db();

	$db->exec("CREATE TABLE IF NOT EXISTS {$db->prefix}simple_contact_form (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`exhibit_id` INT UNSIGNED NOT NULL,
		`text` TEXT NOT NULL,
		`email` VARCHAR(100) NOT NULL,
		`name` TEXT NOT NULL ,
		INDEX ( `id` )
		) ENGINE = MYISAM");
	
	set_option('simple_contact_form_version', SIMPLE_CONTACT_FORM_VERSION);
	
}

function simple_contact_form_entry() {
	$db = get_db(); 
	
	$entry = new SimpleContactFormEntry(); // Like a row in the database.
	
	return $entry;
}

function save_simple_contact_form_entry($entry) {
	
	$db = get_db();
	
	$text = $_POST['text'];
	$email = $_POST['email'];
	$name = $_POST['name'];
	
	if (array_key_exists('email', $_POST)) {
		
		$entry = simple_contact_form_entry();
				
		if(!empty($text)) {
										
			$entry->text = $text; 
			$entry->email = $email; // Changes $post value to an integer.
			$entry->name = $name;
			$entry->save();
	
		} 
	}	
}

function simple_contact_form_html() {
	
	$html .= '<form name="simple_contact_form" method="post">';
	$html .= '<label for="text">Your Question:</label>';
	$html .= '<textarea id="question" name="question" value=""></textarea>';
	$html .= text(array('name'=>'name', 'id'=>'name', 'class'=>'textinput'), 'Name:');
	$html .= text(array('name'=>'email', 'id'=>'email', 'class'=>'textinput'), 'Email:');
	$html .= submit();
	$html .= '</form>';
	
	return $html;
	
}
