<?php $this->setlayoutVar('title', $user['user_name']) ;
      $icon=$user_status[0]['icon'];
?>
<img src="/study_localhost/mini-blog.localhost/application/<?php echo $icon;?>" alt="l">
<h2><?php echo $this->escape($user['user_name']); ?></h2>
<p><a href="<?php echo $base_url; ?>/status/follow/from/<?php echo $user['id']?>">フォロー</a><?php echo $follow[0]['count(following_id)']; ?>人　</p>
<p><a href="<?php echo $base_url; ?>/status/follow/to/<?php echo $user['id']?>">フォロワー</a><?php echo $follower[0]['count(user_id)']; ?>人</p>

<?php if (!is_null($following)) : ?>
  <?php if ($following) : ?>
    <p>フォローしています</p>
  <?php else : ?>
    <form action="<?php echo $base_url; ?>/follow" method="post">
      <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
      <input type="hidden" name="following_name" value="<?php echo $this->escape($user['user_name']); ?>" />
      <input type="submit" value="フォローする">
    </form>
  <?php endif; ?>
<?php endif; ?>
<div id="statuses">
  <?php foreach ($statuses as $status) : ?>
    <?php echo $this->render('status/status', array('status' => $status)).'<br>'; ?>
  <?php endforeach; ?>
</div>