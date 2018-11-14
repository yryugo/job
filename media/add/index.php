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

  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    setToken();
  } else {
    checkToken();

    $dbh = connectDb();

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
      $sql = "INSERT INTO media
              (mediaKana, mediaName, mediaURL, mediaLogo, created, createdStaff, modified, modifiedStaff)
              VALUES
              (:mediaKana, :mediaName, :mediaURL, :mediaLogo, now(), :createdStaff, now(), :modifiedStaff)";
      $stmt = $dbh->prepare($sql);
      $params = array(
        ':mediaKana' => $mediaKana,
        ':mediaName' => $mediaName,
        ':mediaURL' => $mediaURL,
        ':mediaLogo' => $mediaLogo,
        ':createdStaff' => $me['id'],
        ':modifiedStaff' => $me['id']
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
    <title>求人管理システム | 媒体登録</title>

    <?php require_once('../../setting/assets/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
      <?php require_once('../../setting/assets/header.php'); ?>

      <?php require_once('../../setting/assets/aside.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>媒体登録</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo h(SITE_URL); ?>"><i class="fa fa-dashboard"></i> トップページ</a></li>
            <li><a href="<?php echo h(SITE_URL . 'media/'); ?>"><i class="fa fa-address-book"></i> 媒体</a></li>
            <li class="active"><a href="<?php echo h(SITE_URL . 'media/'); ?>"><i class="fa fa-address-book"></i> 媒体登録</a></li>
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
                    <input type="text" name="mediaKana" placeholder="媒体カナ" class="form-control" value="<?php echo h($mediaKana); ?>">
                  </div>
                  <div class="form-group">
                    <input type="text" name="mediaName" placeholder="媒体名" class="form-control" value="<?php echo h($mediaName); ?>">
                  </div>
                  <div class="form-group">
                    <input type="text" name="mediaURL" placeholder="媒体URL" class="form-control" value="<?php echo h($mediaURL); ?>">
                  </div>
                  <div class="form-group">
                    <input type="text" name="mediaLogo" placeholder="媒体ロゴ" class="form-control" value="<?php echo h($mediaLogo); ?>">
                  </div>
                </div>
                <div class="box-footer">
                  <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                  <button type="submit" class="btn btn-primary">登録</button>
                </div>
              </form>
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
