<?php

class DbManeger
{

  //接続情報を入れるようの変数
  protected $connections = array();

  protected $repositry_connection_map = array();
  protected $repositories = array();


  //接続を行うメソッド、　connect('接続を特定する名前','接続に必要な情報')
  public function connect($name, $params)
  {
    //1データベースに渡すユーザー情報
    $params = array_merge(array(
      'dsn' => 'null',
      'uers' => '',
      'password' => '',
      'options' => array(),
    ), $params);

    //PDOクラスのインスタンスを作成
    $con = new PDO(
      $params['dsn'],
      $params['user'],
      $params['password'],
      $params['options']
    );

    //エラーが起きた場合の例外処理
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $this->connections[$name] = $con;
  }

  //接続したコネクション（接続するプログラムの概要）を取得
  public function getConnection($name = null)
  {
    if (is_null($name)) {
      return current($this->connetions);
    }
    return $this->connections[$name];
  }

  ///?????????????
  public function setRepositoryConnectionMap($repository_name, $name)
  {
    $this->repogtry_connection_map[$repository_name] = $name;
  }

  public function getConnectionForRepository($repository_name)
  {
    if (isset($this->repositry_connection_map[$repository_name])) {
      $name = $this->repositry_connection_map[$repository_name];
      $con = $this->getConnection($name);
    } else {
      $con = $this->getConnection();
    }
    return $con;
  }

  //リポジトリインスタンスの生成処理、指定されたリポジトリ名がなかったら生成
  public function get($repository_name)
  {
  //クラス名の指定、
    if(!isset($this->repositories[$repository_name])){
      $repository_class = $repository_name.'Repository';
    //$repository_nameのコネクション（接続処理）を取得
      $con = $this->getConnectionForRepository($repository_name);
    //インスタンスの作成
      $repository = new $repository_class($con);
    //インスタンスの保持のため、$repositoryに格納
      $this->repositories[$repository_name]=$repository;
    }

    return $this->repositories[$repository_name];
  }

  //__desutruct()・・・特定のオブジェクトを参照先がひとつもなくなったとき、スクリプト終了時にコールされるマジックメソッド。
  //DB接続の解放処理（接続をやめる）
  public function __destruct()
  {

    foreach ($this->repositories as $repository){
      unset($repository);
    }
    foreach($this->connections as $con){
      unset($con);
    }
  }
}
