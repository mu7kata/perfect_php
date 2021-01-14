<?php

//タイトルを設定
$this->setLayoutVar('title', 'アカウント登録');


$te2 = $_SERVER['REQUEST_URI'];
$te = dirname($te2);
$test = substr($te, 1);
echo $te;

?>

<h2>アカウント登録</h2>
<!-- フォームの送信先を指定登録ページに設定 -->
<form action="<?php echo $base_url; ?>/account/register" method="post">
  <!-- 画面には表示されないインプット、トークンを渡す -->
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

  <!--  -->
  <!-- エラー表示 -->
  <?php if (isset($errors) && count($errors) > 0) : ?>
    <?php echo $this->render('errors', array('errors' => $errors)); ?>

    <ul class="error_list">
      <?php foreach ($errors as $error) : ?>
        <li><?php endforeach; ?></li>
    </ul>
  <?php endif; ?>

<?php echo $this->render('account/inputs',array('user_name'=>$user_name,'password'=>$password,));?>
  <p>
    <input type="submit" value="登録" />
  </p>
</form>