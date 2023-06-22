<?php

require 'vendor/autoload.php';
include_once 'config/config.php';

use Aws\S3\S3Client;

class serviceGetFileBucket
{
    private $region;
    private $version;
    private $accessKey;
    private $secretKey;
    private $bucketName;

    public function __CONSTRUCT()
    {
        // ? Setting information from configuration
        $this->region = AWS_CONFIG["REGION"];
        $this->version = AWS_CONFIG["VERSION"];
        $this->accessKey = AWS_CONFIG["ACCESS_KEY"];
        $this->secretKey = AWS_CONFIG["SECRET_KEY"];
        $this->bucketName = AWS_CONFIG["BUCKET_NAME"];
    }

    // ? Read the file
    public function readFileBucket($file_url = "")
    {
        $row = 1;
        $headers_file = array();
        $data_file = [];
        if (($handle = fopen($file_url, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                if ($row == 1) {
                    $headers_file[] = $data;
                } else {
                    $data_file[] = $data;
                }
                $row++;
            }
            fclose($handle);
        }
        return [
            "headers" => $headers_file,
            "data" => $data_file
        ];
    }

    // ? Get the Object from the bucket
    public function getFileBucket()
    {

        $s3 = new S3Client(
            [
                'version' => $this->version,
                'region' => $this->region,
                'credentials' => [
                    'key' => $this->accessKey,
                    'secret' => $this->secretKey,
                ]
            ]
        );

        try {
            // ? Listing all objects in the bucket
            $buckets = $s3->listObjectsV2([
                'Bucket' => $this->bucketName,
                'MaxKeys' => 1,
            ]);

            $data = [];
            if (count($buckets["Contents"]) >= 1) {
                $Key = "";
                $date = "";
                $Size = "";
                foreach ($buckets["Contents"] as $key_object => $value_object) {
                    // ? Data from object
                    $Key = $value_object["Key"];
                    $date = $value_object["LastModified"]->getTimestamp();
                    $date_formatted = date('Y-m-d H:i:s', $date);
                    $Size = $value_object["Size"];

                    // ? Setting data to save file
                    $array_name = explode(".", $Key);
                    $folder = "documents";
                    $new_name = str_replace([" ", ":"], ["_", "-"], $date_formatted) . "." . $array_name[count($array_name) - 1];
                    $full_path = "$folder/$new_name";
                    $object_data = $s3->getObject([
                        'Bucket' => $this->bucketName,
                        'Key' => $Key,
                        'SaveAs' => $full_path
                    ]);
                    $status = true;
                    $data[] = [
                        "size" => $Size,
                        "datetime_received" => $date_formatted,
                        "status" => $status,
                        "file_data" => $this->readFileBucket($full_path),
                        "message" => "DATA_RECEIVED",
                        "Key" => "$Key",
                    ];
                }
            } else {
                // ? In case of non object in bucket
                $status = false;
                $data[] = [
                    "size" => "",
                    "datetime_received" => "",
                    "status" => $status,
                    "file_data" => [],
                    "message" => "NO_OBJECTS"
                ];
            }
            return $data;
        } catch (\Throwable $th) {
            // ? In case of fail while processing data
            $status = false;
            $data[] = [
                "size" => "0",
                "datetime_received" => "",
                "status" => $status,
                "file_data" => [],
                "message" => "ERROR_PROCESSING"
            ];
        }
    }

    // ? Delete Object from bucket 
    public function deleteFileBucket($key = "")
    {

        $s3 = new S3Client(
            [
                'version' => $this->version,
                'region' => $this->region,
                'credentials' => [
                    'key' => $this->accessKey,
                    'secret' => $this->secretKey,
                ]
            ]
        );

        try {
            $result = $s3->deleteObject([
                'Bucket' => $this->bucketName,
                'Key'    => $key
            ]);    
            
            return $result["@metadata"]["statusCode"] == "200" || $result["@metadata"]["statusCode"] == "204" ? true : false;
        } catch (\Throwable $th) {
            // ? In case of fail while processing data
            return false;
        }
    }
}
