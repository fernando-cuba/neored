<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'config/config.php';
include_once 'services/serviceGetFileBucket.php';
include_once 'services/serviceSendNotification.php';
include_once 'controllers/controllerProcessFileBucket.php';

// ? Get and read object from bucket
$serviceGetFileBucket = new serviceGetFileBucket();

// ? Return data for multiple objects if exists
$resultGetBucket = $serviceGetFileBucket->getFileBucket();
if (isset($resultGetBucket) && !empty($resultGetBucket) && count($resultGetBucket) > 0) {
    foreach ($resultGetBucket as $key_resultBucket => $value_resultBucket) {
        $Size = $value_resultBucket["size"] ?? "0.0";
        $date_formatted = $value_resultBucket["datetime_received"];
        $status_file_bucket = $value_resultBucket["status"];
        $Key = $value_resultBucket["Key"];

        // ? If the file was successfully processed
        if ($status_file_bucket == true) {

            // ? Select controller
            $controller = 'controllerLogFileBucket';
            $controller = new $controller;

            // ? Setting parameters
            $data = [
                "size" => $Size,
                "datetime_received" => $date_formatted,
                "state" => $status_file_bucket,
            ];

            // ? Getting the insert result
            $status_log_saved = $controller->Register($data);

            if ($status_log_saved) {
                // ? Deleting object from bucket
                $status_delete_file = $serviceGetFileBucket->deleteFileBucket($Key);

                // ? Validating the delete result
                if ($status_delete_file) {
                    // ? Get emails from config
                    foreach (NEO_RED_CONFIG["NOTIFICATION_EMAIL_ACCOUNTS"] as $key_data_accounts => $value_data_accounts) {
                        $FirstName = $value_data_accounts["FirstName"];
                        $EmailAddress = $value_data_accounts["EmailAddress"];
                        $message = "archivo procesado con éxito";

                        // ? We send email notification to the accounts in the config file
                        $serviceSendNotification = new ServiceSendNotification($EmailAddress, $FirstName, $message);
                        $status_sendNotifications = $serviceSendNotification->sendNotificationNeoRed();
                        if ($status_sendNotifications == "success") {
                            echo json_encode(["status" => true, "message" => "EMAIL_SEND"]);
                        } else {
                            echo json_encode(["status" => false, "message" => "ERROR_EMAIL_SEND"]);
                        }
                    }
                } else {
                    echo json_encode(["status" => true, "message" => "ERROR_DELETING_FILE"]);
                }
            } else {
                echo json_encode(["status" => true, "message" => "ERROR_LOG_SAVE"]);
            }
        } else {
            // ? Get emails from config
            foreach (NEO_RED_CONFIG["NOTIFICATION_EMAIL_ACCOUNTS"] as $key_data_accounts => $value_data_accounts) {
                $FirstName = $value_data_accounts["FirstName"];
                $EmailAddress = $value_data_accounts["EmailAddress"];
                $message = "error en la transacción";
                $serviceSendNotification = new ServiceSendNotification($EmailAddress, $FirstName, $message);
                $status_sendNotifications = $serviceSendNotification->sendNotificationNeoRed();
                if ($status_sendNotifications == "success") {
                    echo json_encode(["status" => true, "message" => "ERROR_PROCESSING_BUCKET__EMAIL_SEND"]);
                } else {
                    echo json_encode(["status" => false, "message" => "ERROR_PROCESSING_BUCKET__ERROR_EMAIL_SEND"]);
                }
            }
        }
    }
} else {
    echo json_encode(["status" => true, "message" => "NO_FILE_AVAILABLE"]);
}
sleep(TIME_TO_EXEC_PROCESS_IN_SECONDS);
header("Location: ".$_SERVER['PHP_SELF']);
