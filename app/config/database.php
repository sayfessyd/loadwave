<?php

$base = getenv('CLEARDB_DATABASE_NAME');
$server = getenv('CLEARDB_DATABASE_SERVER');
$user = getenv('CLEARDB_DATABASE_USER');
$pass = getenv('CLEARDB_DATABASE_PASS');

define('BASE', $base);
define('SERVER', $server);
define('USER', $user);
define('PASS', $pass);