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
    <title>求人管理システム | 企業一覧</title>

    <?php require_once('../setting/assets/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
      <?php require_once('../setting/assets/header.php'); ?>

      <?php require_once('../setting/assets/aside.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>企業一覧</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo h(SITE_URL); ?>"><i class="fa fa-dashboard"></i> トップページ</a></li>
            <li class="active"><a href="<?php echo h(SITE_URL . 'company/'); ?>"><i class="fa fa-building"></i> 企業</a></li>
          </ol>
        </section>

        <section class="content">

          <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">企業一覧</h3>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped">
                    <tr>
                      <th></th>
                      <th>企業名</th>
                      <th>登録</th>
                      <th>更新</th>
                      <th></th>
                    </tr>
                    <?php

                    $sql = "SELECT * FROM company LIMIT " . $offset . "," . PER_PAGE;
                    $companys = array();
                    foreach ($dbh->query($sql) as $row) {
                      array_push($companys, $row);
                    }
                    $total = $dbh->query("SELECT COUNT(*) FROM company")->fetchColumn();
                    $totalPages = ceil($total / PER_PAGE);

                    ?>
                    <?php foreach ($companys as $company) : ?>
                      <tr>
                        <td><a href="<?php echo h($company['companyURL']); ?>" target="_blank"><img src="<?php echo h($company['companyLogo']); ?>" height="50"></a></td>
                        <td><?php echo h($company['companyName']); ?></td>
                        <td>
                          <?php
                            $created = date('Y/m/d H:i', strtotime($company['created']));

                            $sql = "SELECT * FROM users WHERE id = :id";
                            $stmt = $dbh->prepare($sql);
                            $id = $company['createdStaff'];
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
                            $modified = date('Y/m/d H:i', strtotime($company['modified']));

                            $sql = "SELECT * FROM users WHERE id = :id";
                            $stmt = $dbh->prepare($sql);
                            $id = $company['modifiedStaff'];
                            $params = array(
                              ":id" => $id
                            );
                            $stmt->execute($params);
                            $modifiedStaff = $stmt->fetch();

                            echo h($modified . " " . $modifiedStaff['FirstName'] . $modifiedStaff['LastName']);
                          ?>
                        </td>
                        <td>
                          <a href="<?php echo h(SITE_URL . 'company/show/?id=' . $comapny['id']); ?>" class="btn btn-default"><i class="fa fa-search"></i></a>
                          <a href="<?php echo h(SITE_URL . 'company/edit/?id=' . $company['id']); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                          <a href="<?php echo h(SITE_URL . 'company/delete/?id=' . $company['id']); ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
                <?php for($i = 1; $i <= $totalPages; $i++) : ?>
                  <?php if ($page == $i) : ?>
                    <a href="<?php echo h(SITE_URL . 'company/?page=' . $i); ?>" class="btn btn-primary"><?php echo h($i); ?></a>
                  <?php else: ?>
                    <a href="<?php echo h(SITE_URL . 'company/?page=' . $i); ?>" class="btn btn-default"><?php echo h($i); ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </div>
            <a href="<?php echo h(SITE_URL . 'company/add'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> 登録</a>
          </div>
        </section>
      </div>

      <?php require_once('../setting/assets/footer.php'); ?>
    </div>

    <?php require_once('../setting/assets/scripts.php'); ?>
  </body>
</html>
