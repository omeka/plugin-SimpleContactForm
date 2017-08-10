<?php

/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package SimpleContactForm
 */

/**
 * SimpleContactForm plugin class
 *
 * @copyright Center for History and New Media, 2010
 * @package SimpleContactForm
 */
// Define Constants.
define('SIMPLE_CONTACT_FORM_PAGE_PATH', 'contact/');
define('ALLOWED_FIELDNAME', "/^[a-z|0-9|\_|\-|\.]*$/i");

class SimpleContactFormPlugin extends Omeka_Plugin_AbstractPlugin
{
    // Define Hooks
    protected $_hooks = array(
        'install',
        'uninstall',
        'initialize',
        'define_routes',
        'config_form',
        'config'
    );

    //Add filters
    protected $_filters = array(
        'public_navigation_main'
    );

   public function hookInstall()
    {
        add_translation_source(dirname(__FILE__).'/languages');

        // Define Defaults
        set_option('simple_contact_form_reply_from_email', get_option('administrator_email'));
        set_option('simple_contact_form_forward_to_email', get_option('administrator_email'));

        set_option('simple_contact_form_admin_notification_email_subject', __('A User Has Contacted You'));
        set_option('simple_contact_form_admin_notification_email_message_header', __('A user has sent you the following message:'));
        set_option('simple_contact_form_user_notification_email_subject', __('Thank You'));
        set_option('simple_contact_form_user_notification_email_message_header', __('Thank you for sending us the following message:'));
        set_option('simple_contact_form_contact_page_title', __('Contact Us'));
        set_option('simple_contact_form_contact_page_instructions', __('Please send us your comments and suggestions.'));
        set_option('simple_contact_form_thankyou_page_title', __('Thank You For Your Feedback'));
        set_option('simple_contact_form_thankyou_page_message', __('We appreciate your comments and suggestions.'));

        set_option('simple_contact_form_add_to_main_navigation', 1);
        set_option('simple_contact_form_additional_fields', '');
        set_option('simple_contact_form_mandatory_additional_fields', '');
    }

    public function hookUninstall()
    {
        delete_option('simple_contact_form_reply_from_email');
        delete_option('simple_contact_form_forward_to_email');
        delete_option('simple_contact_form_admin_notification_email_subject');
        delete_option('simple_contact_form_admin_notification_email_message_header');
        delete_option('simple_contact_form_user_notification_email_subject');
        delete_option('simple_contact_form_user_notification_email_message_header');
        delete_option('simple_contact_form_contact_page_title');
        delete_option('simple_contact_form_contact_page_instructions');
        delete_option('simple_contact_form_thankyou_page_title');
        delete_option('simple_contact_form_add_to_main_navigation');
        delete_option('simple_contact_form_additional_fields');
        delete_option('simple_contact_form_mandatory_additional_fields');
    }

    /**
     * Add translation source.
     */
    public function hookInitialize()
    {
        add_translation_source(dirname(__FILE__).'/languages');
    }
    /**
     * Adds 2 routes for the form and the thank you page.
     **/
    function hookDefineRoutes($args)
    {
        $router = $args['router'];
        $router->addRoute(
            'simple_contact_form_form',
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_FORM_PAGE_PATH,
                array('module'       => 'simple-contact-form')
            )
        );

        $router->addRoute(
            'simple_contact_form_thankyou',
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_FORM_PAGE_PATH.'thankyou',
                array(
                    'module'       => 'simple-contact-form',
                    'controller'   => 'index',
                    'action'       => 'thankyou',
                )
            )
        );
    }

    public function hookConfigForm()
    {
        add_translation_source(dirname(__FILE__).'/languages');
        include 'config_form.php';
    }

    public function hookConfig($args)
    {
        $post = $args['post'];
        set_option('simple_contact_form_reply_from_email', $post['reply_from_email']);
        set_option('simple_contact_form_forward_to_email', $post['forward_to_email']);
        set_option('simple_contact_form_admin_notification_email_subject', $post['admin_notification_email_subject']);
        set_option('simple_contact_form_admin_notification_email_message_header', $post['admin_notification_email_message_header']);
        set_option('simple_contact_form_user_notification_email_subject', $post['user_notification_email_subject']);
        set_option('simple_contact_form_user_notification_email_message_header', $post['user_notification_email_message_header']);
        set_option('simple_contact_form_contact_page_title', $post['contact_page_title']);
        set_option('simple_contact_form_contact_page_instructions',$post['contact_page_instructions']);
        set_option('simple_contact_form_thankyou_page_title', $post['thankyou_page_title']);
        set_option('simple_contact_form_thankyou_page_message', $post['thankyou_page_message']);
        set_option('simple_contact_form_add_to_main_navigation', $post['add_to_main_navigation']);
        set_option('simple_contact_form_additional_fields', $post['additional_fields']);
        set_option('simple_contact_form_mandatory_additional_fields', $post['mandatory_fields']);
    }

    public function filterPublicNavigationMain($nav)
    {
        $contact_title = get_option('simple_contact_form_contact_page_title');
        $contact_add_to_navigation = get_option('simple_contact_form_add_to_main_navigation');
        if ($contact_add_to_navigation) {
            //$nav[$contact_title] = uri(array(), 'simple_contact_form_form');
                $nav[] = array(
                    'label'   => $contact_title,
                    'uri'     => url(array(),'simple_contact_form_form'),
                    'visible' => true
                );
        }
        return $nav;
    }

    public function prepareAdditionalFields() {

      $mandatory_fields = get_option('simple_contact_form_mandatory_additional_fields');
      $mandatoryFields = explode(";", $mandatory_fields);
      foreach(array_keys($mandatoryFields) as $key) {
        $mandatoryFields[$key] = trim($mandatoryFields[$key]);
        $match = preg_match(ALLOWED_FIELDNAME, $mandatoryFields[$key]);
        if (!$match) { unset($mandatoryFields[$key]); }
      }
      $mandatoryFields = array_flip($mandatoryFields);

      $additional_fields = get_option('simple_contact_form_additional_fields');
      $lines = explode("\n", $additional_fields);

      $result = array();

      foreach($lines as $line) {
        $params = explode(";", $line);
        foreach(array_keys($params) as $key) { $params[$key] = trim($params[$key]); }

        $fieldName = (isset($params[0]) ? $params[0] : false);
        $match = preg_match(ALLOWED_FIELDNAME, $fieldName);
        $fieldName = ( $match ? $fieldName : false );

        if ($fieldName) {
          $fieldLabel = (isset($params[1]) ? $params[1] : false);

          if ($fieldLabel) {
            $multiLine = ((isset($params[2])) and ($params[2] == "multi"));
            $dropDown = ((isset($params[2])) and ($params[2] == "dropdown") and (isset($params[3])));
            $dropDowns = array();

            if ($dropDown) {
              $dropDowns = array( -1 => __("Select Below") );
              for($i=3; $i<count($params); $i++) {
                $dropDowns[$params[$i]] = $params[$i];
                unset($params[$i]);
              }
            }

            $fieldType = "generic";
            if ($multiLine) { $fieldType = "multi"; }
            if ($dropDown) { $fieldType = "dropdown"; }

            $fieldValue = ( isset($_POST[$fieldName]) ? $_POST[$fieldName] : "" );

            $result[] = array(
              "fieldName" => $fieldName,
              "fieldLabel" => $fieldLabel,
              "fieldType" => $fieldType,
              "dropDowns" => $dropDowns,
              "fieldValue" => $fieldValue,
              "mandatoryField" => intval( isset($mandatoryFields[$fieldName]) ),
            );

          }
        }
      }

      return $result;

    } // function prepareAdditionalFields()

}
