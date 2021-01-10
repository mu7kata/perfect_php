<?php


abstract class Application
{
  protected $debug = false;
  protected $request;
  protected $response;
  protected $session;
  protected $db_manager;

  public function __construct($debug = false)
  {
    $this->setDebagMode($debug);
    $this->initialize();
    $this->configure();
  }


  //ini_set()・・・設定オプションの値を設定
  //error_reporting・・・出力する PHP エラーの種類を設定

  //デバックモードに応じてエラー表示を変更
  protected function setDebagMode($debug)
  {
    if ($debug) {
      $this->debug = true;
      ini_set('display_errors', 1);
      error_reporting(-1);
    } else {
      $this->debug = false;
      ini_set('display_errors', 0);
    }
  }

  //クラスの初期化処理
  protected function initialize()
  {
    $this->request = new Request();
    $this->response = new Response();
    $this->session = new Session();
    $this->db_manager = new Dbmanager();
    $this->router = new Router($this->registerRoutes());
  }

  //個別で設定できるように定義
  protected function configure()
  {
  }

  //ルートディレクトリのパスを返すメソッド（実装漏れをなくすために抽象で定義）
  abstract public function getRootDIr();
  //ルーティングの定義配列を渡す。
  abstract protected function registerRoutes();

  public function isDebugMode()
  {
    return $this->debug;
  }

  public function getRequest()
  {
    return $this->request;
  }

  public function getResponse()
  {
    return $this->response;
  }

  public function getSession()
  {
    return $this->session;
  }

  public function getDbManager()
  {
    return $this->db_Manager;
  }
  public function getControllerDir()
  {
    return $this->getRootDir() . '/controllers';
  }
  public function getViewDir()
  {
    return $this->getRootDir() . '/views';
  }
  public function getModeDir()
  {
    return $this->getRootDir() . '/models';
  }
  public function getVWebDir()
  {
    return $this->getRootDir() . '/web';
  }


  //resolve()・・・PATH_INFOとルーティングの定義配列のマッチングを行うオリジナルメソッド
  //リクエストに対応するためのメソッド、ルーティングパラメータを取得し、コントローラとアクション名を特定する。（処理の振り分けをするためにアクセス情報の分析する？？）
  public function run()
  {


    $params = $this->rooter->resolve($this->request->getPathINfo());
    if ($params === false) {
      //todo-A

      throw new HttpNotFoundException('No route found for' . $this->reqest->getPathInfo());
    }
    $controller = $params['controller'];
    $action = $params['action'];

    $this->runAction($controller, $action, $params);

    try {
    } catch (HttpNotFoundException $e) {
      $this->render404Page($e);
    }catch(UnauthorizadActionException $e){
      list($controller,$action)=$this->login_action;
      $this->runAction($controller,$action);

    }
    $this->response->send();
  }
protected function render404Page($e){
$this->response->setStatusCode(404,'Not Found');
$message = $this->isDebugMode()? $e->getMessage(): 'Page not found.';
$message=htmlspecialchars($message,ENT_QUOTES,'UTF-8');

$this->response->setContent(<<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  {$message}
</body>
</html>

EOF);
}

  //ucfirst()・・・先頭を大文字にするメソッド
  //アクションを実行するメソッド
  public function runAction($controller_name, $action, $params = array())
  {
    $controller_class = ucfirst($controller_name) . 'Controller';
    $controller = $this->findController($controller_class);
    if ($controller === false) {
      //todo-B
      throw new HttpNotFoundException($controller_class . ' controller is not found.');
    }

    $content = $controller->run($action, $params);
    $this->response->setContent($content);
  }


  //コントローラが読み込まれていない場合にクラスファイルの読み込みをおこないコントローラを作成する。
  protected function findController($controller_class)
  {
    if (!class_exists($controller_class)) {
      $controller_file = $this->getControllerDir() . '/' . $controller_class . 'php';
      if (!is_readable($controller_file)) {
        return false;
      } else {
        require_once $controller_file;

        if (!class_exists($controller_class)) {
          return false;
        }
      }
    }
    return new $controller_class($this);
  }
}
?>
