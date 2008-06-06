<?php head(); ?>

<div id="primary">

	<?php echo flash(); ?>

	<h2>Please Enter Your Feedback</h2>

	<form name="simple_contact_form" id="simple_contact_form"  method="post" enctype="multipart/form-data" accept-charset="utf-8">

		<?php 
			echo text(array('name'=>'name', 'id'=>'name', 'class'=>'textinput'), null, 'Your Name: '); 
		 ?>
		<?php
			echo text(array('name'=>'email', 'id'=>'email', 'class'=>'textinput'), null, 'Your Email: ');
		?>
		<br/>

		<label for="message">Your Message:</label>
		<textarea id="message" name="message" rows="20"></textarea>

	<?php
		echo recaptcha_show();
		echo submit();
	 ?>
	</form>
</div>
<?php foot(); ?>