<?php

return [
    'enabled' => env('GOOGLE_TAG_MANAGER_ENABLED', env('APP_ENV') === 'production'),

    'id' => env('GOOGLE_TAG_MANAGER_ID'),

    'sessionKey' => env('GOOGLE_TAG_MANAGER_SESSION_KEY', '_googleTagManager'),

    'viewKey' => env('GOOGLE_TAG_MANAGER_VIEW_KEY', 'googletagmanager'),

    'macros' => env('GOOGLE_TAG_MANAGER_MACRO_PATH'),
];
