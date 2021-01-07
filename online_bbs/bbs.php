<?php
ini_set('log_errors', 'on');
ini_set('error_log', 'php.log');

$debug_flg = true;

function debug($str)
{
  global $debug_flg;
  if (!empty($debug_flg)) {
    error_log('デバッグ：' . $str);
  }
}

function debugLogStart()
{
  debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
  debug('セッションID：' . session_id());
  debug('セッション変数の中身：' . print_r($_SESSION, true));
  debug('現在日時タイムスタンプ：' . time());
  if (!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])) {
    debug('ログイン期限日時タイムスタンプ：' . ($_SESSION['login_date'] + $_SESSION['login_limit']));
  }
}


function dbConnect()
{
  $dsn = 'mysql:dbname=online_bbs;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';

  $option = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  $dbh = new PDO($dsn, $user, $password, $option);
  return $dbh;
}
debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');


$errors=array();

session_start();

function queryPost($dbh, $sql, $data)
{
  debug('DBへの命令結果を反映');
  $stmt = $dbh->prepare($sql);
  if (!$stmt->execute($data)) {
    debug('クエリに失敗しました。');
    debug('失敗したSQL：' . print_r($stmt, true));
    $err_msg['common'] = '失敗した';
    return 0;
  }
  debug('クエリ成功');
  return $stmt;
}

$post_name=$_POST['name'];



//名前フォームの入力チェック
if(!empty($_POST)){
  debug('入力チェック');
if($post_name ===''){
  $errors['name']='一言入力してください';
  debug('$errors一言'.print_r($errors,true));
  debug('$errorsname'.print_r($post_name,true));
}else if(strlen($post_name)>2){
  $errors['name']='2文字いない入力してください';
}}


//エラーがなければフォームの値をDBへ登録
if(count($errors)===0){

  if(!empty($_POST)){
  $dbh = dbConnect();
  $sql = 'INSERT INTO `post`(name,comment,created_at)VALUES(:name,:comment,:created_at)';
  $data = array( 
    ':name'=>$_POST['name'],
    ':comment'=>$_POST['comment'],
    ':created_at'=>date('Y-m-d-H-i'));
  $stmt = queryPost($dbh, $sql, $data);
  
  if ($stmt) {
    debug('成功');
  } else {
    debug('失敗');
    return false;
  }
  }
}
//投稿内容表示処理
$db = dbConnect();
$sq='SELECT * from `post` order by `created_at` DESC';
$stm = $db->query($sq);
$stttt=$stm->fetchall(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ひとこと掲示板</title>
</head>
<style>
.table1{
  border:1px;
  background-color: red;
}
</style>
<body>
  <h1>ひとこと掲示板</h1>

  <form action="bbs.php" method=post>
 
  <p><?php if(!empty($errors['name'])) echo htmlspecialchars($errors['name']);
  ?></p>
    名前：<input type="text" name='name'><br />
    ひとこと：<input type="text" name='comment' size="60"><br />
    <input type="submit" value="送信"><br />
  </form>
<table class=table1 border="1" >
<tr><th>投稿者</th><th>コメント</th></tr>

<?php foreach($stttt as $st => $val){ ?>
<tr><td> <?php echo $val['name']."<br>"; ?></td><td><?php  echo $val['comment']."<br>"; ?></td></tr>
<?php } ?>
</table>

</body>

</html>