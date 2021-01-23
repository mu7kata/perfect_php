<?php $this->setlayoutVar('title','フォロワー一覧');
//　/status/follow/:idの：idの値を格納
$param=$params[1];
echo  $param;

?>

<!-- フォローボタンを押されたかどうか挙動を変更 -->
<?php  if($params[1] !== 'to'){?>
  <h2>あなたのフォロ-</h2>

<div id="statuses">
  <?php foreach ($follower_name as $follower_nam) : ?>
    <ul><a href="<?php echo $base_url;?>/user/<?php echo $follower_nam['user_name'];?>"><?php echo $follower_nam['user_name'];?></a></ul>
  <?php endforeach; ?>
</div>
  <?php }else{ ?>
<h2>あなたのフォロワー</h2>

<div id="statuses">
  <?php foreach ($follower_name as $follower_nam) : ?>
    <ul><a href="<?php echo $base_url;?>/user/<?php echo $follower_nam['user_name'];?>"><?php echo $follower_nam['user_name'];?></a></ul>
  <?php endforeach; ?>
</div>
<?php }?>