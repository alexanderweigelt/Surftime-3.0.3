<?php

/**
 * Session
 *
 * *Description* Global Session Management
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

namespace Framework;


/**
 * Class Session
 * @package Framework
 */
class Session {

    /**
     * Default Session Age.
     *
     * The number of seconds of inactivity before a session expires.
     *
     * @var integer
     */
    
    protected $sessionLifetime = 1800;

    /**
     * Construct
     *
     * *Description*
     *
     * @param string $name
     * @param integer $lifetime
     *
     */

    public function __construct($name = '', $lifetime = ''){
        $name = (!empty($name) and is_string($name)) ? $name : $_SERVER['HTTP_HOST'];
        //define Session Name
        if(!defined(SESSION_NAME)){
            define('SESSION_NAME', $name);
        }

        // Session start
        session_name(SESSION_NAME);
        if(!$this->setLifetime($lifetime)){
            $this->_init();
        }
    }

    /**
     * Set Session
     *
     * *Description* Writes a value to the current session data.
     *
     * @param string $key String identifier.
     * @param mixed $value Single value or array of values to be written.
     * @return mixed Value or array of values written.
     */

    public function writeSession($key, $value){
        $this->_init();
        $_SESSION[$key] = $value;
        $this->_age();
        return $value;
    }

    /**
     * Read Session
     *
     * *Description* Reads a specific value from the current session data.
     *
     * @param string $key String identifier.
     * @param boolean $child Optional child identifier for accessing array elements.
     * @return mixed Returns a string value upon success.  Returns FALSE upon failure.
     */

    public function readSession($key, $child = FALSE){
        if(is_string($key)){
            $this->_init();
            if (isset($_SESSION[$key])){
                $this->_age();

                if($child == FALSE){
                    return $_SESSION[$key];
                }
                else{
                    if(isset($_SESSION[$key][$child])){
                        return $_SESSION[$key][$child];
                    }
                }
            }
            return FALSE;
        }
        return FALSE;
    }

    /**
     * Delete Session
     *
     * *Description* Deletes a value from the current session data.
     *
     * @param string $key String identifying the array key to delete.
     * @return void
     */

    public function deleteSession($key){
        if(is_string($key)){
            $this->_init();
            unset($_SESSION[$key]);
            $this->_age();
        }
    }

    /**
     * Close Session
     *
     * *Description* Closes the current session and releases session file lock.
     *
     * @return boolean Returns TRUE upon success and FALSE upon failure.
     */

    public function closeSession(){
        if(!empty(session_id())){
            session_write_close();
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Destroy Session
     *
     * *Description* Removes session data and destroys the current session.
     *
     * @return void
     */

    public function destroySession(){
        $_SESSION = [];
        session_destroy();
        setcookie(SESSION_NAME, "", time() - $this->sessionLifetime * 10);
    }

    /**
     * Set Lifetime
     *
     * *Description* Set the lifetime for a session.
     *
     * @return boolean
     */

    public function setLifetime($lifetime){
        if(!empty($lifetime) and is_integer($lifetime)){
            $this->_init();
            $this->sessionLifetime = $lifetime;
            $this->_age();
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Params
     *
     **Description*  Returns current session cookie parameters or an empty array.
     *
     * @return array Associative array of session cookie parameters.
     */

    public function getSessionParams(){
        $r = [];
        if(!empty(session_id())){
            $r = session_get_cookie_params();
        }
        return $r;
    }

    /**
     * Dump Session
     *
     * *Description* Echos current session data.
     *
     * @return void
     */

    public function dumpSession(){
        $this->_init();
        echo nl2br(print_r($_SESSION));
    }

    /**
     * Age of Session
     *
     * *Description* Expires a session if it has been inactive for a specified amount of time.
     *
     * @return void
     */

    private function _age(){
        $last = isset($_SESSION['lastdone']) ? $_SESSION['lastdone'] : FALSE ;

        if ($last and (time() - $last > $this->sessionLifetime)){
            $this->destroySession();
        }
        else{
            $_SESSION['lastdone'] = time();
        }
    }

    /**
     * Initialize Session
     *
     * *Description* Initializes a new session or resumes an existing session.
     *
     * @return boolean Returns TRUE upon success and FALSE upon failure.
     */

    private function _init(){
        if(session_status() !== PHP_SESSION_DISABLED){
            if(empty(session_id())) {
                return session_start();
            }
            // create a new Session ID
            return session_regenerate_id(TRUE);
        }
        return FALSE;
    }
}