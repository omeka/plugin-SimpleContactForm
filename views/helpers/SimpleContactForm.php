<?php
/**
 * SimpleContactForm
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @copyright Copyright Daniel Berthereau, 2013
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * Return the site-wide simple contact form.
 *
 * @package SimpleContactForm
 */
class SimpleContactForm_View_Helper_SimpleContactForm extends Zend_View_Helper_Abstract
{
    /**
     * Return the site-wide search form.
     *
     * @param array $options Valid options are as follows:
     * - name: name of user if filled.
     * - email: email of user if filled.
     * - message: message to send if filled.
     * - captcha: captcha if filled.
     * - form_attributes: an array containing form tag attributes.
     *
     *  @return string The search form markup.
     */
    public function simpleContactForm(array $options = array())
    {
        $defaultOptions = array(
            'name' => '',
            'email' => '',
            'message' => '',
            'captcha' => '',
            'form_attributes' => array(),
        );

        $options += $defaultOptions;

        // Set the default form attributes.
        $options['form_attributes']['method'] = 'post';
        if (!isset($options['form_attributes']['action'])) {
            $url = url(SIMPLE_CONTACT_FORM_PAGE_PATH);
            $options['form_attributes']['action'] = $url;
        }
        if (!isset($options['form_attributes']['id'])) {
            $options['form_attributes']['id'] = 'contact-form';
        }
        if (!isset($options['form_attributes']['enctype'])) {
            $options['form_attributes']['enctype'] = 'multipart/form-data';
        }
        if (!isset($options['form_attributes']['accept-charset'])) {
            $options['form_attributes']['accept-charset'] = 'utf-8';
        }

        return $this->view->partial(
            'index/simple-contact-form.php',
            array('options' => $options)
        );
    }
}
