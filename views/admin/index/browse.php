<?php
$pageTitle = __('Simple Contacts (%s total)', $total_results);
queue_css_file('simple-contact');
queue_js_file('simple-contact');
queue_js_file('simple-contact-browse');
echo head(array(
    'title' => $pageTitle,
    'bodyclass' => 'simple-contacts browse',
));
?>
<?php echo flash(); ?>
<?php if (!Omeka_Captcha::isConfigured()): ?>
    <p class="alert"><?php echo __("You have not entered your %s API keys under %s. We recommend adding these keys, or the contact form will be vulnerable to spam.", '<a href="http://recaptcha.net/">reCAPTCHA</a>', "<a href='" . url('security#recaptcha_public_key') . "'>" . __('security settings') . "</a>");?></p>
<?php endif; ?>

<?php if ($total_results): ?>
    <?php echo pagination_links(); ?>

    <form action="<?php echo html_escape(url('simple-contact/index/batch-edit')); ?>" method="post" accept-charset="utf-8">
        <div class="table-actions batch-edit-option">
            <?php if (is_allowed('SimpleContact_Contact', 'update')): ?>
            <input type="submit" class="small green batch-action button" name="submit-batch-answer" value="<?php echo __('Answered'); ?>">
            <input type="submit" class="small green batch-action button" name="submit-batch-set-spam" value="<?php echo __('Spam'); ?>">
            <input type="submit" class="small green batch-action button" name="submit-batch-set-not-spam" value="<?php echo __('Not Spam'); ?>">
            <?php endif; ?>
            <?php if (is_allowed('SimpleContact_Contact', 'delete')): ?>
            <input type="submit" class="small red batch-action button" name="submit-batch-delete" value="<?php echo __('Delete'); ?>">
            <?php endif; ?>
        </div>

        <?php echo common('quick-filters'); ?>

        <table id="simple-contacts" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <?php if (is_allowed('SimpleContact_Contact', 'update')): ?>
                <th class="batch-edit-heading"><?php echo __('Select'); ?></th>
                <?php endif; ?>
                <?php
                $browseHeadings[__('Status')] = 'status';
                $browseHeadings[__('Is Spam')] = 'is_spam';
                $browseHeadings[__('Name/Email')] = 'email';
                $browseHeadings[__('Message')] = null;
                $browseHeadings[__('Path')] = null;
                $browseHeadings[__('User')] = 'user_id';
                $browseHeadings[__('Date')] = 'added';
                echo browse_sort_links($browseHeadings, array('link_tag' => 'th scope="col"', 'list_tag' => ''));
                ?>
            </tr>
        </thead>
        <tbody>
            <?php $key = 0; ?>
            <?php foreach (loop('simple_contacts') as $simple_contact): ?>
            <tr class="simple-contact <?php if(++$key%2==1) echo 'odd'; else echo 'even'; ?>">
                <?php if (is_allowed('SimpleContact_Contact', 'update')): ?>
                <td class="batch-edit-check" scope="row">
                    <input type="checkbox" name="simple-contacts[]" value="<?php echo $simple_contact->id; ?>" />
                </td>
                <?php endif; ?>
                <td class="simple-contact-status">
                    <?php switch ($simple_contact->status) {
                        case 'answered': $status = __('Answered'); break;
                        case 'received': $status = __('Received'); break;
                        default: $status = __('Undefined');
                    } ?>
                    <a href="<?php echo ADMIN_BASE_URL; ?>" id="simple-contact-<?php echo $simple_contact->id; ?>" class="simple-contact toggle-status status <?php echo $simple_contact->status; ?>"><?php echo $status; ?></span>
                </td>
                <td class="simple-contact-is-spam">
                    <?php switch ($simple_contact->is_spam) {
                        case 0: $is_spam = __('Not Spam'); $is_spam_class = 'not-spam'; break;
                        case 1: $is_spam = __('Spam'); $is_spam_class = 'spam'; break;
                        default: $is_spam = __('Undefined'); $is_spam_class = 'undefined';
                    } ?>
                    <a href="<?php echo ADMIN_BASE_URL; ?>" id="simple-contact-<?php echo $simple_contact->id; ?>" class="simple-contact toggle-is-spam is-spam <?php echo $is_spam_class; ?>"><?php echo $is_spam; ?></span>
                </td>
                <td class="simple-contact-name-email">
                    <a href="mailto:<?php echo $simple_contact->email; ?>">
                        <?php echo html_escape($simple_contact->name); ?>
                    </a>
                </td>
                <td class="simple-contact-message">
                    <?php echo html_escape($simple_contact->message); ?>
                </td>
                <td class="simple-contact-path">
                    <?php echo html_escape($simple_contact->path); ?>
                </td>
                <td>
                    <?php echo html_escape(metadata($simple_contact, 'added_username')); ?>
                </td>
                <td>
                    <?php echo html_escape(format_date($simple_contact->added, Zend_Date::DATETIME_SHORT)); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>

        <div class="table-actions batch-edit-option">
            <?php if (is_allowed('SimpleContact_Contact', 'update')): ?>
            <input type="submit" class="small green batch-action button" name="submit-batch-answer" value="<?php echo __('Answered'); ?>">
            <input type="submit" class="small green batch-action button" name="submit-batch-set-spam" value="<?php echo __('Spam'); ?>">
            <input type="submit" class="small green batch-action button" name="submit-batch-set-not-spam" value="<?php echo __('Not Spam'); ?>">
            <?php endif; ?>
            <?php if (is_allowed('SimpleContact_Contact', 'delete')): ?>
            <input type="submit" class="small red batch-action button" name="submit-batch-delete" value="<?php echo __('Delete'); ?>">
            <?php endif; ?>
        </div>

        <?php echo common('quick-filters'); ?>
    </form>

    <?php echo pagination_links(); ?>

    <script type="text/javascript">
        Omeka.messages = jQuery.extend(Omeka.messages,
            {'simpleContact':{
                'answered':'<?php echo __('Answered'); ?>',
                'received':'<?php echo __('Received'); ?>',
                'spam':'<?php echo __('Spam'); ?>',
                'notSpam':'<?php echo __('Not Spam'); ?>',
                'undefined':'<?php echo __('Undefined'); ?>',
                'confirmation':'<?php echo __('Are your sure to remove these simple contacts?'); ?>'
            }}
        );
        Omeka.addReadyCallback(Omeka.SimpleContactsBrowse.setupBatchEdit);
    </script>

<?php else: ?>
    <?php if (total_records('SimpleContact') == 0): ?>
    <h2><?php echo __('There is no simple contact yet.'); ?></h2>
    <?php else: ?>
    <p><?php echo __('The query searched %s records and returned no results.', total_records('SimpleContact')); ?></p>
    <p><a href="<?php echo url('simple-contact/contact/browse'); ?>"><?php echo __('See all simple contacts.'); ?></p>
    <?php endif; ?>
<?php endif; ?>
<?php echo foot(); ?>
