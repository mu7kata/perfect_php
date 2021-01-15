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

      // ----------------StatusControllerのルーティング--------------------------------------
      // '/'アクセスしたら、indexアクションを呼び出す
      '/'
      => array('controller' => 'status', 'action' => 'index'),
      //'/status/post'でアクセスしたら、postアクションを呼び出す。
      '/status/post'
      => array('controller' => 'status', 'action' => 'post'),
      //ユーザーIDの指定
      '/user/:user_name'
      => array('controller' => 'status', 'action' => 'user'),

      //ユーザーIDと投稿IDの指定の指定
      '/user/:user_name/status/:id'
      => array('controller' => 'status', 'action' => 'show'),

      // ----------------AccountControllerのルーティング--------------------------------------
      // /arrayにアクセスすると下記を配列として登録する
      '/account'
      => array('controller' => 'account', 'action' => 'index'),

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
