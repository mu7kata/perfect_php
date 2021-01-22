<?php $this->setlayoutVar('title','フォロワー一覧');

?>

<h2>あなたのフォロワー</h2>

<div id="statuses">
  <?php foreach ($follower_name as $follower_nam) : ?>
    <ul><a href="<?php echo $base_url;?>/user/<?php echo $follower_nam['user_name'];?>"><?php echo $follower_nam['user_name'];?></a></ul>
  <?php endforeach; ?>
</div>