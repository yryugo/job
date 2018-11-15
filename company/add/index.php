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

    $companyKana = $_POST['companyKana'];
    $companyName = $_POST['companyName'];
    $companyURL = $_POST['companyURL'];
    $companyLogo = $_POST['companyLogo'];
    $zip21 = $_POST['zip21'];
    $zip22 = $_POST['zip22'];
    $pref21 = $_POST['pref21'];
    $addr21 = $_POST['addr21'];
    $strt21 = $_POST['strt21'];
    $address = $_POST['address'];
    $buildingName = $_POST['buildingName'];
    $roomNumber = $_POST['roomNumber'];
    $Department = $_POST['Department'];
    $PositionInCharge = $_POST['PositionInCharge'];
    $ResponsibleFirstName = $_POST['ResponsibleFirstName'];
    $ResponsibleLastName = $_POST['ResponsibleLastName'];
    $tell1 = $_POST['tell1'];
    $tell2 = $_POST['tell2'];
    $tell3 = $_POST['tell3'];
    $fax1 = $_POST['fax1'];
    $fax2 = $_POST['fax2'];
    $fax3 = $_POST['fax3'];
    $EstablishmentYear = $_POST['EstablishmentYear'];
    $EstablishmentMonth = $_POST['EstablishmentMonth'];
    $Capital = $_POST['Capital'];
    $Employees = $_POST['Employees'];
    $AmountOfSales = $_POST['AmountOfSales'];
    $BusinessContents = $_POST['BusinessContents'];

    if ($companyKana == '') {
      $error['companyKana'] = 'フリガナを入力してください。';
    } elseif ($companyName == '') {
      $error['companyName'] = '企業名を入力してください。';
    } elseif ($zip21 == '' || $zip22 == '') {
      $error['zip'] = '郵便番号を入力してください。';
    } elseif ($pref21 == '') {
      $error['pref21'] = '都道府県を入力してください。';
    } elseif ($addr21 == '') {
      $error['addr21'] = '市区町村を入力してください。';
    } elseif ($strt21 == '') {
      $error['strt21'] = '町域を入力してください。';
    }

    if (empty($error)) {
      $sql = "INSERT INTO company
              (companyKana, companyName, companyURL, companyLogo, zip21, zip22, pref21, addr21, strt21, address, buildingName, roomNumber, Department, PositionInCharge, ResponsibleFirstName, ResponsibleLastName, tell1, tell2, tell3, fax1, fax2, fax3, EstablishmentYear, EstablishmentMonth, Capital, Employees, AmountOfSales, BusinessContents, created, createdStaff, modified, modifiedStaff)
              VALUES
              (:companyKana, :companyName, :companyURL, :companyLogo, :zip21, :zip22, :pref21, :addr21, :strt21, :address, :buildingName, :roomNumber, :Department, :PositionInCharge, :ResponsibleFirstName, :ResponsibleLastName, :tell1, :tell2, :tell3, :fax1, :fax2, :fax3, :EstablishmentYear, :EstablishmentMonth, :Capital, :Employees, :AmountOfSales, :BusinessContents, now(), :createdStaff, now(), :modifiedStaff)";
      $stmt = $dbh->prepare($sql);
      $params = array(
        ":companyKana" => $companyKana,
        ":companyName" => $companyName,
        ":companyURL" => $companyURL,
        ":companyLogo" => $companyLogo,
        ":zip21" => $zip21,
        ":zip22" => $zip22,
        ":pref21" => $pref21,
        ":addr21" => $addr21,
        ":strt21" => $strt21,
        ":address" => $address,
        ":buildingName" => $buildingName,
        ":roomNumber" => $roomNumber,
        ":Department" => $Department,
        ":PositionInCharge" => $PositionInCharge,
        ":ResponsibleFirstName" => $ResponsibleFirstName,
        ":ResponsibleLastName" => $ResponsibleLastName,
        ":tell1" => $tell1,
        ":tell2" => $tell2,
        ":tell3" => $tell3,
        ":fax1" => $fax1,
        ":fax2" => $fax2,
        ":fax3" => $fax3,
        ":EstablishmentYear" => $EstablishmentYear,
        ":EstablishmentMonth" => $EstablishmentMonth,
        ":Capital" => $Capital,
        ":Employees" => $Employees,
        ":AmountOfSales" => $AmountOfSales,
        ":BusinessContents" => $BusinessContents,
        ":createdStaff" => $me['id'],
        ":modifiedStaff" => $me['id']
      );
      $stmt->execute($params);
      header('Location: ' . SITE_URL . 'company/');
      exit;
    }
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>求人管理システム | 企業登録</title>

    <?php require_once('../../setting/assets/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
      <?php require_once('../../setting/assets/header.php'); ?>

      <?php require_once('../../setting/assets/aside.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>企業登録</h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo h(SITE_URL); ?>"><i class="fa fa-dashboard"></i> トップページ</a></li>
            <li><a href="<?php echo h(SITE_URL . 'company/'); ?>"><i class="fa fa-building"></i> 企業</a></li>
            <li class="active"><a href="<?php echo h(SITE_URL . 'company/add/'); ?>"><i class="fa fa-building"></i> 媒体登録</a></li>
          </ol>
        </section>

        <section class="content">

          <?php if(!empty($error['companyKana'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['companyKana']); ?>
            </div>
          <?php elseif(!empty($error['companyName'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['companyName']); ?>
            </div>
          <?php elseif(!empty($error['zip'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['zip']); ?>
            </div>
          <?php elseif(!empty($error['pref21'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['pref21']); ?>
            </div>
          <?php elseif(!empty($error['addr21'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['addr21']); ?>
            </div>
          <?php elseif(!empty($error['strt21'])) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
              <?php echo h($error['strt21']); ?>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">企業基本情報</h3>
              </div>
              <form action="" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label>フリガナ</label>
                    <input type="text" name="companyKana" placeholder="フリガナ" class="form-control" value="<?php echo h($companyKana); ?>">
                  </div>
                  <div class="form-group">
                    <label>企業名</label>
                    <input type="text" name="companyName" placeholder="企業名" class="form-control" value="<?php echo h($companyName); ?>">
                  </div>
                  <div class="form-group">
                    <label>URL</label>
                    <input type="text" name="companyURL" placeholder="URL" class="form-control" value="<?php echo h($companyURL); ?>">
                  </div>
                  <div class="form-group">
                    <label>企業ロゴ</label>
                    <input type="text" name="companyLogo" placeholder="企業ロゴ" class="form-control" value="<?php echo h($companyLogo); ?>">
                  </div>
                  <div class="form-group">
                    <label>郵便番号</label>
                    <div class="row">
                      <div class="col-xs-6"><input type="text" name="zip21" placeholder="郵便番号1" class="form-control" value="<?php echo h($zip21); ?>"></div>
                      <div class="col-xs-6"><input type="text" name="zip22" placeholder="郵便番号2" class="form-control" value="<?php echo h($zip22); ?>" onKeyUp="AjaxZip3.zip2addr('zip21','zip22','pref21','addr21','strt21');"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>都道府県</label>
                    <input type="text" name="pref21" placeholder="都道府県" class="form-control" value="<?php echo h($pref21); ?>">
                  </div>
                  <div class="form-group">
                    <label>市区町村</label>
                    <input type="text" name="addr21" placeholder="市区町村" class="form-control" value="<?php echo h($addr21); ?>">
                  </div>
                  <div class="form-group">
                    <label>町域</label>
                    <input type="text" name="strt21" placeholder="町域" class="form-control" value="<?php echo h($strt21); ?>">
                  </div>
                  <div class="form-group">
                    <label>番地</label>
                    <input type="text" name="address" placeholder="番地" class="form-control" value="<?php echo h($address); ?>">
                  </div>
                  <div class="form-group">
                    <label>建物名</label>
                    <input type="text" name="buildingName" placeholder="建物名" class="form-control" value="<?php echo h($buildingName); ?>">
                  </div>
                  <div class="form-group">
                    <label>部屋番号</label>
                    <input type="text" name="roomNumber" placeholder="部屋番号" class="form-control" value="<?php echo h($roomNumber); ?>">
                  </div>
                  <div class="form-group">
                    <label>担当部署</label>
                    <input type="text" name="Department" placeholder="担当部署" class="form-control" value="<?php echo h($Department); ?>">
                  </div>
                  <div class="form-group">
                    <label>担当役職</label>
                    <input type="text" name="PositionInCharge" placeholder="担当役職" class="form-control" value="<?php echo h($PositionInCharge); ?>">
                  </div>
                  <div class="form-group">
                    <label>担当者</label>
                    <div class="row">
                      <div class="col-xs-6"><input type="text" name="ResponsibleFirstName" placeholder="担当者氏" class="form-control" value="<?php echo h($ResponsibleFirstName); ?>"></div>
                      <div class="col-xs-6"><input type="text" name="ResponsibleLastName" placeholder="担当者名" class="form-control" value="<?php echo h($ResponsibleLastName); ?>"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>電話番号</label>
                    <div class="row">
                      <div class="col-xs-3"><input type="text" name="tell1" placeholder="電話番号1" class="form-control" value="<?php echo h($tell1); ?>"></div>
                      <div class="col-xs-3"><input type="text" name="tell2" placeholder="電話番号2" class="form-control" value="<?php echo h($tell2); ?>"></div>
                      <div class="col-xs-3"><input type="text" name="tell3" placeholder="電話番号3" class="form-control" value="<?php echo h($tell3); ?>"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>FAX</label>
                    <div class="row">
                      <div class="col-xs-3"><input type="text" name="fax1" placeholder="FAX1" class="form-control" value="<?php echo h($fax1); ?>"></div>
                      <div class="col-xs-3"><input type="text" name="fax2" placeholder="FAX2" class="form-control" value="<?php echo h($fax2); ?>"></div>
                      <div class="col-xs-3"><input type="text" name="fax3" placeholder="FAX3" class="form-control" value="<?php echo h($fax3); ?>"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>設立</label>
                    <div class="row">
                      <div class="col-xs-6"><input type="text" name="EstablishmentYear" placeholder="設立年" class="form-control" value="<?php echo h($EstablishmentYear); ?>"></div>
                      <div class="col-xs-6"><input type="text" name="EstablishmentMonth" placeholder="設立月" class="form-control" value="<?php echo h($EstablishmentMonth); ?>"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>資本金</label>
                    <input type="text" name="Capital" placeholder="資本金" class="form-control" value="<?php echo h($Capital); ?>">
                  </div>
                  <div class="form-group">
                    <label>従業員数</label>
                    <input type="text" name="Employees" placeholder="従業員数" class="form-control" value="<?php echo h($Employees); ?>">
                  </div>
                  <div class="form-group">
                    <label>売上高</label>
                    <input type="text" name="AmountOfSales" placeholder="売上高" class="form-control" value="<?php echo h($AmountOfSales); ?>">
                  </div>
                  <div class="form-group">
                    <label>事業内容</label>
                    <textarea name="BusinessContents" class="form-control"><?php echo h($BusinessContents); ?></textarea>
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
