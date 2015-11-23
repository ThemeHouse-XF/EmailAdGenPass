<?php

/**
 *
 * @see XenForo_DataWriter_User
 */
class ThemeHouse_EmailAdGenPass_Extend_XenForo_DataWriter_User extends XFCP_ThemeHouse_EmailAdGenPass_Extend_XenForo_DataWriter_User
{

    protected $_password = '';

    public function setPassword($password, $passwordConfirm = false, XenForo_Authentication_Abstract $auth = null,
        $requirePassword = false)
    {
        if (parent::setPassword($password, $passwordConfirm, $auth, $requirePassword)) {
            $this->_password = $password;

            return true;
        }

        return false;
    }

    protected function _postSave()
    {
        parent::_postSave();

        if ($this->getOption(self::OPTION_ADMIN_EDIT) && $this->get('email') && $this->_password) {
            $xenOptions = XenForo_Application::get('options');
            if (($this->isInsert() && $xenOptions->th_emailAdGenPass_newUsers) ||
                 ($this->isUpdate() && $xenOptions->th_emailAdGenPass_existingUsers)) {
                $params = array(
                    'user' => $this->getMergedData(),
                    'password' => $this->_password,
                    'boardTitle' => XenForo_Application::get('options')->boardTitle,
                    'boardUrl' => XenForo_Application::get('options')->boardUrl
                );
                $mail = XenForo_Mail::create('th_user_password_emailadgenpass', $params,
                    $this->get('language_id'));
                $mail->send($this->get('email'), $this->get('username'));
            }
        }
    }
}