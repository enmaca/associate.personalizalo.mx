<?php

return [
    'debug' => env('UXMAL_DEBUG', false),
    'ide' => env('UXMAL_IDE', 'phpstorm'),

    'ide_formats' => [
        'phpstorm' => 'phpstorm://open?file=%s&line=%d',
        'vscode' => 'vscode://file%s:%d',
    ]
];