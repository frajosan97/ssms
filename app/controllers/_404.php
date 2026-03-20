<?php

/**
 * 404 controller
 */

class _404
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('404', $data, __FUNCTION__);
    }
}
