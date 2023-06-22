<?php
include_once 'config/config.php';
class modelLogFileBucket
{
    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Register($data = [])
    {
        try {
            $size__log = $data["size"] ?? "0.0";
            $datetime_received__log = $data["datetime_received"] ?? date("Y-m-d H:i:s");
            $datetime_processed__log = date("Y-m-d H:i:s");
            $state__log = $data["state"] ?? "FAILED";


            $sql = "INSERT INTO logs__upload_file (size__log, datetime_received__log, datetime_processed__log, state__log) VALUES (?, ?, ?, ?)";

            
            $status = $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $size__log,
                        $datetime_received__log,
                        $datetime_processed__log,
                        $state__log
                    )
                );
            return $status;
        } catch (Exception $e) {
            return false;
        }
    }
}
