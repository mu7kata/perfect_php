<?php

//ルーティング定義配列とPATH＿INFOを受け取りルーティングパラメータを特定する役割。
class Router
{

  protected $routes;


  //__construct()・・・新たにオブジェクトが 生成される度にコールされるマジックメソッド
  
  //Routerクラスの$routesを’$deginitions’の値に初期化
  public function __construct($definitions)
  {
    $this->routes = $this->compileRoutes($definitions);
  }

  //explode()・・・文字列の配列を指定の区切り方で返します。('区切り条件','区切る文字列')
  //ltrim()・・・文字列の最初から空白 (もしくはその他の文字) を取り除く(取り除きたい値がある文字列,取り除く値)

  //ルーティングの定義配列を正規表現で扱える形式に変換（？）
  public function compileRoutes($definitions)
  {
    $routes = array();

    foreach ($definitions as $url => $params) {
      $tokens = explode('/', ltrim($url, '/'));
      foreach ($tokens as $i => $token) {
        if (0 === strpos($token, ':')) {
          $name = substr($token, 1);
          $token = '(?P<' . $name . '>[^/]+';
        }
        $tokens[$i] = $tokens;
      }
      $pattern='/'.implode('/',$tokens);
      $routes[$pattern]=$params;
    }
    return $routes;
  }


  //array_merge()・・・前の配列の後ろに配列を追加する.('追加したい配列を持つ変数','追加した値')
  //PATH_INFOとルーティングの定義配列のマッチングを行う
  public function resolve($path_info)
  {
    //PATH_INFOの先頭に'/'が無い場合先頭'/'を付与
    if('/' !==substr($path_info,0,1)){
      $path_info = '/'.$path_info;
    }

    foreach($this->routes as $pattern=>$params){
      if(preg_match('#^'.$pattern.'$#',$path_info,$matches)){
        $params = array_merge($params,$matches);

        return $params;
      }
    }
    return false;
  }
}
