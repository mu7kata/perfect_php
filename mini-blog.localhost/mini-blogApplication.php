<?php

class MiniBlogApplication extends Application
{
  protected $login_action = array('accont','signin');
//ルートディレクトリのパスを返すメソッド
  public function getRootDIr()
  {
    return dirname(__FILE__);
  }

  protected function registerRoutes()
  {
    return array();
  }


  //アプリの設定を行う
  protected function congfigure()
  {
    //DBの接続設定
    $this->db_manager->connect('master',array(
      'dsn' => 'mysql:dbname=mini_blog;host=localhost',
      'user'=>'root',
      'password'=>'',
    ));
  }
}
?>