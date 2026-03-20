<?php

/**
 * Logout controller
 */

class Logout
{
    use Controller;

    public function index($account = "")
    {
        if (!empty($account)) {
            if (isset($_SESSION[$account])) {
                if ($account == "student") {
                    $userKey = $_SESSION[$account]->stud_key;
                    $currentUser = $_SESSION[$account]->stud_adm;
                } else {
                    $userKey = $_SESSION[$account]->user_key;
                    $currentUser = $_SESSION[$account]->user_name;
                }
                create_log([time(), APPINFO->sch_token, $account, $userKey, $currentUser, "logged out successfully"]);
                unset($_SESSION[$account]);
            }
            redirect($account);
        }
    }
}
