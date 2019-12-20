<?php

return [

/*
|--------------------------------------------------------------------------
| Laravel CORS
|--------------------------------------------------------------------------
|
| allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
| to accept any value.
|
*/

'supportsCredentials' => false,
'allowedOrigins' => ['*'],// ex: ['abc.com', 'api.abc.com']
'allowedHeaders' => ['*'],
// 'allowedHeaders' => ['Content-Type', 'X-Requested-With'], //ECR
'allowedMethods' => ['*'],// ex: ['GET', 'POST', 'PUT', 'DELETE']
'exposedHeaders' => [],
'maxAge' => 0,

];