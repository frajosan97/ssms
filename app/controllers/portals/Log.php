<?php

/**
 * Log controller
 */

class Log
{
    use Controller;

    public function index()
    {
        $data = [];
        $data['logs'] = read_log();
        $this->view('Log', $data);
    }
}
