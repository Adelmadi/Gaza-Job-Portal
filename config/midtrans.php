<?php

return [
    'mercant_id' => config('webdeveloper.midtrans_merchat_id'),
    'client_key' => config('webdeveloper.midtrans_client_key'),
    'server_key' => config('webdeveloper.midtrans_server_key'),

    'is_production' => config('webdeveloper.midtrans_live_mode', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];
