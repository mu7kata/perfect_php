<?php

//DBへのアクセスを行う。SQLの実行処理など。
abstract class DbRepository
{
  protected $con;

  //インスタンスが作成されたら、接続処理を保存するsetConnectionメソッドを発動
  public function __construct($con)
  {
    $this->setConnection($con);
  }

  //インスタンスに接続処理を保存
  public function setConnection($con)
  {
    $this->con = $con;
  }


  //SQLの実行処理
  public function execute($sql,$params = array())
  {
    //prepare・・・ユーザからの入力されたSQL文をセットする
    $stmt=$this->con->prepare($sql);
    //excute()・・・処理の実行
    $stmt->execute($params);

    return $stmt;
  }

  //実行結果を1行のみ表示
  public function fetch($sql,$params = array())
  {
    return $this->execute($sql,$params)->fetch(PDO::FETCH_ASSOC);
  }
   //実行結果を全て表示
  public function fetchAll($sql,$params = array())
  {
    return $this->execute($sql,$params)->fetchAll(PDO::FETCH_ASSOC);
  }
}
