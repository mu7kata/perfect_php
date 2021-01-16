<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php if (isset($title)): echo $this->escape($title) . '-';endif;?></title>
</head>
<body>
  <div id="header">
  <h1><a href="<?php echo $base_url;?>/">Mini Blog</a></h1>
  </div>

  <div id="id">
<p>
<?php if($session->isAuthenticated()):?>
<a href="<?php echo $base_url; ?>/">ホーム</a>
<a href="<?php echo $base_url; ?>/">アカウント</a>
<?php else :?>
<a href="<?php echo $base_url;?>/">ログイン</a>
<a href="<?php echo $base_url;?>/">アカウント登録</a>
<?php endif;?>
</p>

</div>

  <div class="" id="main">
  <?php echo $_content;?>
  </div>
</body>
</html>

