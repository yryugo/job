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

  $id = $_GET['id'];

  $dbh = connectDb();

  $sql = "SELECT * FROM media WHERE id = $id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $medias = $stmt->fetch();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>求人管理システム | 媒体詳細（<?php echo h($medias['mediaName']); ?>）</title>

    <?php require_once('../../setting/assets/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
      <?php require_once('../../setting/assets/header.php'); ?>

      <?php require_once('../../setting/assets/aside.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>媒体詳細（<?php echo h($medias['mediaName']); ?>）</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo h(SITE_URL); ?>"><i class="fa fa-dashboard"></i> トップページ</a></li>
            <li><a href="<?php echo h(SITE_URL . 'media/'); ?>"><i class="fa fa-address-book"></i> 媒体</a></li>
            <li class="active"><a href="<?php echo h(SITE_URL . 'media/show/?id=' . $id); ?>"><i class="fa fa-address-book"></i> 媒体詳細（<?php echo h($medias['mediaName']); ?>）</a></li>
          </ol>
        </section>

        <section class="content">

          <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">媒体基本情報</h3>
              </div>
              <div class="box-body">
                <div align="center">
                  <img src="<?php echo h($medias['mediaLogo']) ?>">
                </div>
                <dl>
                  <dt>媒体カナ</dt>
                  <dd><?php echo h($medias['mediaKana']); ?></dd>
                  <dt>媒体名</dt>
                  <dd><?php echo h($medias['mediaName']); ?></dd>
                  <dt>媒体URL</dt>
                  <dd><a href="<?php echo h($medias['mediaURL']); ?>" target="_blank"><?php echo h($medias['mediaURL']); ?></a></dd>
                  <dt>登録</dt>
                  <dd>
                    <?php
                      $created = date('Y/m/d H:i', strtotime($medias['created']));

                      $sql = "SELECT * FROM users WHERE id = :id";
                      $stmt = $dbh->prepare($sql);
                      $id = $medias['createdStaff'];
                      $params = array(
                        ":id" => $id
                      );
                      $stmt->execute($params);
                      $createdStaff = $stmt->fetch();

                      echo h($created . " " . $createdStaff['FirstName'] . $createdStaff['LastName']);
                    ?>
                  </dd>
                  <dt>更新</dt>
                  <dd>
                    <?php
                      $modified = date('Y/m/d H:i', strtotime($medias['modified']));

                      $sql = "SELECT * FROM users WHERE id = :id";
                      $stmt = $dbh->prepare($sql);
                      $id = $medias['modifiedStaff'];
                      $params = array(
                        ":id" => $id
                      );
                      $stmt->execute($params);
                      $modifiedStaff = $stmt->fetch();

                      echo h($modified . " " . $modifiedStaff['FirstName'] . $modifiedStaff['LastName']);
                    ?>
                  </dd>
                </dl>
                <a href="<?php echo h(SITE_URL . 'media/'); ?>" class="btn btn-default"><i class="fa fa-undo"></i> 戻る</a>
                <a href="<?php echo h(SITE_URL . 'media/edit/?id=' . $_GET['id']); ?>" class="btn btn-primary"><i class="fa fa-edit"></i> 編集</a>
                <a href="<?php echo h(SITE_URL . 'media/delete/?id=' . $_GET['id']); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> 削除</a>
              </div>
            </div>
          </div>

          <div class="row">
            <section class="col-lg-7 connectedSortable">
            </section>

            <section class="col-lg-5 connectedSortable">
            </section>
          </div>
        </section>
      </div>

      <?php require_once('../../setting/assets/footer.php'); ?>
    </div>

    <?php require_once('../../setting/assets/scripts.php'); ?>
  </body>
</html>
