<?php head(); ?>

<div id="primary">

	<?php echo flash(); ?>

	<h2><?php echo get_option('simple_contact_form_contact_page_title'); ?></h2>
	<p><?php echo get_option('simple_contact_form_contact_page_instructions'); ?></p>

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
		<label for="recaptcha">Verification Code:</label>
	<?php
		echo recaptcha_show();
		echo submit();
	 ?>
	</form>
</div>
<?php foot(); ?>