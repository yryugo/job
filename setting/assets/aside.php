<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">メニュー</li>
      <li>
        <a href="<?php echo h(SITE_URL); ?>">
          <i class="fa fa-dashboard"></i> <span>トップページ</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-address-book"></i> <span>媒体</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href="#"><i class="fa fa-circle-o"></i>媒体一覧</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i>媒体登録</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-building-o"></i> <span>企業</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href="#"><i class="fa fa-circle-o"></i>企業一覧</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i>企業登録</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>求人</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href="#"><i class="fa fa-circle-o"></i>求人一覧</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i>求人登録</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-bell"></i> <span>応募</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href="#"><i class="fa fa-circle-o"></i>応募一覧</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i>求人応募</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>ユーザー管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href="#"><i class="fa fa-circle-o"></i>ユーザー一覧</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i>ユーザー登録</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cog"></i> <span>各種設定</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            <small class="label pull-right bg-red">new</small>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href="<?php echo h(SITE_URL . 'logout/'); ?>"><i class="fa fa-circle-o"></i>ログアウト</a></li>
        </ul>
      </li>
    </ul>
  </section>
</aside>
