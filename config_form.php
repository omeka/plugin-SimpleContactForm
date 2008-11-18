<?php
$page_path = get_option('simple_contact_form_page_path');
$reply_from_email = get_option('simple_contact_form_reply_from_email');
$forward_to_email = get_option('simple_contact_form_forward_to_email');	
$admin_notification_email_subject = get_option('simple_contact_form_admin_notification_email_subject');
$admin_notification_email_message_header = get_option('simple_contact_form_admin_notification_email_message_header');
$user_notification_email_subject = get_option('simple_contact_form_user_notification_email_subject');
$user_notification_email_message_header = get_option('simple_contact_form_user_notification_email_message_header');
$contact_page_title = get_option('simple_contact_form_contact_page_title');
$contact_page_instructions = get_option('simple_contact_form_contact_page_instructions');
$thankyou_page_title = get_option('simple_contact_form_thankyou_page_title');
$thankyou_page_message = get_option('simple_contact_form_thankyou_page_message');
$add_to_main_navigation = get_option('simple_contact_form_add_to_main_navigation');
$captcha_public_key = get_option('simple_contact_form_recaptcha_public_key');
$captcha_private_key = get_option('simple_contact_form_recaptcha_private_key');
?>

<?php if (empty($captcha_public_key) and empty($captcha_private_key)): ?>
    <p class="error">Please enter your <a href="http://recaptcha.net/">ReCAPTCHA</a> 
        API keys, or the contact form will be vulnerable to spam.</p>
<?php endif; ?>

<div class="field">
<label for="reply_from_email">Reply From Email</label>
<div class="inputs">
<input class="textinput" type="text" name="reply_from_email" value="<?php echo $reply_from_email; ?>" id="reply_from_email" />
<p class="explanation">The email address that </p>
</div>
</div>

<div class="field">
<label for="forward_to_email">Forward To Email</label>
<div class="inputs">
<input class="textinput" type="text" name="forward_to_email" value="<?php echo $forward_to_email; ?>" id="forward_to_email" />
<p class="explanation">The email address that receives notifications that someone has submitted a message through contact form.</p>
</div>
</div>

<div class="field">
<label for="admin_notification_email_subject">Email Subject (Admin Notification)</label>
<div class="inputs">
<input class="textinput" type="text" name="admin_notification_email_subject" value="<?php echo $admin_notification_email_subject; ?>" id="admin_notification_email_subject" />
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="admin_notification_email_message_header">Email Message (Admin Notification)</label>
<div class="inputs">
<textarea class="textinput" type="text" rows="20" cols="60" name="admin_notification_email_message_header" id="admin_notification_email_message_header"><?php echo $admin_notification_email_message_header; ?></textarea>
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="user_notification_email_subject">Email Subject (Public Notification)</label>
<div class="inputs">
<input class="textinput" type="text" name="user_notification_email_subject" value="<?php echo $user_notification_email_subject; ?>" id="user_notification_email_subject" />
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="user_notification_email_message_header">Email Message (Public Notification)</label>
<div class="inputs">
<textarea class="textinput" type="text" rows="20" cols="60" name="user_notification_email_message_header" id="user_notification_email_message_header"><?php echo $user_notification_email_message_header; ?></textarea>
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="page_path">Contact Form Path</label>
<div class="inputs">
<input class="textinput" type="text" name="page_path" value="<?php echo $page_path; ?>" id="page_path" />
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="contact_page_title">Contact Page Title</label>
<div class="inputs">
<input class="textinput" type="text" name="contact_page_title" value="<?php echo $contact_page_title; ?>" id="contact_page_title" />
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="contact_page_instructions">Instructions for Contact Page</label>
<div class="inputs">
<textarea class="textinput" type="text" rows="20" cols="60" name="contact_page_instructions" id="contact_page_instructions"><?php echo $contact_page_instructions; ?></textarea>
<p class="explanation">If you would like to provide specific instructions on the contact form page, add those here.</p>
</div>
</div>


<div class="field">
	<label for="add_to_main_navigation">Add to Main Navigation</labe>
	<div class="inputs">
		<?php echo checkbox(array('name'=>'add_to_main_navigation', 'id'=>'add_to_main_navigation'), $add_to_main_navigation); ?>
	</div>
</div>
<div class="field">
<label for="thankyou_page_title">Thank You Page Title</label>
<div class="inputs">
<input class="textinput" class="textinput" type="text" name="thankyou_page_title" value="<?php echo $thankyou_page_title; ?>" id="thankyou_page_title" />
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="thankyou_page_message">Thank You Page Message</label>
<div class="inputs">
<textarea class="textinput" type="text" rows="20" cols="60" name="thankyou_page_message" id="thankyou_page_message"><?php echo $thankyou_page_message; ?></textarea>
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="recaptcha_public_key">reCAPTCHA Public Key</label>
<div class="inputs">
<input class="textinput" class="textinput" type="text" name="recaptcha_public_key" value="<?php echo $captcha_public_key; ?>" id="recaptcha_public_key" />
<p class="explanation"></p>
</div>
</div>

<div class="field">
<label for="recaptcha_private_key">reCAPTCHA Private Key</label>
<div class="inputs">
<input class="textinput" class="textinput" type="text" name="recaptcha_private_key" value="<?php echo $captcha_private_key; ?>" id="recaptcha_private_key" />
<p class="explanation"></p>
</div>
</div>
