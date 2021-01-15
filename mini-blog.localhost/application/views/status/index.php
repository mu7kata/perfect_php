<?php
$this->setLayoutVar('title', 'ホーム')
?>

<h2>ホーム</h2>
<form action="<?php echo $base_url; ?>/status/post" method="post">
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

  <!-- エラー表示 -->
  <?php if (isset($errors) && count($errors) > 0) : ?>
    <?php echo $this->render('errors', array('errors' => $errors)); ?>
  <?php endif; ?>
<!-- <?php
class test{
public $test = array('a'=>'1','b'=>'2','c'=>'3');

public function testt($test){
  echo $test->a;
}
}

$test=new test();
echo $test->test->a;
echo $test->testt('q');
?> -->

  <textarea name="body" cols="60" rows="2"><?php echo $this->escape($body); ?></textarea>
  <p>
    <input type="submit" value="発言">
  </p>
</form>
<?php var_dump($statuses); ?>
<div id="statuses">
  <?php foreach ($statuses as $status) : ?>
    <div class="status">
     <?php echo $this->render('status/status',array('status'=>$status));?>
  <?php endforeach; ?>
</div>