<?php

trait Controller
{

    public function view($name, $data = [], $fileView = "")
    {
        if (in_array(BILLCHECK['type'], array("", "free"))) {
            $sno = 1;
            $appData = new App;
            if (!empty($data))
                extract($data);

            if (in_array(VIEWFOLDER, PORTALKEYS)) {
                if (strtolower($name) == "printtemp") {
                    $temp = tempLoad("print_temp");
                    $originalFileName = "";
                } else {
                    /**Portal */
                    $temp = tempLoad("p_temp");
                    $originalFileName = LIB_PATH . "app/views/portals/" . VIEWFOLDER . "/" . strtolower($name) . ".view.php";
                }
            } else {
                /**other pages */
                if (isMobile()) {
                    $temp = tempLoad("m_temp");
                } else {
                    $temp = tempLoad("d_temp");
                }
                $originalFileName = LIB_PATH . "app/views/" . strtolower($name) . ".view.php";
            }

            if (file_exists($temp)) {
                if (file_exists($originalFileName)) {
                    $fileName = $originalFileName;
                } else {
                    $fileName = LIB_PATH . "app/views/404.view.php";
                }
                require $temp;
            } else {
                echo errorTemp([
                    "title" => "template loading error",
                    "body" => "error loading the system template"
                ]);
            }
        } else {
            echo errorTemp([
                "title" => BILLCHECK['type'],
                "body" => BILLCHECK['message'] . "<br>Having issues or complains with this error? Contact: <u>" . smartPhone("0796594366") . "</u>"
            ]);
        }
    }
}
