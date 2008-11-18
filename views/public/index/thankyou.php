<?php head(); ?>
<h1><?php echo get_option('simple_contact_form_thankyou_page_title'); ?></h1>
<?php echo nls2p(get_option('simple_contact_form_thankyou_page_message')); ?>

<?php print_r($renderVars);?>
<?php foot(); ?>