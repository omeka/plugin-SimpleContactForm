<?php
$view = get_view();
echo js_tag('vendor/tiny_mce/tiny_mce');
?>
<script type="text/javascript">
jQuery(window).load(function () {
    Omeka.wysiwyg({
        mode: 'specific_textareas',
        editor_selector: 'html-editor'
    });
});
</script>
<?php if (!Omeka_Captcha::isConfigured()): ?>
<p class="alert"><?php echo __('You have not entered your <a href="http://recaptcha.net/">reCAPTCHA</a> API keys under <a href="%s">security settings</a>.', url('security#recaptcha_public_key')); ?>
    <?php echo __('We recommend adding these keys, or the contact form will be vulnerable to spam.'); ?>
</p>
<?php endif; ?>
<fieldset id="fieldset-simple-contact-email"><legend><?php echo __('Contact Email'); ?></legend>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_reply_from_email', __('Reply-From Email')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_form_reply_from_email', $reply_from_email, array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The address that users can reply to. If blank, your users will not be sent confirmation emails of their submissions.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_forward_to_email', __('Forward-To Email')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_form_forward_to_email', $forward_to_email, array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The email address that receives notifications that someone has submitted a message through the contact form. If blank, you will not be forwarded messages from your users.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_admin_notification_email_subject', __('Email Subject (Admin Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_form_admin_notification_email_subject', __($admin_notification_email_subject), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The subject line for the email that is sent to the Forward-To email address.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_admin_notification_email_message_header', __('Email Message (Admin Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_form_admin_notification_email_message_header', __($admin_notification_email_message_header), array('rows' => '10', 'class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The beginning of the message that is sent to the Forward-To email address.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_user_notification_email_subject', __('Email Subject (Public Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_form_user_notification_email_subject', __($user_notification_email_subject), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The subject line of the confirmation email that is sent to users who post messages through the form.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_user_notification_email_message_header', __('Email Message (Public Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_form_user_notification_email_message_header', __($user_notification_email_message_header), array('rows' => '10', 'class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The beginning of the confirmation email that is sent to users who post messages through the form.'); ?>
            </p>
        </div>
    </div>
</fieldset>
<fieldset id="fieldset-simple-contact-pages"><legend><?php echo __('Contact Page'); ?></legend>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_contact_page_title', __('Contact Page Title')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_form_contact_page_title', __($contact_page_title), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The title of the contact form (not HTML).'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_contact_page_instructions', __('Instructions for Contact Page')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_form_contact_page_instructions', __($contact_page_instructions), array('rows' => '10', 'class' => array('textinput', 'html-editor'))); ?>
            </div>
            <p class="explanation">
                <?php echo __('Any specific instructions to add to the contact form.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_add_to_main_navigation', __('Add to Main Navigation')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formCheckbox('simple_contact_form_add_to_main_navigation', $add_to_main_navigation, null, array('1', '0')); ?>
            </div>
            <p class="explanation">
                <?php echo __('If checked, add a link to the contact form to the main site navigation.');?>
            </p>
        </div>
    </div>
</fieldset>
<fieldset id="fieldset-simple-contact-pages"><legend><?php echo __('Thank You Page'); ?></legend>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_thankyou_page_title', __('Thank You Page Title')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_form_thankyou_page_title', __($thankyou_page_title), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php __('The title of the Thank You page (not HTML).');?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_form_thankyou_page_message', __('Thank You Page Message')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_form_thankyou_page_message', __($thankyou_page_message), array('rows' => '10', 'class' => array('textinput', 'html-editor'))); ?>
            </div>
            <p class="explanation">
                <?php __('The text displayed on the Thank You page.');?>
            </p>
        </div>
    </div>
</fieldset>
