<?php $this->setlayoutVar('title', $user['user_name']) ?>

<h2><?php echo $this->escape($user['user_name']); ?></h2>

<div id="statuses">
  <?php foreach ($statuses as $status) : ?>
    <?php echo $this->render('status/stauts', array('status' => $status)); ?>
  <?php endforeach; ?>
</div>