<?php
$this->setLayoutVar('title', 'ホーム');

$icon=$statuses[3]['icon'];
echo var_dump($statuses[3]);
?>
<?php 

 ?>
<h2>ホーム</h2>

<form action="<?php echo $base_url; ?>/status/post" method="post">
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

  <!-- エラー表示 -->
  <?php if (isset($errors) && count($errors) > 0) : ?>
    <?php echo $this->render('errors', array('errors' => $errors)); ?>
  <?php endif; ?>

  <textarea name="body" cols="60" rows="2"><?php echo $this->escape($body); ?></textarea>
  <p>
    <input type="submit" value="発言">
  </p>

</form>
<div id="statuses">
  <?php foreach ($statuses as $status) : ?>
  <p>
    <img class='status_icon' src="/study_localhost/mini-blog.localhost/application/<?php echo $icon?>" alt="k">
  </p>
    <div class="status">
     <?php echo $this->render('status/status',array('status'=>$status));?>
  <?php endforeach; ?>
</div>