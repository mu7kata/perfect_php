<?php
class Session
{
  protected static $sessionStarted = false;
  protected static $sessionIdRegenerated = false;


//インスタンスが生成されたら自動でセッションスタート
  public function __construct()
  {
if(!self::$sessionStarted){
  session_start();
self::$sessionStarted =true;
}
  }
  
  public function set($name,$value)
  {
    $_SESSION[$name]=$value;
  }

  public function get($name,$default = null)
  {
    if(isset($_SESSION[$name])){
      return $_SESSION[$name];
    }
    return $default;
  }
  public function remove($name)
  {
    unset($_SESSION[$name]);
  }

  public function clear()
  {
    $_SESSION = array();
  }

  //セッションIDの新規発行
  public function regenerate($destroy=true)
  {
    if(!self::$sessionIdRegenerated){
      session_regenerate_id($destroy);
      self::$sessionIdRegenerated = true;
    }
  }

  //ログイン状態の判定
  public function setAuthenticated($bool){
    $this->set('_authticated',(bool)$bool);
    //セッションID再発行
    $this->regenerate();
  }

public function isAuthenticated()
{
  return $this->get('_authenticated',false);
}

}

?>