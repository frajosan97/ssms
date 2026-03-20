<?php

/**
 * Home controller
 */

class Home
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('Home', $data, __FUNCTION__);
    }
}
