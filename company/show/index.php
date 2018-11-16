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

  $sql = "SELECT * FROM company WHERE id = $id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $companys = $stmt->fetch();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>求人管理システム | 企業詳細（<?php echo h($companys['companyName']); ?>）</title>

    <?php require_once('../../setting/assets/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
      <?php require_once('../../setting/assets/header.php'); ?>

      <?php require_once('../../setting/assets/aside.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>企業詳細（<?php echo h($companys['companyName']); ?>）</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo h(SITE_URL); ?>"><i class="fa fa-dashboard"></i> トップページ</a></li>
            <li><a href="<?php echo h(SITE_URL . 'company/'); ?>"><i class="fa fa-building"></i> 企業</a></li>
            <li class="active"><a href="<?php echo h(SITE_URL . 'company/show/?id=' . $id); ?>"><i class="fa fa-building"></i> 企業詳細（<?php echo h($companys['companyName']); ?>）</a></li>
          </ol>
        </section>

        <section class="content">

          <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">企業基本情報</h3>
              </div>
              <div class="box-body">
                <div align="center">
                  <img src="<?php echo h($companys['companyLogo']) ?>">
                </div>
                <dl>
                  <dt>フリガナ</dt>
                  <dd><?php echo h($companys['companyKana']); ?></dd>
                  <dt>企業名</dt>
                  <dd><?php echo h($companys['companyName']); ?></dd>
                  <dt>URL</dt>
                  <dd><a href="<?php echo h($companys['companyURL']); ?>" target="_blank"><?php echo h($companys['companyURL']); ?></a></dd>
                  <dt>住所</dt>
                  <dd><?php echo h('〒' . $companys['zip21'] . '-' . $companys['zip22'] . ' ' . $companys['pref21'] . $companys['addr21'] . $companys['strt21'] . $companys['address'] . ' ' . $companys['buildingName'] . $companys['roomNumber']); ?></dd>
                  <dt>担当部署</dt>
                  <dd><?php echo h($companys['Department']); ?></dd>
                  <dt>担当役職</dt>
                  <dd><?php echo h($companys['PositionInCharge']); ?></dd>
                  <dt>担当者氏名</dt>
                  <dd><?php echo h($companys['ResponsibleFirstName'] . ' ' . $companys['ResponsibleLastName']); ?></dd>
                  <dt>電話番号</dt>
                  <dd><?php echo h($companys['tell1'] . '-' . $companys['tell2'] . '-' . $companys['tell3']); ?></dd>
                  <dt>FAX</dt>
                  <dd><?php echo h($companys['fax1'] . '-' . $companys['fax2'] . '-' . $companys['fax3']); ?></dd>
                  <dt>設立</dt>
                  <dd><?php echo h($companys['EstablishmentYear'] . '年' . $companys['EstablishmentMonth'] . '月'); ?></dd>
                  <dt>資本金</dt>
                  <dd><?php echo h($companys['Capital']); ?></dd>
                  <dt>従業員数</dt>
                  <dd><?php echo h($companys['Employees']); ?></dd>
                  <dt>売上高</dt>
                  <dd><?php echo h($companys['AmountOfSales']); ?></dd>
                  <dt>事業内容</dt>
                  <dd><?php echo nl2br($companys['BusinessContents']); ?></dd>
                  <dt>登録</dt>
                  <dd>
                    <?php
                      $created = date('Y/m/d H:i', strtotime($companys['created']));

                      $sql = "SELECT * FROM users WHERE id = :id";
                      $stmt = $dbh->prepare($sql);
                      $id = $companys['createdStaff'];
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
                      $modified = date('Y/m/d H:i', strtotime($companys['modified']));

                      $sql = "SELECT * FROM users WHERE id = :id";
                      $stmt = $dbh->prepare($sql);
                      $id = $companys['modifiedStaff'];
                      $params = array(
                        ":id" => $id
                      );
                      $stmt->execute($params);
                      $modifiedStaff = $stmt->fetch();

                      echo h($modified . " " . $modifiedStaff['FirstName'] . $modifiedStaff['LastName']);
                    ?>
                  </dd>
                </dl>
                <a href="<?php echo h(SITE_URL . 'company/'); ?>" class="btn btn-default"><i class="fa fa-undo"></i> 戻る</a>
                <a href="<?php echo h(SITE_URL . 'company/edit/?id=' . $_GET['id']); ?>" class="btn btn-primary"><i class="fa fa-edit"></i> 編集</a>
                <a href="<?php echo h(SITE_URL . 'company/delete/?id=' . $_GET['id']); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> 削除</a>
              </div>
            </div>
          </div>
        </section>
      </div>

      <?php require_once('../../setting/assets/footer.php'); ?>
    </div>

    <?php require_once('../../setting/assets/scripts.php'); ?>
  </body>
</html>
