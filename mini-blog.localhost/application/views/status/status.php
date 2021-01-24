<?php
//同じ表示をする部分を抜き出す


?>
<div class="status_contents">
<div class="status_content">
<!-- 投稿一覧のリンク -->
  <a href="<?php echo $base_url; ?>/user/<?php echo $this->escape($status['user_name']); ?>">
    <?php echo $this->escape($status['user_name']); ?>
  </a>
  <?php echo $this->escape($status['body']); ?>
</div>

<div class="status_content">
<!-- 投稿詳細リンク -->
  <a href="<?php echo $base_url; ?>/user/<?php echo $this->escape($status['user_name']); ?>">
    <?php echo $this->escape($status['id']); ?>
    <?php echo $this->escape($status['created_at']); ?>
  </a>
</div>
</div>
</div>