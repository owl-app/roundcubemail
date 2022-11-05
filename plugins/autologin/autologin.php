<?php

/**
 * Plugin to login by crypted token
 *
 * @license GNU GPLv3+
 * @author Paweł Kęska
 */
class autologin extends rcube_plugin
{
    public $task = 'login';

    /**
     * Plugin initialization
     */
    public function init()
    {
        $this->add_hook('startup', [$this, 'startup']);
        $this->add_hook('authenticate', [$this, 'authenticate']);
    }

    /**
     * 'startup' hook handler
     *
     * @param array $args Hook arguments
     *
     * @return array Hook arguments
     */
    function startup($args)
    {
        // change action to login
        if(isset($_GET['_token'])) {
            $args['action'] = 'login';
        }

        return $args;
    }

    /**
     * 'authenticate' hook handler
     *
     * @param array $args Hook arguments
     *
     * @return array Hook arguments
     */
    function authenticate($args)
    {
        $token = $_GET['_token'];

        if (!empty($token)) {
            $rcmail = rcmail::get_instance();
            $data = $rcmail->decrypt($token);
            $dataDecrypted = json_decode($rcmail->decrypt($token));

            $args['user']        = $dataDecrypted->email;
            $args['pass']        = $dataDecrypted->password;
            $args['host']        = $dataDecrypted->host;
            $args['cookiecheck'] = false;
            $args['valid']       = true;
        }

        return $args;
    }
}
