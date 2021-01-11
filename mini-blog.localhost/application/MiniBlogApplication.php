<?php

class MiniBlogApplication extends Application
{

  //ルートディレクトリのパスを返すメソッド
  protected $login_action = array('account', 'signin');

  public function getRootDir()
  {
    return dirname(__FILE__);
  }


  protected function registerRoutes()
  {
    return array(

      // /arrayにアクセスすると下記を配列として登録する
      '/array'
      => array('controller' => 'accont', 'action' => 'index'),

      // /accountでアクセスするとindexアクションを呼び出す
      '/account/:action'
      => array('controller' => 'account'),
    );
  }

  //アプリの設定を行う
  protected function configure()
  {    //DBの接続設定
    $this->db_manager->connect('master', array(
      'dsn'      => 'mysql:dbname=mini_blog;host=localhost',
      'user'     => 'root',
      'password' => 'root',
    ));
  }
}
