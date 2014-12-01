<?php
/**
 * The Simple Contact Ajax controller class.
 *
 * @package SimpleContact
 */
class SimpleContact_AjaxController extends Omeka_Controller_AbstractActionController
{
    /**
     * Controller-wide initialization. Sets the underlying model to use.
     */
    public function init()
    {
        // Don't render the view script.
        $this->_helper->viewRenderer->setNoRender(true);

        $this->_helper->db->setDefaultModelName('SimpleContact');
    }

    /**
     * Handle AJAX requests to update a tagging.
     */
    public function updateAction()
    {
        if (!$this->_checkAjax('update')) {
            return;
        }

        // Handle action.
        try {
            $status = $this->_getParam('status');
            $is_spam = $this->_getParam('is_spam');
            if (!empty($status)) {
                if (!in_array($status, array('received', 'answered'))) {
                    $this->getResponse()->setHttpResponseCode(400);
                    return;
                }
            }
            elseif (!empty($is_spam)) {
                if (!in_array($is_spam, array('spam', 'not spam'))) {
                    $this->getResponse()->setHttpResponseCode(400);
                    return;
                }
            }
            else {
                $this->getResponse()->setHttpResponseCode(400);
                return;
            }

            $id = (integer) $this->_getParam('id');
            $simpleContact = $this->_helper->db->find($id);
            if (!$simpleContact) {
                $this->getResponse()->setHttpResponseCode(400);
                return;
            }
            if (!empty($status)) {
                $simpleContact->saveStatus($status);
            }
            else {
                $simpleContact->saveIsSpam($is_spam == 'not spam' ? 0 : 1);
            }
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(500);
        }
    }

    /**
     * Handle AJAX requests to delete a tagging.
     */
    public function deleteAction()
    {
        if (!$this->_checkAjax('delete')) {
            return;
        }

        // Handle action.
        try {
            $id = (integer) $this->_getParam('id');
            $simpleContact = $this->_helper->db->find($id);
            if (!$simpleContact) {
                $this->getResponse()->setHttpResponseCode(400);
                return;
            }
            $simpleContact->delete();
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(500);
        }
    }

    /**
     * Check AJAX requests.
     *
     * 400 Bad Request
     * 403 Forbidden
     * 500 Internal Server Error
     *
     * @param string $action
     */
    protected function _checkAjax($action)
    {
        // Only allow AJAX requests.
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            $this->getResponse()->setHttpResponseCode(403);
            return false;
        }

        // Allow only valid calls.
        if ($request->getControllerName() != 'ajax'
                || $request->getActionName() != $action
            ) {
            $this->getResponse()->setHttpResponseCode(400);
            return false;
        }

        // Allow only allowed users.
        if (!is_allowed('SimpleContact_Contact', $action)) {
            $this->getResponse()->setHttpResponseCode(403);
            return false;
        }

        return true;
    }
}
