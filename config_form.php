<?php echo js_tag('vendor/tinymce/tinymce.min'); ?>
<script type="text/javascript">
jQuery(document).ready(function () {
    Omeka.wysiwyg({
        selector: '.html-editor'
    });
});
</script>

<?php
$forward_to_email                        = get_option('simple_contact_form_forward_to_email');	
$contact_page_title                      = get_option('simple_contact_form_contact_page_title');
$contact_page_instructions               = get_option('simple_contact_form_contact_page_instructions');
$thankyou_page_title                     = get_option('simple_contact_form_thankyou_page_title');
$thankyou_page_message                   = get_option('simple_contact_form_thankyou_page_message');
$add_to_main_navigation                  = get_option('simple_contact_form_add_to_main_navigation');

$view = get_view();
?>

<?php if (!Omeka_Captcha::isConfigured()): ?>
    <p class="alert">You have not entered your <a href="http://www.google.com/recaptcha/intro/index.html/">reCAPTCHA</a>
        API keys under <a href="<?php echo url('settings/edit-security#fieldset-captcha'); ?>">security settings</a>. We recommend adding these keys, or the contact form will be vulnerable to spam.</p>
<?php endif; ?>

<div class="field">
    <div class="two columns alpha">
        <?php echo $view->formLabel('forward_to_email', 'Forward-To Email'); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            The email address that receives notifications that someone has
            submitted a message through the contact form. If blank, you will not
            be forwarded messages from your users.
        </p>
        <?php echo $view->formText('forward_to_email', $forward_to_email); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <?php echo $view->formLabel('contact_page_title', 'Contact Page Title'); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            The title of the contact form (not HTML).
        </p>
        <?php echo $view->formText('contact_page_title', $contact_page_title); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <?php echo $view->formLabel('contact_page_instructions', 'Instructions for Contact Page'); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            Any specific instructions to add to the contact form.
        </p>
        <?php echo $view->formTextarea('contact_page_instructions', $contact_page_instructions, array('rows' => '10', 'cols' => '60', 'class' => array('html-editor'))); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <?php echo $view->formLabel('add_to_main_navigation', 'Add to Main Navigation'); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            If checked, add a link to the contact form to the main site
            navigation.
        </p>
        <?php echo $view->formCheckbox('add_to_main_navigation', $add_to_main_navigation, null, array('1', '0')); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <?php echo $view->formLabel('thankyou_page_title', 'Thank You Page Title'); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            The title of the Thank You page (not HTML).
        </p>
        <?php echo $view->formText('thankyou_page_title', $thankyou_page_title); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <?php echo $view->formLabel('thankyou_page_message', 'Thank You Page Message'); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            The text displayed on the Thank You page.
        </p>
        <?php echo $view->formTextarea('thankyou_page_message', $thankyou_page_message, array('rows' => '10', 'cols' => '60', 'class' => array('html-editor'))); ?>
    </div>
</div>
