<?php head(); ?>

<div id="primary">

	<?php echo flash(); ?>

	<h2>Please Enter Your Feedback</h2>
	<form name="simple_contact_form"  method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<label for="message">Your Message:</label><br/>
		<textarea id="message" name="message"></textarea><br/>
	 <?php 
		echo text(array('name'=>'name', 'id'=>'name', 'class'=>'textinput'), null, 'Name:'); 
	 ?>
	<br/>
	<?php
		echo text(array('name'=>'email', 'id'=>'email', 'class'=>'textinput'), null, 'Email:');
	?>
	<br/>
	<?php
		echo submit();
	 ?>
	</form>
</div>
<?php foot(); ?>