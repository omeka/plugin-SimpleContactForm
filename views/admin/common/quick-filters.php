<ul class="quick-filter-wrapper">
    <li><a href="#" tabindex="0"><?php echo __('Quick Filter'); ?></a>
    <ul class="dropdown">
        <li><span class="quick-filter-heading"><?php echo __('Quick Filter') ?></span></li>
        <li><a href="<?php echo url('simple-contact/index/browse'); ?>"><?php echo __('View All') ?></a></li>
        <li><a href="<?php echo url('simple-contact/index/browse', array('status' => 'to_reply')); ?>"><?php echo __('To reply'); ?></a></li>
        <li><a href="<?php echo url('simple-contact/index/browse', array('status' => 'received')); ?>"><?php echo __('Received'); ?></a></li>
        <li><a href="<?php echo url('simple-contact/index/browse', array('status' => 'answered')); ?>"><?php echo __('Answered'); ?></a></li>
        <li><a href="<?php echo url('simple-contact/index/browse', array('is_spam' => 1)); ?>"><?php echo __('Spam'); ?></a></li>
        <li><a href="<?php echo url('simple-contact/index/browse', array('is_spam' => 0)); ?>"><?php echo __('Not Spam'); ?></a></li>
        <li><a href="<?php echo url('simple-contact/index/browse', array('is_spam' => 2)); ?>"><?php echo __('Undefined Spam Status'); ?></a></li>
    </ul>
    </li>
</ul>
