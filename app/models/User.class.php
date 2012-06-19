<?php
class User
{
	var $_user_id;
	var $_email;
	var $_nonce;
	var $_password;
	var $_display_name;
	var $_biography;
	
	public function __construct($params) {
		if (isset($params['user_id'])) {
			$this->setUserId($params['user_id']);
		}
		if (isset($params['email'])) {
			$this->setEmail($params['email']);
		}
		if (isset($params['nonce'])) {
			$this->setNonce($params['nonce']);
		}
		if (isset($params['password'])) {
			$this->setPassword($params['password']);
		}
		if (isset($params['display_name'])) {
			$this->setDisplayName($params['display_name']);
		}
		if (isset($params['biography'])) {
			$this->setBiography($params['biography']);
		}
	}

	public function setUserId($user_id) {
		$this->_user_id = $user_id;
	}

	public function getUserId() {
		return $this->_user_id;
	}

	public static function isValidUserId($user_id) {
		return (is_numeric($user_id) && $user_id > 0);
	}

	public function getEmail() {
		return $this->_email;
	}

	private function setEmail($email) {
		$this->_email = $email;
	}

	public static function isValidEmail($email) {
		return (self::emailContainsCharacter($email, '@') 
					&& 
				self::emailContainsCharacter($email, '.')
		);
	}

	private static function emailContainsCharacter($email, $character) {
		return (strpos($email, $character) !== false);
	}
	
	public static function isValidPassword($password) {
		return (strlen($password) > 0);
	}

	public function setNonce($nonce) {
		$this->_nonce = $nonce;
	}

	public function getNonce() {
		return $this->_nonce;
	}

	public function setPassword($password) {
		$this->_password = $password;
	}

	public function getPassword() {
		return $this->_password;
	}

	public function setDisplayName($name) {
		$this->_display_name = $name;
	}

	public function getDisplayName() {
		return $this->_display_name;
	}

	public function setBiography($bio) {
		$this->_biography = $bio;
	}

	public function getBiography() {
		return $this->_biography;
	}

}
