<?php

define('DSN', 'mysql:host=localhost;dbname=job');
define('DB_USER', 'support');
define('DB_PASSWORD', 'p@ssw0rd');

define('PASSWORD_KEY', 'p@ssw0rd');

// URL判定
$url  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$domain = $_SERVER["HTTP_HOST"];

$host = $url . $domain;

if ($host == "http://localhost:8888") {
  // エラー出力
  ini_set('display_errors', "On");
  error_reporting(E_ALL & ~E_NOTICE);

  define('SITE_URL', 'http://localhost:8888/job/');
} elseif($host == "https://job.techrun.net") {
  define('SITE_URL', 'https://job.techrun.net/');
}
