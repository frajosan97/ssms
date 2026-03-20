<?php

/**
 * Contact controller
 */

class Contact
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('Contact', $data, __FUNCTION__);
    }
}
