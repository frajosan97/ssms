<?php

/**
 * About controller
 */

class About
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('About', $data, __FUNCTION__);
    }
}
