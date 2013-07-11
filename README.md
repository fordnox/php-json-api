[![Build Status](https://secure.travis-ci.org/fordnox/php-json-api.png?branch=master)](http://travis-ci.org/fordnox/php-json-api)

php-json-api
==============

Most simple JSON API builder class for PHP. One file only.
Accepting a JSON request body and returning JSON as a result.

Example Server
==============

    <?php
    require __DIR__ . '/../vendor/autoload.php';

    $server = new Fordnox\JsonApiServer();
    $server->register('ping', function($params){
        return $params;
    });
    $server->handle();


Example Invoke
==============

    curl http://api.com -d '{"method":"ping","params":"pong!"}'

    {"result":"pong!", "error":null}