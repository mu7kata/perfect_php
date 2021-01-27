<?php 

$this->setlayoutVar('title','プロフィール編集') ;

echo $statuses

?>

<h2>プロフィールを編集</h2>
<form action="<?php echo $base_url;?>/account/post" method="post">

アカウント名<br>
<input type="text" name="user_name" value="<?php echo $edit_content['user_name']?>"><br>
アイコン<br>
<input type="text" name="icon" value="<?php echo $edit_content['icon']?>"><br>
<input type="submit" value="登録">
</form>
