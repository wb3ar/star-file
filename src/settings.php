<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__.'/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__.'/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'doctrine' => [
          'meta' => [
            'entity_path' => array(__DIR__.'/../app/src/Entity'),
            'isDevMode' => false,
          ],
          'connection' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'star_file',
            'user' => 'root',
            'password' => '',
            'charset' => 'utf8',
          ],
        ],
        'sphinx' => [
          'host' => 'localhost',
          'port' => 9312,
        ],
        'ffmpeg' => [
          'ffmpeg.binaries' => __DIR__.'/../libs/ffmpeg/bin/ffmpeg.exe',
          'ffprobe.binaries' => __DIR__.'/../libs/ffmpeg/bin/ffprobe.exe',
        ],
      ],
];
