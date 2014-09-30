<?php echo head(); ?>
<div id="primary">
    <?php echo flash(); ?>
    <h1><?php echo html_escape(get_option('simple_contact_page_contact_title')); ?></h1>
    <div id="form-instructions">
        <?php echo get_option('simple_contact_page_contact_text'); // HTML ?>
    </div>
    <?php echo $this->simpleContactForm(); ?>
</div>
<?php echo foot();
