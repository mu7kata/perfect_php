<?php

//タイトルを設定
$this->setLayoutVar('title', 'アカウント登録')
?>

<h2>アカウント登録</h2>
<!-- フォームの送信先を指定登録ページに設定 -->
<form action="<?php echo $base_url; ?>/account/register" method="post">
  <!-- 画面には表示されないインプット、トークンを渡す -->
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

  <table>
    <tbody>
      <tr>
        <th>ユーザーID</th>
        <td>
          <input type="text" name="user_name" value="" />
        </td>
      </tr>

      <th>パスワード</th>
      <td>
        <input type="password" name="password" value="" />
      </td>
    </tbody>
  </table>

  <p>
    <input type="submit" value="登録">
  </p>
</form>