<?php

/**
 * Plugin to unauthorized page
 *
 * @license GNU GPLv3+
 * @author Paweł Kęska
 */
class unauthorized extends rcube_plugin
{
    public $task = 'login';

    /**
     * Plugin initialization
     */
    public function init()
    {
        $this->registerUiHandlers();

        $this->add_hook('unauthenticated', [$this, 'unauthenticated']);
    }

    /**
     * 'unauthenticated' hook handler
     *
     * @param array $args Hook arguments
     *
     * @return array Hook arguments
     */
    function unauthenticated($args)
    {
        $args['task'] = 'unauthorized';

        return $args;
    }

    /**
     * Register UI objects
     */
    private function registerUiHandlers()
    {
        $rcmail = rcmail::get_instance();

        // register UI objects
        $rcmail->output->add_handlers([
            'title_message_unauthorized'  => [$this, 'title_message_unauthorized'],
            'info_message_unauthorized'  => [$this, 'info_message_unauthorized']
        ]);
    }

    function title_message_unauthorized()
    {
        $error = isset($GLOBALS['error_message']) ? $GLOBALS['error_message'] : 'accessdenied';

        return $this->gettext($error);
    }

    function info_message_unauthorized()
    {
        return $this->gettext('infounauthorized');
    }
}
