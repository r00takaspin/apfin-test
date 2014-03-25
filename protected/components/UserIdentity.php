<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    #TODO: вынести шифрование пароля в отдельную функцию статическим методом
	public function authenticate()
	{
        $found = User::model()->find("login=:login AND passwd=:passwd",array("login"=>$this->username,"passwd"=>md5($this->password)));
		if (!$found)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
        {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $found->id;
        }
		return !$this->errorCode;
	}

    public function getId()
    {
        return $this->_id;
    }
}