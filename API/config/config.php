<?php
// ? Defining time zone
date_default_timezone_set('America/Mazatlan');

// ? Definition of environment
define("ENVIRONMENT", "development");

// ? Setting to view errors while being in development mode
if (ENVIRONMENT == 'development') {
    // ? Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// ? Config por default
$data_config = [
    "DB" => [
        "HOST__DB" => "localhost",
        "USER__DB" => "root",
        "PASSWORD__DB" => "",
        "NAME__DB" => "",
        "CHARSET__DB" => "utf8"
    ],
    "AWS" => [
        "BUCKET_NAME" => "",
        "REGION" => "",
        "VERSION" => "",
        "ACCESS_KEY" => "",
        "SECRET_KEY" => "",
    ],
    "NEO_RED" => [
        "ACCOUNT" => "",
        "USER" => "",
        "PASSWORD" => "",
        "MAILING_ID" => "",
        "NOTIFICATION_EMAIL_ACCOUNTS" => [
            [
                "FirstName" => "",
                "LastName" => "",
                "EmailAddress" => "prueba@example.com",
            ]
        ]
    ],
    "NAME_PROJECT" => "importacion_automatica",
    "URL_PROJECT" => "localhost",
    "TIME_TO_EXEC_PROCESS_IN_SECONDS" => 5
];

// ? Environment selection
switch (ENVIRONMENT) {
    case 'development':
        $data_config = [
            "DB" => [
                "HOST__DB" => "localhost",
                "USER__DB" => "root",
                "PASSWORD__DB" => "",
                "NAME__DB" => "importacion_automatica__big_query",
                "CHARSET__DB" => "utf8"
            ],
            "AWS" => [
                "BUCKET_NAME" => "importacion-automatica",
                "REGION" => "",
                "VERSION" => "",
                "ACCESS_KEY" => "",
                "SECRET_KEY" => "",
            ],
            "NEO_RED" => [
                "ACCOUNT" => "",
                "USER" => "",
                "PASSWORD" => "",
                "MAILING_ID" => "",
                "NOTIFICATION_EMAIL_ACCOUNTS" => [
                    [
                        "FirstName" => "",
                        "LastName" => "",
                        "EmailAddress" => "prueba@example.com",
                    ]
                ]
            ],
            "NAME_PROJECT" => "importacion_automatica",
            "URL_PROJECT" => "localhost",
            "TIME_TO_EXEC_PROCESS_IN_SECONDS" => 5
        ];
        break;
    case 'testing':
        $data_config = [
            "DB" => [
                "HOST__DB" => "",
                "USER__DB" => "root",
                "PASSWORD__DB" => "",
                "NAME__DB" => "importacion_automatica__big_query",
                "CHARSET__DB" => "utf8"
            ],
            "AWS" => [
                "BUCKET_NAME" => "importacion-automatica",
                "REGION" => "",
                "VERSION" => "",
                "ACCESS_KEY" => "",
                "SECRET_KEY" => "",
            ],
            "NEO_RED" => [
                "ACCOUNT" => "",
                "USER" => "",
                "PASSWORD" => "",
                "MAILING_ID" => "",
                "NOTIFICATION_EMAIL_ACCOUNTS" => [
                    [
                        "FirstName" => "",
                        "LastName" => "",
                        "EmailAddress" => "prueba@",
                    ]
                ]
            ],
            "NAME_PROJECT" => "importacion_automatica",
            "URL_PROJECT" => "",
            "TIME_TO_EXEC_PROCESS_IN_SECONDS" => 5
        ];
        break;
    case 'deployment':
        $data_config = [
            "DB" => [
                "HOST__DB" => "",
                "USER__DB" => "root",
                "PASSWORD__DB" => "",
                "NAME__DB" => "importacion_automatica__big_query",
                "CHARSET__DB" => "utf8"
            ],
            "AWS" => [
                "BUCKET_NAME" => "",
                "REGION" => "",
                "VERSION" => "",
                "ACCESS_KEY" => "",
                "SECRET_KEY" => "",
            ],
            "NEO_RED" => [
                "ACCOUNT" => "",
                "USER" => "",
                "PASSWORD" => "",
                "MAILING_ID" => "",
                "NOTIFICATION_EMAIL_ACCOUNTS" => [
                    [
                        "FirstName" => "",
                        "LastName" => "",
                        "EmailAddress" => "prueba@example.com",
                    ]
                ]
            ],
            "NAME_PROJECT" => "importacion_automatica",
            "URL_PROJECT" => "",
            "TIME_TO_EXEC_PROCESS_IN_SECONDS" => 5
        ];
        break;
}

// ? Setting variables
define("DATABASE_CONFIG", $data_config["DB"]);
define("AWS_CONFIG", $data_config["AWS"]);
define("NEO_RED_CONFIG", $data_config["NEO_RED"]);
define("TIME_TO_EXEC_PROCESS_IN_SECONDS", $data_config["TIME_TO_EXEC_PROCESS_IN_SECONDS"]);
