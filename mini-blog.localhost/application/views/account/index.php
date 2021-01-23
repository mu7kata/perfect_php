<?php $this->setlayoutVar('title','アカウント') ;
var_dump();

?>
<h2>アカウント</h2>

<p>
ユーザーID：
<a href="<?php echo $base_url;?>/user/<?php echo $this->escape($user['user_name']);?>">
<strong><?php echo $this->escape($user['user_name']); ?></strong>
</a>
</p>

<ul>
<li><a href="<?php echo $base_url;?>/status/follow/from">フォロー</a><?php echo $follow[0]['count(user_id)']; ?>人</li>
<li><a href="<?php echo $base_url;?>/status/follow/to">フォロワー</a><?php echo $follower[0]['count(following_id)']; ?>人</li>
<li><a href="<?php echo $base_url;?>">ホーム</a></li>
<li><a href="<?php echo $base_url;?>/account/signout">ログアウト</a></li>
</ul>