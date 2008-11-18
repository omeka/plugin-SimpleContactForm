<?php head(); ?>
<h1><?php echo get_option('simple_contact_form_contact_page_title'); ?></h1>
<div id="simplecontactform">
	<div id="simplecontactforminstructions">
		<?php echo nls2p(get_option('simple_contact_form_contact_page_instructions')); ?>
	</div>
	<?php echo flash(); ?>
	<form name="simple_contact_form" id="simple_contact_form"  method="post" enctype="multipart/form-data" accept-charset="utf-8">

		<?php 
			echo text(array('name'=>'name', 'id'=>'name', 'class'=>'textinput'), $name, 'Your Name: '); 
		 ?>
		<?php
			echo text(array('name'=>'email', 'id'=>'email', 'class'=>'textinput'), $email, 'Your Email: ');
		?>
		<br/>

		<label for="message">Your Message:</label>
		<textarea id="message" name="message"><?php echo $message; ?></textarea>
		
		<?php echo $captcha; ?>
	<?php echo submit('Send Message'); ?>
	</form>
</div>
<?php foot(); ?>