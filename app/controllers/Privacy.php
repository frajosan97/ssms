<?php

/**
 * Privacy controller
 */

class Privacy
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('Privacy', $data, __FUNCTION__);
    }
}
