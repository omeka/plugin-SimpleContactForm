<?php echo js_tag('vendor/tiny_mce/tiny_mce'); ?>
<script type="text/javascript">
jQuery(window).load(function () {
    Omeka.wysiwyg({
        mode: 'specific_textareas',
        editor_selector: 'html-editor'
    });
});
</script>

<?php
$reply_from_email                        = get_option('simple_contact_form_reply_from_email');
$forward_to_email                        = get_option('simple_contact_form_forward_to_email');
$admin_notification_email_subject        = get_option('simple_contact_form_admin_notification_email_subject');
$admin_notification_email_message_header = get_option('simple_contact_form_admin_notification_email_message_header');
$user_notification_email_subject         = get_option('simple_contact_form_user_notification_email_subject');
$user_notification_email_message_header  = get_option('simple_contact_form_user_notification_email_message_header');
$contact_page_title                      = get_option('simple_contact_form_contact_page_title');
$contact_page_instructions               = get_option('simple_contact_form_contact_page_instructions');
$thankyou_page_title                     = get_option('simple_contact_form_thankyou_page_title');
$thankyou_page_message                   = get_option('simple_contact_form_thankyou_page_message');
$add_to_main_navigation                  = get_option('simple_contact_form_add_to_main_navigation');
$additional_fields                       = get_option('simple_contact_form_additional_fields');
$mandatory_fields                        = get_option('simple_contact_form_mandatory_additional_fields');

$view = get_view();
?>

<?php if (!Omeka_Captcha::isConfigured()): ?>
    <p class="alert">
      <?php
        echo sprintf(
          __('
            You have not entered your <a href="https://www.google.com/recaptcha/intro/" target="_blank">reCAPTCHA</a>
            API keys under <a href="%s">security settings</a>.
            We recommend adding these keys, or the contact form will be vulnerable to spam.
          '),
          url('settings/edit-security')
        );
      ?>
    </p>
<?php endif; ?>

<div class="field">
    <?php echo $view->formLabel('reply_from_email', __('Reply-From Email')); ?>
    <div class="inputs">
        <?php echo $view->formText('reply_from_email', $reply_from_email, array('class' => 'textinput')); ?>
        <p class="explanation">
          <?php echo __("The address that users can reply to. If blank, your users will not be sent confirmation emails of their submissions."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('forward_to_email', __('Forward-To Email')); ?>
    <div class="inputs">
        <?php echo $view->formText('forward_to_email', $forward_to_email, array('class' => 'textinput')); ?>
        <p class="explanation">
          <?php
          echo __("
            The email address that receives notifications that someone has
            submitted a message through the contact form. If blank, you will not
            be forwarded messages from your users.
          ");
          ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('admin_notification_email_subject', __('Email Subject (Admin Notification)')); ?>
    <div class="inputs">
        <?php echo $view->formText('admin_notification_email_subject', $admin_notification_email_subject, array('class' => 'textinput')); ?>
        <p class="explanation">
          <?php echo __("The subject line for the email that is sent to the Forward-To email address."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('admin_notification_email_message_header', __('Email Message (Admin Notification)')); ?>
    <div class="inputs">
        <?php echo $view->formTextarea('admin_notification_email_message_header', $admin_notification_email_message_header, array('rows' => '10', 'cols' => '60', 'class' => 'textinput')); ?>
        <p class="explanation">
          <?php echo __("The beginning of the message that is sent to the Forward-To email address."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('user_notification_email_subject', __('Email Subject (Public Notification)')); ?>
    <div class="inputs">
        <?php echo $view->formText('user_notification_email_subject', $user_notification_email_subject, array('class' => 'textinput')); ?>
        <p class="explanation">
          <?php echo __("The subject line of the confirmation email that is sent to users who post messages through the form."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('user_notification_email_message_header', __('Email Message (Public Notification)')); ?>
    <div class="inputs">
        <?php echo $view->formTextarea('user_notification_email_message_header', $user_notification_email_message_header, array('rows' => '10', 'cols' => '60', 'class' => 'textinput')); ?>
        <p class="explanation">
          <?php echo __("The beginning of the confirmation email that is sent to users who post messages through the form."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('contact_page_title', __('Contact Page Title')); ?>
    <div class="inputs">
        <?php echo $view->formText('contact_page_title', $contact_page_title, array('class' => 'textinput')); ?>
        <p class="explanation">
          <?php echo __("The title of the contact form (not HTML)."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('contact_page_instructions', __('Instructions for Contact Page')); ?>
    <div class="inputs">
        <?php echo $view->formTextarea('contact_page_instructions', $contact_page_instructions, array('rows' => '10', 'cols' => '60', 'class' => array('textinput', 'html-editor'))); ?>
        <p class="explanation">
          <?php echo __("Any specific instructions to add to the contact form."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('add_to_main_navigation', __('Add to Main Navigation')); ?>
    <div class="inputs">
        <?php echo $view->formCheckbox('add_to_main_navigation', $add_to_main_navigation, null, array('1', '0')); ?>
        <p class="explanation">
          <?php echo __("If checked, add a link to the contact form to the main site navigation."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('thankyou_page_title', __('Thank You Page Title')); ?>
    <div class="inputs">
        <?php echo $view->formText('thankyou_page_title', $thankyou_page_title, array('class' => 'textinput')); ?>
        <p class="explanation">
            <?php echo __("The title of the Thank You page (not HTML)."); ?>
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('thankyou_page_message', __('Thank You Page Message')); ?>
    <div class="inputs">
        <?php echo $view->formTextarea('thankyou_page_message', $thankyou_page_message, array('rows' => '10', 'cols' => '60', 'class' => array('textinput', 'html-editor'))); ?>
        <p class="explanation">
            <?php echo __("The text displayed on the Thank You page."); ?>
        </p>
    </div>
</div>

<div class="field">
   <?php echo $view->formLabel('additional_fields', __('Additional Fields')); ?>
   <div class="inputs">
       <?php echo $view->formTextarea('additional_fields', $additional_fields, array('rows' => '10', 'cols' => '60', 'class' => 'textinput')); ?>
       <div class="explanation">
         <p><?php echo __("If you wish to add additional fields (besides name, email, and message), you may specify them here, one per line."); ?></p>
         <p>
           <?php echo __("A line usually consists of the field name and the field label, separated by a semicolon. Like <pre>newfield;Additional Field</pre>"); ?>
           <?php echo __(" <em>Please note:</em> Field names may consist only of letters (a-z), numbers (0-9), underscores (_), dashes (-), or dots (.)."); ?>
         </p>
         <p><?php echo __("If you wish to have a multi-line text-field, add 'multi', like this: <pre>newmultifield;Additional Multi-Line Field;multi</pre>"); ?></p>
         <p><?php echo __("If you wish to have a dropdown selection, add 'dropdown', followed by the possible choices, like this: <pre>newdropdownfield;Additional Dropdown Field;dropdown;Choice 1;Choice 2;Choice 3</pre>"); ?></p>
       </div>
   </div>
</div>

<div class="field">
   <?php echo $view->formLabel('mandatory_fields', __('Mandatory Fields')); ?>
   <div class="inputs">
       <?php echo $view->formText('mandatory_fields', $mandatory_fields, array('class' => 'textinput')); ?>
       <div class="explanation">
           <p><?php echo __("If you defined additional fields, you may now specify which of them are mandatory, i.e. which should not be left blank."); ?></p>
           <p><?php echo __("You may specify them one by one, separated by semicolons, like this: <pre>field1;field2</pre>"); ?></p>
       </div>
   </div>
</div>
