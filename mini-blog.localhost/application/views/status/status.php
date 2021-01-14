<?php
//同じ表示をする部分を抜き出す


?>

<div class="status_content">
        <?php echo $this->escape($status['user_is']); ?>
        <?php echo $this->escape($status['body']); ?>
      </div>
      <div>
        <?php echo $this->escape($status['created_at']); ?>
      </div>
    </div>