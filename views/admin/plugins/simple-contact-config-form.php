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
<fieldset id="fieldset-simple-contact-pages"><legend><?php echo __('Contact Page'); ?></legend>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_page_contact_title', __('Contact Page Title')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_page_contact_title', __($page_contact_title), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The title of the contact form (not HTML).'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_page_contact_text', __('Instructions for Contact Page')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_page_contact_text', __($page_contact_text), array('rows' => '10', 'class' => array('textinput', 'html-editor'))); ?>
            </div>
            <p class="explanation">
                <?php echo __('Any specific instructions to add to the contact form.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_page_contact_add_to_main_navigation', __('Add to Main Navigation')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formCheckbox('simple_contact_page_contact_add_to_main_navigation', $page_contact_add_to_main_navigation, null, array('1', '0')); ?>
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
            <?php echo $view->formLabel('simple_contact_page_thankyou_title', __('Thank You Page Title')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_page_thankyou_title', __($page_thankyou_title), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php __('The title of the Thank You page (not HTML).');?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_page_thankyou_text', __('Thank You Page Message')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_page_thankyou_text', __($page_thankyou_text), array('rows' => '10', 'class' => array('textinput', 'html-editor'))); ?>
            </div>
            <p class="explanation">
                <?php __('The text displayed on the Thank You page.');?>
            </p>
        </div>
    </div>
</fieldset>
<fieldset id="fieldset-simple-contact-email"><legend><?php echo __('Notification Email'); ?></legend>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_notification_admin_to', __('Forward-To Email')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_notification_admin_to', $notification_admin_from, array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The email address that receives notifications that someone has submitted a message through the contact form. If blank, you will not be forwarded messages from your users.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_notification_admin_subject', __('Email Subject (Admin Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_notification_admin_subject', __($notification_admin_subject), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The subject line for the email that is sent to the Forward-To email address.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_notification_admin_header', __('Email Message (Admin Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_notification_admin_header', __($notification_admin_header), array('rows' => '10', 'class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The beginning of the message that is sent to the Forward-To email address.'); ?>
            </p>
        </div>
    </div>
</fieldset>
<fieldset id="fieldset-simple-contact-email"><legend><?php echo __('Confirmation Email'); ?></legend>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_notification_user_from', __('Reply-From Email')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_notification_user_from', $notification_user_from, array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The address that users can reply to. If blank, your users will not be sent confirmation emails of their submissions.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_notification_user_subject', __('Email Subject (Public Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formText('simple_contact_notification_user_subject', __($notification_user_subject), array('class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The subject line of the confirmation email that is sent to users who post messages through the form.'); ?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_notification_user_header', __('Email Message (Public Notification)')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formTextarea('simple_contact_notification_user_header', __($notification_user_header), array('rows' => '10', 'class' => 'textinput')); ?>
            </div>
            <p class="explanation">
                <?php echo __('The beginning of the confirmation email that is sent to users who post messages through the form.'); ?>
            </p>
        </div>
    </div>
</fieldset>
<fieldset id="fieldset-simple-contact-roles"><legend><?php echo __('Manage messages'); ?></legend>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('simple_contact_save_into_base', __('Save received messages into base')); ?>
        </div>
        <div class='inputs five columns omega'>
            <div class='input-block'>
                <?php echo $view->formCheckbox('simple_contact_save_into_base', $save_into_base, null, array('1', '0')); ?>
            </div>
            <p class="explanation">
                <?php echo __('If checked, all received messages will be saved into a specific table of the base.');?>
            </p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <label><?php echo __("Roles that can manage emails"); ?></label>
        </div>
        <div class="inputs five columns omega">
            <div class="input-block">
                <?php
                    $userRoles = get_user_roles();
                    unset($userRoles['super']);
                    echo '<ul>';
                    foreach ($userRoles as $role => $label) {
                        echo '<li>';
                        echo $view->formCheckbox('simple_contact_manage_roles[]', $role, array(
                            'checked'=> in_array($role, $manage_roles) ? 'checked' : '',
                        ));
                        echo $label;
                        echo '</li>';
                    }
                    echo '</ul>';
                ?>
            </div>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <label><?php echo __("WordPress API key for Akismet"); ?></label>
        </div>
        <div class="inputs five columns omega">
            <div class="input-block">
                <?php echo $view->formText('simple_contact_wpapi_key', $wpapi_key,
                    array('size' => 45)
                );?>
            </div>
            <p class="explanation">
                <?php echo __('This key allows to check if the message is a spam.');?>
            </p>
        </div>
    </div>
</fieldset>
