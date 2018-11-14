<?php

  require_once('../setting/config.php');
  require_once('../setting/functions.php');

  if (empty($_SESSION['me'])) {
    header('Location: ' . SITE_URL . 'login/');
    exit;
  }

  if ($me['admin'] != 2) {
    header('Location: ' . SITE_URL);
    exit;
  }

  $dbh = connectDb();

  if (preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
      $page = (int)$_GET['page'];
  } else {
      $page = 1;
  }
  define('PER_PAGE', 5);

  $offset = PER_PAGE * ($page - 1);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>求人管理システム | 媒体一覧</title>

    <?php require_once('../setting/assets/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
      <?php require_once('../setting/assets/header.php'); ?>

      <?php require_once('../setting/assets/aside.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>媒体一覧</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo h(SITE_URL); ?>"><i class="fa fa-dashboard"></i> トップページ</a></li>
            <li class="active"><a href="<?php echo h(SITE_URL . 'media/'); ?>"><i class="fa fa-address-book"></i> 媒体</a></li>
          </ol>
        </section>

        <section class="content">

          <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">媒体一覧</h3>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped">
                    <tr>
                      <th></th>
                      <th>媒体名</th>
                      <th>登録</th>
                      <th>更新</th>
                      <th></th>
                    </tr>
                    <?php

                    $sql = "SELECT * FROM media LIMIT " . $offset . "," . PER_PAGE;
                    $medias = array();
                    foreach ($dbh->query($sql) as $row) {
                      array_push($medias, $row);
                    }
                    $total = $dbh->query("SELECT COUNT(*) FROM media")->fetchColumn();
                    $totalPages = ceil($total / PER_PAGE);

                    ?>
                    <?php foreach ($medias as $media) : ?>
                      <tr>
                        <td><a href="<?php echo h($media['mediaURL']); ?>" target="_blank"><img src="<?php echo h($media['mediaLogo']); ?>" height="50"></a></td>
                        <td><?php echo h($media['mediaName']); ?></td>
                        <td>
                          <?php
                            $created = date('Y/m/d H:i', strtotime($media['created']));

                            $sql = "SELECT * FROM users WHERE id = :id";
                            $stmt = $dbh->prepare($sql);
                            $id = $media['createdStaff'];
                            $params = array(
                              ":id" => $id
                            );
                            $stmt->execute($params);
                            $createdStaff = $stmt->fetch();

                            echo h($created . " " . $createdStaff['FirstName'] . $createdStaff['LastName']);
                          ?>
                        </td>
                        <td>
                          <?php
                            $modified = date('Y/m/d H:i', strtotime($media['modified']));

                            $sql = "SELECT * FROM users WHERE id = :id";
                            $stmt = $dbh->prepare($sql);
                            $id = $media['modifiedStaff'];
                            $params = array(
                              ":id" => $id
                            );
                            $stmt->execute($params);
                            $modifiedStaff = $stmt->fetch();

                            echo h($modified . " " . $modifiedStaff['FirstName'] . $modifiedStaff['LastName']);
                          ?>
                        </td>
                        <td>
                          <a href="<?php echo h(SITE_URL . 'media/show/?id=' . $media['id']); ?>" class="btn btn-default"><i class="fa fa-search"></i></a>
                          <a href="<?php echo h(SITE_URL . 'media/edit/?id=' . $media['id']); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                          <a href="<?php echo h(SITE_URL . 'media/delete/?id=' . $media['id']); ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
                <?php for($i = 1; $i <= $totalPages; $i++) : ?>
                  <?php if ($page == $i) : ?>
                    <a href="<?php echo h(SITE_URL . 'media/?page=' . $i); ?>" class="btn btn-primary"><?php echo h($i); ?></a>
                  <?php else: ?>
                    <a href="<?php echo h(SITE_URL . 'media/?page=' . $i); ?>" class="btn btn-default"><?php echo h($i); ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </div>
            <a href="<?php echo h(SITE_URL . 'media/add'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> 登録</a>
          </div>
        </section>
      </div>

      <?php require_once('../setting/assets/footer.php'); ?>
    </div>

    <?php require_once('../setting/assets/scripts.php'); ?>
  </body>
</html>
