
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php if (isset($title)): echo $this->escape($title) . ' - ';
        endif; ?>Mini Blog</title>

    <link rel="stylesheet" type="text/css" media="screen" href="/study_localhost/mini-blog.localhost/application/views/style.css 
" />

</head>
  <header>
    <div id="header">
    <h1><a href="<?php echo $base_url;?>/">掲示板</a></h1>
    </div>
  <div id="id">
<p>
<!-- 認証されていたら。。 -->
<?php if($session->isAuthenticated()):?>
<a href="<?php echo $base_url; ?>/">ホーム</a>
<!-- // 修正箇所----------------------------------------------------------------------- -->
<a href="<?php echo $base_url; ?>/account"><?php echo 'アカウント('.$_SESSION['user']['user_name'].')';?></a>
<!-- // 修正箇所----------------------------------------------------------------------- -->
<a href="<?php echo $base_url; ?>/status/users">ユーザ一覧</a>
<!--  -->
<?php else :?>
<a href="<?php echo $base_url;?>/account/signin">ログイン</a>
<a href="<?php echo $base_url;?>/account/signup">アカウント登録</a>
<?php endif;?>
</p>
</div>
  </header>

<body >
<div class='site-width'>
  <div class="" id="main">
  <?php
  echo $_content;
  ?>
  </div>
</body>
  </div>
</html>

