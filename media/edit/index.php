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

  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    setToken();
  } else {
    checkToken();

    $error = array();

    $mediaKana = $_POST['mediaKana'];
    $mediaName = $_POST['mediaName'];
    $mediaURL = $_POST['mediaURL'];
    $mediaLogo = $_POST['mediaLogo'];

    if ($mediaKana == '') {
      $error['mediaKana'] = '媒体のカナを入力してください。';
    } elseif ($mediaName == '') {
      $error['mediaName'] = '媒体名を入力してください。';
    }

    if (empty($error)) {
      $sql = "UPDATE media SET
              mediaKana = :mediaKana,
              mediaName = :mediaName,
              mediaURL = :mediaURL,
              mediaLogo = :mediaLogo,
              modified = now(),
              modifiedStaff = :modifiedStaff
              WHERE
              id = :id";
      $stmt = $dbh->prepare($sql);
      $params = array(
        ":mediaKana" => $mediaKana,
        ":mediaName" => $mediaName,
        ":mediaURL" => $mediaURL,
        ":mediaLogo" => $mediaLogo,
        ":modifiedStaff" => $me['id'],
        ":id" => $id
      );
      $stmt->execute($params);
      header('Location: ' . SITE_URL . 'media/');
      exit;
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>求人管理システム | 媒体編集（<?php echo h($medias['mediaName']); ?>）</title>

    <?php require_once('../../setting/assets/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
      <?php require_once('../../setting/assets/header.php'); ?>

      <?php require_once('../../setting/assets/aside.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>媒体編集（<?php echo h($medias['mediaName']); ?>）</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo h(SITE_URL); ?>"><i class="fa fa-dashboard"></i> トップページ</a></li>
            <li><a href="<?php echo h(SITE_URL . 'media/'); ?>"><i class="fa fa-address-book"></i> 媒体</a></li>
            <li class="active"><a href="<?php echo h(SITE_URL . 'media/edit/?id=' . $id); ?>"><i class="fa fa-address-book"></i> 媒体編集（<?php echo h($medias['mediaName']); ?>）</a></li>
          </ol>
        </section>

        <section class="content">

          <?php if(!empty($error['mediaKana'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['mediaKana']); ?>
            </div>
          <?php elseif(!empty($error['mediaName'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['mediaName']); ?>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">媒体基本情報</h3>
              </div>
              <form action="" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label>媒体カナ</label>
                    <input type="text" name="mediaKana" placeholder="媒体カナ" class="form-control" value="<?php echo h($medias['mediaKana']); ?>">
                  </div>
                  <div class="form-group">
                    <label>媒体名</label>
                    <input type="text" name="mediaName" placeholder="媒体名" class="form-control" value="<?php echo h($medias['mediaName']); ?>">
                  </div>
                  <div class="form-group">
                    <label>媒体URL</label>
                    <input type="text" name="mediaURL" placeholder="媒体URL" class="form-control" value="<?php echo h($medias['mediaURL']); ?>">
                  </div>
                  <div class="form-group">
                    <label>媒体ロゴ</label>
                    <input type="text" name="mediaLogo" placeholder="媒体ロゴ" class="form-control" value="<?php echo h($medias['mediaLogo']); ?>">
                  </div>
                </div>
                <div class="box-footer">
                  <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                  <button type="submit" class="btn btn-primary">更新</button>
                </div>
              </form>
            </div>
          </div>
          <a href="<?php echo h(SITE_URL . 'media/'); ?>" class="btn btn-default"><i class="fa fa-undo"></i> 戻る</a>
          <a href="<?php echo h(SITE_URL . 'media/delete/?id=' . $_GET['id']); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> 削除</a>

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
