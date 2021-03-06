<?php

//新規登録機能

class AccountController extends Controller
{
  protected $auth_actions = array('index', 'signout', 'follow');

  public function signupAction()
  {
    return $this->render(array(
      'user_name' => '',
      'password' => '',
      '_token' => $this->generateCsrfToken('account/signup'),
    ));
  }
  //新規登録処理
  public function registerAction()
  {
    //リクエストの種類が”post”じゃなかったら４０４エラー
    if (!$this->request->isPost()) {
      $this->forward404();
    }

    if ($this->session->isAuthenticated()) {
      return $this->redirect('/account');
    }
    //ポストのトークンの値を格納
    $token = $this->request->getPost('_token');

    if (!$this->checkCsrfToken('account/signup', $token)) {
      return $this->redirect('/account/signup');
    }

    $user_name = $this->request->getPost('user_name');
    $password = $this->request->getPost('password');

    $errors = array();

    if (!strlen($user_name)) {
      $errors[] = 'ユーザIDを入力してください';
    } else if (!preg_match('/^\w{3,20}$/', $user_name)) {
      $errors[] = 'ユーザIDは半角英数字およびアンダースコアを3 ～ 20 文字以内で入力してください';
    } else if (!$this->db_manager->get('User')->isUniqueUserName($user_name)) {
      $errors[] = 'ユーザIDは既に使用されています';
    }

    if (!strlen($password)) {
      $errors[] = 'パスワードを入力してください';
    } else if (4 > strlen($password) || strlen($password) > 30) {
      $errors[] = 'パスワードは4 ～ 30 文字以内で入力してください';
    }

    if (count($errors) === 0) {
      //Userリポジトリのinsertメソッドを呼び出す。
      $this->db_manager->get('User')->insert($user_name, $password);
      $this->session->setAuthenticated(true);

      $user = $this->db_manager->get('User')->fetchByUserName($user_name);
      $this->session->set('user', $user);

      return $this->redirect('/');
    }

    return $this->render(array(
      'user_name' => $user_name,
      'password'  => $password,
      'errors'    => $errors,
      '_token'    => $this->generateCsrfToken('account/signup'),
    ), 'signup');
  }

  //認証するアクション
  public function indexAction()
  {
    $user = $this->session->get('user');
    $followings = $this->db_manager->get('User')
    ->fetchAllFollowingsByUserId($user['id']);
    
    //ユーザーのステータスを取得
    $user_statuses = $this->db_manager->get('Status')
    ->fetchAllPersonalArchivesByUserId($user['id']);

    // 修正箇所もらたもらたもらたもらたもらたーーもらたもらたもらたもらたーーー
    $follower = $this->db_manager->get('Following')->Follower($user['id']);
    $follow=$this->db_manager->get('Following')->Follow($user['id']);
    return $this->render(array(
      'user'       => $user,
      'followings' => $followings,
      'follower' => $follower,
      'follow'=>$follow,
      'user_statuses'=>$user_statuses,
    ));
  }


  //ログイン処理
  public function signinAction()
  {
    if ($this->session->isAuthenticated()) {
      return $this->redirect('/account');
    }

    return $this->render(array(
      'user_name' => '',
      'password'  => '',
      '_token'    => $this->generateCsrfToken('account/signin'),
    ));
  }


  //認証確認処理
  public function authenticateAction()
  {
    if ($this->session->isAuthenticated()) {

      return $this->redirect('/account');
    }
    if (!$this->request->isPost()) {
      $this->forward404(); //returnない
    }
    $token = $this->request->getPost('_token');
    if (!$this->checkCsrfToken('account/signin', $token)) {
      return $this->redirect('/account/signin');
    }

    $user_name = $this->request->getPost('user_name');
    $password = $this->request->getPost('password');

    //バリデーション
    $errors = array();

    if (!strlen($user_name)) {
      $errors[] = 'ユーザーIdを入力しろ';
    }

    if (!strlen($password)) {
      $errors[] = 'パスワードを入力しろ';
    }
    //authenticateAction()
    if (count($errors) == 0) {
      $user_repository = $this->db_manager->get('User');
      $user = $user_repository->fetchByUserName($user_name);

      if (
        !$user
        || ($user['password'] !== $user_repository->hashPassword($password))
      ) {
        $errors[] = 'ユーザー名かパスワードが不正だよ';
      } else {
        $this->session->setAuthenticated(true);
        $this->session->set('user', $user);

        return $this->redirect('/');
      }
    }

    return $this->render(array(
      'user_name' => $user_name,
      'password'  => $password,
      'errors'    => $errors,
      '_token'    => $this->generateCsrfToken('account/signin'),
    ), 'signin');
  }

  //ログアウト処理
  public function signoutAction()
  {
    $this->session->clear();
    $this->session->setAuthenticated(false);

    return $this->redirect('/account/signin');
  }

  //フォロー処理
  public function followAction()
  {
    if (!$this->request->isPost()) {
      $this->forward404();
    }

    $following_name = $this->request->getPost('following_name');
    if (!$following_name) {
      $this->forward404();
    }

    $token = $this->request->getPost('_token');
    if (!$this->checkCsrfToken('account/follow', $token)) {
      return $this->redirect('/user/' . $following_name);
    }

    $follow_user = $this->db_manager->get('User')
      ->fetchByUserName($following_name);
    if (!$follow_user) {
      $this->forward404();
    }

    $user = $this->session->get('user');

    $following_repository = $this->db_manager->get('Following');
    if (
      $user['id'] !== $follow_user['id']
      && !$following_repository->isFollowing($user['id'], $follow_user['id'])
    ) {
      $following_repository->insert($user['id'], $follow_user['id']);
    }

    return $this->redirect('/account');
  }
}
[0]=> array(6) { 
  ["id"]=> string(2) "18"
   ["user_id"]=> string(1) "8" 
   ["body"]=> string(15) "おやすみ〜" 
   ["created_at"]=> string(19) "2021-01-24 20:13:50" 
   ["icon"]=> NULL 
  ["user_name"]=> string(5) "12345" } 
  
  [1]=> array(6) { 
    ["id"]=> string(2) "17" 
    ["user_id"]=> string(1) "8" 
    ["body"]=> string(21) "お腹すいた〜！" 
    ["created_at"]=> string(19) "2021-01-24 02:26:15" 
    ["icon"]=> NULL 
    ["user_name"]=> string(5) "12345" } 
    
    [2]=> array(6) { 
      ["id"]=> string(2) "10" 
      ["user_id"]=> string(1) "8" 
      ["body"]=> string(3) "sss" 
      ["created_at"]=> string(19) "2021-01-18 22:01:19" 
      ["icon"]=> string(17) "image/nobita.jpeg" 
      ["user_name"]=> string(5) "12345" } }