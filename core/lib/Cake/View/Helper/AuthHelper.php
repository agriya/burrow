<?php
// this class is taken from OthAuth
class AuthHelper extends Helper
{
    var $hashKey = null;
    var $initialized = false;
    var $helpers = array(
        'Session'
    );
    function init()
    {
        if (!$this->initialized) {
            // here the hash key for user session data is hard coded
            // Need to improve this code
            // This should be taken fron viewVars
            $this->hashKey = 'Auth.User';
            $this->initialized = true;
        }
    }
    function sessionValid()
    {
        $this->init();
        return ($this->Session->check($this->hashKey));
    }
    // Get User Variables
    function user($key)
    {
        $this->init();
        // does session exists
        if ($this->sessionValid()) {
            $user = $this->Session->read($this->hashKey);
            if (isset($user[$key])) {
                return $user[$key];
            }
        }
        return false;
    }
}
?>