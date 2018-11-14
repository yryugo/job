<?php

require_once('../setting/config.php');
require_once('../setting/functions.php');

session_start();

session_destroy();

header('Location: ' . SITE_URL);
exit;
