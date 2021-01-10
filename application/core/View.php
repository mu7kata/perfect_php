<?php

class View
{
  protected $base_dir; //viewファイルを格納しているviewsディレク鳥の絶対パス（フルぱす）の格納
  protected $defaults; //viewファイルに変数を渡すときのデフォルト値の格納
  protected $layout_variables = array(); //

  public function __construct($base_dir, $defaults = array())
  {
    $this->base_dir = $base_dir;
    $this->defaults = $defaults;
  }

  //レイアウトファイル側に値を設定するメソッド
  public function setLayoutVar($name, $value)
  {
    $this->layout_variables[$name] = $value;
  }

  public function render($_path, $_variables = array(), $_layout = false)
  {
    $_file = $this->base_dir . '/' . $_path . '.php';

    //extract・・・配列から指定した変数名をインポートする
    extract(array_merge($this->defaults, $_variables));
    
    //出力情報を内部に保存する処理スタート
    ob_start();
    
    
    ob_implicit_flush(0);

    require $_file;
    $content = ob_get_clean();

    //render()・・・viewファイルの読み込み
    if ($_layout) {
      $content = $this->render(
        $_layout,
        array_merge($this->layout_variables, array(
          '_content' => $content,
        ))
      );
    }
    return $content;
  }
//htmlspecialcharsメソッドの簡略化（特殊文字のエスケープ）
  public function escape($string)
  {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
  }
}
