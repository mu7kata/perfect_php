<?php
abstract class Controller
{
  protected $controller_name;
  protected $action_name;
  protected $application;
  protected $request;
  protected $response;
  protected $session;
  protected $db_manager;

  //ログインが必要なアクションを指定
  protected $auth_actions=array();


  // get_class・・・オブジェクトのクラス名を返す
  //strtolower・・・小文字に変換

  //アクセスのあったクラスのコントローラ名にいろいろ変換した値を登録する。→User.Controllerなら「User」。
  public function __construct($application)
  {
    $this->controller_name = strtolower(substr(get_class($this), 0, -10));

    //受け取ったApplicationのインスタンスからかくインスタンスを取得
    $this->application = $application;
    $this->request = $application->getRequest();
    $this->response = $application->getReaponse();
    $this->session = $application->getSession();
    $this->db_Manager = $application->getDbManager();
  }
  //method_exists・・・クラスメソッドが存在するかどうかを確認する
  //

  public function run($action, $params = array())
  {
    $this->action_name = $action;
    $action_method = $action . 'Action';

    //クラスメソッドが存在していなかったらエラー処理
    if (!method_exists($this, $action_method)) {
      $this->forward404();
    }

    //メソッドにログインが必要であれば例外処理
    if($this->needAuthentication($action)&& !$this->session->isAuthenticated())
    {//
      throw new UnauthorizadActionException();
    }

    $content = $this->$action_method($params);
    return $content;

  }

  protected  function render($variables = array(), $template = null, $layout = 'layout')
  {
    //デフォルト値を設定
    $defaults = array(
      'request' => $this->request,
      'base_url' => $this->request->getBaseUrl(),
      'session' => $this->session,
    );
    //viewクラスのインスタンス化
    $view = new View($this->applivation->getViewDir(), $defaults);

    //3
    if (is_null($template)) {
      $template = $this->action_name;
    }

    //テンプレート名の指定
    $path = $this->controller_name . '/' . $template;

    //ビューファイルの読み込み（レンダリング）
    return $view->render($path, $variables, $layout);
  }

  //404えらー画面遷移するメソっど、リクエストがない場合に発動
  protected function forward404()
  {
    throw new HttpNotFoundException('Forwarded 404 page from' . $this->controller_name . '/' . $this->atction_name);
  }

  //Urlを受け取ってレスポンスをだすように設定
  protected function redirect($url)
  {
    //1リクエストクラス内のメソッドを元にURLを指定
    if (!preg_match('#https?://#', $url)) {
      $protocol = $this->request->isSsl() ? 'https://' : 'http://';
      $host = $this->request->getHost();
      $base_url = $this->request->getBaseUrl();

      $url = $protocol . $host . $base_url . $url;
    }
    //ブラウザにリダイレクトをつたエル。
    $this->response->setStatusCode(302, 'Found');
    $this->response->setHttpHeader('Location', $url);
  }

  //トークン（認識用文字列）を生成、サーバー保持
  protected function generateCsrfToken($form_name)
  {
    $key = 'csrf_tokens/' . $form_name;
    $tokens = $this->session->get($key, array());

    //トークンを複数保持し、array_shift関数（配列の先頭から要素を一つ取り出す）を用いて古いものから削除
    if (count($tokens) >= 10) {
      array_shift($tokens);
    }
    //ハッシュ関数（sha1）を使い、特定が難しいトークンを生成
    $token = sha1($form_name . session_id() . microtime());
    $token[] = $token;

    $this->session->set($key, $tokens);

    return $token;
  }
//セッションに格納されているPOSTされたトークンを探す
  protected function checkCsrfToken($form_name, $token)
  {
    $key = 'csrf_tokens/' . $form_name;
    $tokens = $this->session->get($key, array());

    //セッション上にトークンが格納されているか確認
    if (false !== ($pos = array_search($token, $tokens, true))) {
      unset($tokens[$pos]);
      $this->session->set($key, $tokens);

      return true;
    }
  }

  //$actionにログインが必要か判定する
  protected function needAuthentication($action){
    if ($this->auth_actions === true || (is_array($this->auth_actions) && in_array($action,$this->auth_actions))
    ){
      return true;
    }
    return false;
  }
}
