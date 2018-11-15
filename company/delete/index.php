<?php

  require_once('../../setting/config.php');
  require_once('../../setting/functions.php');

  if (empty($_SESSION['me'])) {
    header('Location: ' . SITE_URL . 'login/');
    exit;
  }

  if ($me['admin'] != 2) {
    header('Location: ' . SITE_URL);
    exit;
  }
  $dbh = connectDb();
  $id = $_GET['id'];
  $sql = "DELETE FROM company WHERE id = $id";
  $stmt = $dbh->query($sql);

  header('Location: ' . SITE_URL . 'company/');
  exit;
