<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=crossover',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => "email-smtp.us-east-1.amazonaws.com",
                'username' => "AKIAJE5KXHKROVZ3MNXA",
                'password' => "ApcqJmhvrXIlw2q0czzqZxky4lU6VY3G2oCEh+p2qbsv",
                'port' => "587",
                'encryption' => "tls",
            ],
        ],
        'Globals' => [
            'class' => 'common\components\Globals'
        ],
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
];
