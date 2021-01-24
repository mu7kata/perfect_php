<?PHP
//bootstrap・・・アプリを立ち上げるための動作処理。

require 'core/ClassLoader.php';

//ClassLoaderクラス（オートローどの設定処理）をインスタンス化（実体化）
$loader = new ClassLoader();

//'/core'ファイルの親ディレクトリのパスを返し、ディレクトリを登録する
$loader->registerDir(dirname(__FILE__).'/core');
//'/models'ファイルの親ディレクトリのパスを返し、ディレクトリを登録する
$loader->registerDir(dirname(__FILE__).'/models');

//PHPにオートローダークラスを登録
$loader->register();

?>