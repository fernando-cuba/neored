<?php

include_once 'models/modelLogFileBucket.php';
include_once 'database/database.php';

class controllerLogFileBucket
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new modelLogFileBucket();
    }

    public function Register($data = [])
    {
        $data = $this->model->Register($data);
        return $data;
    }
}
