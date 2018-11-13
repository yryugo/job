<?php

require_once('../setting/config.php');
require_once('../setting/functions.php');

session_start();

if (!empty($_SESSION['me'])) {
  header('Location: ' . SITE_URL);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  setToken();
} else {
  checkToken();

  // 変数の宣言
  $email = $_POST['email'];
  $password = $_POST['password'];

  $dbh = connectDb();

  $error = array();

  // エラーチェック
  if ($email == '') {
    $error['email'] = 'メールアドレスを入力してください。';
  } elseif ($password == '') {
    $error['password'] = 'パスワードを入力してください。';
  } elseif (!emailExists($email, $dbh)) {
    $error['email'] = 'このメールアドレスは登録されていません。';
  } elseif (!$me = getUser($email, $password, $dbh)) {
    $error['password'] = 'メールアドレスもしくは、パスワードが正しくありません。';
  }

  if (empty($error)) {
    // セッションハイジャック対策
    session_regenerate_id(true);
    $_SESSION['me'] = $me;
    header('Location: ' . SITE_URL);
    exit;
  }

}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>求人管理システム | ログイン</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- ▼▼ css ▼▼ -->

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo h(SITE_URL); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo h(SITE_URL); ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo h(SITE_URL); ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo h(SITE_URL); ?>dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo h(SITE_URL); ?>plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- ▲▲ css ▲▲ -->
  </head>
  <body class="hold-transition login-page">

    <?php if(!empty($error['email'])) : ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
        <?php echo h($error['email']); ?>
      </div>
    <?php elseif(!empty($error['password'])) : ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
        <?php echo h($error['password']); ?>
      </div>
    <?php elseif(!empty($error['token'])) : ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
        <?php echo h($error['token']); ?>
      </div>
    <?php endif; ?>


    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo h(SITE_URL); ?>"><b>求人管理</b>システム</a>
      </div>

      <div class="login-box-body">
        <p class="login-box-msg">必要事項を入力してログインしてください。</p>

        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="email" name="email" placeholder="メールアドレス" class="form-control" value="<?php echo h($email); ?>">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" placeholder="パスワード" class="form-control">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <dov class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> パスワードを保存する
                </label>
              </div>
            </div>
            <div class="col-xs-4">
              <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
              <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- ▼▼ javascript ▼▼ -->

    <!-- jQuery 3 -->
    <script src="<?php echo h(SITE_URL); ?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo h(SITE_URL); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo h(SITE_URL); ?>plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });
    </script>

    <!-- ▲▲ javascript ▲▲ -->

  </body>
</html>
