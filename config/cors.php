<?php
return [
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['http://localhost:51383'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
];