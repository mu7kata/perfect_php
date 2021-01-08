<?php
class Request
{

  //HTTPメソッド（リクエストされた値）がPOSTかどうか判定
  public function isPost()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return true;
    }
    return false;
  }

  //$_GET変数から値を取得
  public function getGet($name, $default = null)
  {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    }
    return $default;
  }
  //$_POST変数から値を取得
  public function getPost($name, $default = null)
  {
    if (isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $default;
  }
  //サーバーのホスト名を取得。ホスト名はリダイレクトをおこなう場合に利用
  public function getHost()
  {
    if (!empty($_SERVER['HTTP_HOST'])) {
      return $_SERVER['HTTP_HOST'];
    }
    return $_SERVER['SERVER_NAME'];
  }

  //HTTPS（セキュリテイの高い通信手段）でアクセスされたかを判定
  public function isSsl()
  {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      return true;
    }
    return false;
  }

  //リクエストされたURLを取得
  public function getRequestUri()
  {
    return $_SERVER['REQEST_URI'];
  }


//dirname()・・・ファイルのパスからディレクトリ部分を抜き出す関数
//strpos()・・・第一引数にし指定して文字列から、第二引数に指定した文字列が最初に出現する位置を調べる関数
//strpos()・・・　右側に続く’/’（スラッシュ）を削除する関数

//ベースURLの特定
  public function getBaseUrL()
  {
    $script_name = $_SERVER['SCRIPT_NAME'];
    $request_uri = $this->getRequestUri();

    if (0 === strpos($request_uri, $script_name)) {
      return $script_name;
    } else if (0 === strpos($request_uri, dirname($script_name))) {
      return rtrim(dirname($script_name), '/');
    }
    return '';
  }

//substr()・・・指定した文字数分取得する関数。（文字数取得したい値,取得開始位置,取得する文字数）

//PATH_INFOの特定
  public function getPathInfo()
  {
    $base_url = $this->getBaseUrL();
    $request_uri = $this->getRequestUri();
    if (false !== ($pos = strpos($request_uri, '?'))) {
      $request_uri = substr($request_uri, 0, $pos);
    }
    $path_info = (string)substr($request_uri, strlen($base_url));
    return $path_info;
  }
}
