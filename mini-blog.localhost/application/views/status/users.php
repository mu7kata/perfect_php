<!-- // 修正箇所----------------------------------------------------------------------- -->
<?php $this->setlayoutVar('title','ユーザ一覧');

?>
<style>

</style>
<h2>ユーザー一覧</h2>

<div id="statuses">
  <?php foreach ($users as $user) : ?>
  <p class='icon'><img class='status_icon' src="/study_localhost/mini-blog.localhost/application/<?php echo $user['icon'];?>" alt=""></p>
    <ul><a href="<?php echo $base_url; ?>/user/<?php echo $user['user_name'];?>"><?php echo $user['user_name'];?></a></ul>
  <?php endforeach; ?>
</div>