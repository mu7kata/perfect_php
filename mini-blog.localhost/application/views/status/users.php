<?php $this->setlayoutVar('title','ユーザ一覧');

?>

<h2>ユーザー一覧</h2>

<div id="statuses">
  <?php foreach ($users as $user) : ?>
    <ul><a href="<?php echo $base_url; ?>/user/<?php echo $user['user_name'];?>"><?php echo $user['user_name'];?></a></ul>
  <?php endforeach; ?>
</div>