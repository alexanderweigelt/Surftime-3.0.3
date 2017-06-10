<?php

/**
 * Login Controller
 *
 * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

namespace Controller;


/**
 * Class LoginController
 * @package Controller
 */

class LoginController {

	/** Properties */
	public $loginData = [];
	private $entries;
	private $request;
	private $maxLifetime;
	private $response;

	/**
	 * LoginController constructor.
	 */

	public function __construct() {
		// Start new session
		$this->Session = new \Framework\Session( 'LOGIN' );
	}


	/**
	 * Returns a value of session max lifetime
	 *
	 * @return int
	 */

	public function getMaxLifetime() {
		return $this->maxLifetime;
	}

	/**
	 * @param int $maxLifetime
	 */

	public function setMaxLifetime( $maxLifetime ) {
		$this->maxLifetime = $maxLifetime;
	}

	/**
	 * Returns a Model GetContent
	 *
	 * @return \Model\GetContent
	 */

	public function getEntriesData() {
		return $this->entries;
	}

	/**
	 * Set a instance from Model GetContent
	 */

	public function setEntriesData( $object ) {
		$this->entries = $object;
	}

	/**
	 * @return mixed
	 */

	public function getRequest() {
		return $this->request;
	}

	/**
	 * @param mixed $request
	 */

	public function setRequest( $request ) {
		$this->request = $request;
	}

	/**
	 * @return mixed
	 */

	public function getResponse() {
		return $this->response;
	}

	/**
	 * @param mixed $response
	 */

	public function setResponse( $response ) {
		$this->response = $response;
	}

	/**
	 * Log in
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return
	 */

	public function SetLogin() {
		$this->SetDurationLogin();
		$msg = 'error';

		foreach ( $this->getRequest() as $k => $v ) {
			$$k = (string)trim( strip_tags( $v ) );
		}
		if ( empty( $loginUser ) or empty( $loginPass ) ) {
			return $msg;
		}
		else {
			// Get admin data
			$login = $this->getEntriesData()->getUserData( $loginUser );

			/** @var string $loginPass */
			if ( $login['password'] === crypt( $loginPass, $login['password'] ) ) {
				$this->Session->writeSession( 'auth', true );
				$this->Session->writeSession( 'password', $login['passowrd'] );
				// set up user roles and permissions
				$this->Session->writeSession( 'role', $login['status'] );

				$this->getResponse()->modifyHeader('status', 302, TRUE);
				$this->getResponse()->modifyHeader('location', DIR . '?tab=1', TRUE);
				$this->getResponse()->sendHeaders();
			} else {
				$this->Session->destroySession();
				return $msg;
			}
		}
	}

	/**
	 * Check status
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return boolean
	 */

	public function CheckLogin() {
		$login = false;
		$auth  = $this->Session->readSession( 'auth' );
		if ( ! empty( $auth ) and $auth === true ) {
			$login = true;
		}

		return $login;
	}

	/**
	 * Log out
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return
	 */

	public function Logout() {
		$this->Session->destroySession();
		$this->getResponse()->modifyHeader('status', 302, TRUE);
		$this->getResponse()->modifyHeader('location', DIR, TRUE);
		$this->getResponse()->sendHeaders();
	}

	/**
	 * Set Duration login
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return void
	 */

	public function SetDurationLogin() {
		$setup = $this->getEntriesData()->getSetup();
		if ( empty( $setup['logout'] ) and $setup['logout'] == false ) {
			$this->Session->setLifetime( $this->getMaxLifetime() );
		}
	}

	public function sendForgetPassword() {
		
	}
}