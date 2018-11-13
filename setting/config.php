<?php

define('DSN', 'mysql:host=localhost;dbname=job');
define('DB_USER', 'support');
define('DB_PASSWORD', 'p@ssw0rd');

define('PASSWORD_KEY', 'p@ssw0rd');

// エラー出力
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
