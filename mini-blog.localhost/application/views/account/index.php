<?php 

$this->setlayoutVar('title','アカウント') ;
$icon=$user_statuses[1]['icon'];

?>
<h2>マイアカウント</h2>
<img src="/study_localhost/mini-blog.localhost/application/<?php echo $icon;?>" alt="k">

<p>
ユーザーID：
<a href="<?php echo $base_url;?>/user/<?php echo $this->escape($user['user_name']);?>">
<strong><?php echo $this->escape($user['user_name']); ?></strong>
</a>
</p>

<ul>
<!-- // 修正箇所----------------------------------------------------------------------- -->
<li><a href="<?php echo $base_url;?>/status/follow/from/<?php echo $user['id']?>">フォロー</a><?php echo $follow[0]['count(following_id)']; ?>人</li>
<li><a href="<?php echo $base_url;?>/status/follow/to/<?php echo $user['id']?>">フォロワー</a><?php echo $follower[0]['count(user_id)']; ?>人</li>
<!--  -->
<li><a href="<?php echo $base_url;?>">ホーム</a></li>
<li><a href="<?php echo $base_url;?>/account/signout">ログアウト</a></li>
</ul>