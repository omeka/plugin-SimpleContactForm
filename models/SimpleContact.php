<?php

class SimpleContact extends Omeka_Record_AbstractRecord
{
    public $id;
    public $status;
    public $is_spam;
    public $email;
    public $name;
    public $message;
    public $path;
    public $ip;
    public $user_agent;
    public $user_id;
    public $added;

    /**
     * Get the user object.
     *
     * @return User
     */
    public function getAddedByUser()
    {
        return $this->getTable('User')->find($this->user_id);
    }

    public function checkSpam()
    {
        $wordPressAPIKey = get_option('simple_contact_wpapi_key');
        if (!empty($wordPressAPIKey)) {
            $ak = new Zend_Service_Akismet($wordPressAPIKey, WEB_ROOT );
            $data = $this->getAkismetData();
            try {
                $this->is_spam = $ak->isSpam($data);
            } catch (Exception $e) {
                $this->is_spam = 1;
            }
        }
        // If not using Akismet.
        else {
            $this->is_spam = 2;
        }
    }

    public function getAkismetData()
    {
        $serverUrlHelper = new Zend_View_Helper_ServerUrl;
        $permalink = $serverUrlHelper->serverUrl() . $this->path;
        $data = array(
            'user_ip' => $this->ip,
            'user_agent' => $this->user_agent,
            'permalink' => $permalink,
            'comment_type' => 'message',
            'comment_author_email' => $this->email,
            'comment_content' => $this->message,
        );
        if ($this->name) {
            $data['comment_author_name'] = $this->name;
        }
        return $data;
    }

    /**
     * Set status and save simple contact if needed.
     */
    public function saveStatus($status)
    {
        if (empty($this->id) || $this->status != $status) {
            $this->status = $status;
            $this->save();
        }
    }

    /**
     * Set spam status and save simple contact if needed.
     */
    public function saveIsSpam($is_spam)
    {
        if (empty($this->id) || $this->is_spam != $is_spam) {
            $this->is_spam = $is_spam;
            $this->save();
        }
    }

    protected function _validate()
    {
        if (trim(strip_tags($this->message)) == '') {
            $this->addError('message', "Can't leave an empty message!");
        }
    }

    public function getProperty($property)
    {
        switch($property) {
            case 'added_username':
                $user = $this->getAddedByUser();
                return $user
                    ? $this->getAddedByUser()->username
                    : __('Anonymous');
            default:
                return parent::getProperty($property);
        }
    }
}
