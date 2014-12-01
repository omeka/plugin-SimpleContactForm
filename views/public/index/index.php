<?php echo head(); ?>
<div id="primary">
    <?php echo flash(); ?>
        <h1><?php echo html_escape(get_option('simple_contact_form_contact_page_title')); ?></h1>
    <div id="simple-contact">
        <div id="form-instructions">
            <?php echo get_option('simple_contact_form_contact_page_instructions'); // HTML ?>
        </div>
        <?php echo $this->simpleContactForm(); ?>
    </div>
</div>
<?php echo foot();
