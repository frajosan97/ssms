<?php

/**
 * Printtemp controller
 */

class Printtemp
{
    use Controller;

    public function index($rectKey = "")
    {
        $data = [];
        $App = new App;
        if (empty($invoiceKey)) {
            if (isset($_COOKIE['recent_payment'])) {
                $data['payReceipt'] = $App->payReceipt($_COOKIE['recent_payment']);
            }
        } else {
            $data['payReceipt'] = $App->payReceipt($invoiceKey);
        }
        $this->view('Printtemp', $data, __FUNCTION__);
    }

    public function expense($invoiceKey = "")
    {
        $data = [];
        $App = new App;
        if (empty($invoiceKey)) {
            if (isset($_COOKIE['recent_exp_inv'])) {
                $data['expInvInfo'] = $App->expInvInfo($_COOKIE['recent_exp_inv']);
            }
        } else {
            $data['expInvInfo'] = $App->expInvInfo($invoiceKey);
        }
        $this->view('Printtemp', $data, __FUNCTION__);
    }
}
