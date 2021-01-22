<?php $this->setlayoutVar('title','アカウント') ?>
<h2>アカウント</h2>

<p>
ユーザーID：
<a href="<?php echo $base_url;?>/user/<?php echo $this->escape($user['user_name']);?>">
<strong><?php echo $this->escape($user['user_name']); ?></strong>
</a>
</p>

<ul>
<li><a href="">フォロー</a><?php echo $follow[0]['count(user_id)']; ?>人</li>
<li><a href="">フォロワー</a><?php echo $follower[0]['count(following_id)']; ?>人</li>
<li><a href="<?php echo $base_url;?>">ホーム</a></li>
<li><a href="<?php echo $base_url;?>/account/signout">ログアウト</a></li>
</ul>