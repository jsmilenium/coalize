<?php
return [
    'id' => 'api-app',
    'basePath' => dirname(__DIR__),
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
        ],
    ],
];
