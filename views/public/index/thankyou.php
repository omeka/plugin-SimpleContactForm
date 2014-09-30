<?php echo head(); ?>
<div id="primary">
    <?php echo flash(); ?>
    <h1><?php echo html_escape(get_option('simple_contact_page_thankyou_title')); // Not HTML ?></h1>
    <?php echo get_option('simple_contact_page_thankyou_text'); // HTML ?>
</div>
<?php echo foot(); ?>
