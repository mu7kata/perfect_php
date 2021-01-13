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
  <?php if (isset($errors) && count($errors) > 0) : ?>
    <ul class="error_list">
      <?php foreach ($errors as $error) : ?>
        <li><?php endforeach; ?></li>
    </ul>
  <?php endif; ?>
  <table>
    <tbody>

      <tr>
        <th>ユーザーID</th>
        <td>
 <!--  -->
          <input type="text" name="user_name" value="<?php echo $this->escape($user_name); ?>" />
        </td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td>
      <!--  -->
          <input type="password" name="password" value="<?php echo $this->escape($password); ?>" />
        </td>
      </tr>
    </tbody>
  </table>

  <p>
    <input type="submit" value="登録"/>
  </p>
</form>