<?php


trait Database
{
    private function connect()
    {
        try {
            $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
            $con = new PDO($string, DBUSER, DBPASS);
            return $con;
        } catch (Exception $e) {
            // throw $e;
            die(errorTemp(array("title" => "database connection problems", "body" => "Error encountered establishing secure connection with your database, kindly wait or refresh for connection establishment.<br>If the problem persist, kindly contact the system administrator to help.")));
        }
    }

    public function query($query, $data = [])
    {
        try {
            $con = $this->connect();
            $stm = $con->prepare($query);
            $check = $stm->execute($data);
            if ($check) {
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                if (is_array($result) && count($result)) {
                    return $result;
                }
            }
        } catch (\Throwable $th) {
            throw $th;
            // die(errorTemp(array("title" => "database connection problems", "body" => "Error encountered establishing secure connection with your database, kindly wait or refresh for connection establishment.<br>If the problem persist, kindly contact the system administrator to help.")));
        }

        return false;
    }
}
