<?php

//オートロード・・・クラスなどを呼び出すこと

//オートロードに関する処理をまとめたクラス、クラスファイルの読み込みを毎回せずにプログラムを開発していけるようになる。
class ClassLoader
{
protected $dirs;


//PHPにオートローダークラスを登録する処理
public function register()
{
  spl_autoload_register(array($this,'loadClass'));

  //'loadClass'がオートロードの際に呼び出される
}

//ディレクトリを登録する
public function registerDir($dir)
{
$this->dirs[]=$dir;
}


///オートロードが実行された際にクラスファイルを読み込む処理
public function loadClass($class)
{
  foreach($this->dirs as $dir){
    $file = $dir . '/'.$class.'.php';
    if(is_readable($file)){
       require $file;
       return;
    }
  }
}

}
?>