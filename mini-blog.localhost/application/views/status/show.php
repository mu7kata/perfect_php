<?php $this->setLayoutVar('title',$status['user_name'])?>


<!-- 投稿内容の詳細 -->
<?php echo $this->render('status/status',array('status'=>$status));?>