<?php

//新規登録機能

class AccountController extends Controller
{
  protected $auth_actions = array('index', 'signout','follow');
 
  public function signupAction()
  {
    return $this->render(array(
      'user_name' => '',
      'password' => '',
      '_token' => $this->generateCsrfToken('account/signup'),
    ));
  }
  public function registerAction()
  {
    //リクエストの種類が”post”じゃなかったら４０４エラー
    if (!$this->request->isPost()) {
      $this->forward404();
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

      return $this->render(array(
          'user'       => $user,
          'followings' => $followings,
      ));
  }

  
  
  public function signinAction()
  {
    
    //ログインしてるか確認
    if ($this->session->isAuthenticated()) {
      return $this->redirect('/account');
    }
    //ビューファイルに渡す変数の指定
    return $this->render(array(
      'user_name' => '',
      'password' => '',
      '_token' => $this->generateCsrfToken('account/signin'),
    ));
  }
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

  public function signoutAction()
  {
    $this->session->clear();
    $this->session->setAuthenticated('false');

    return $this->redirect('/account/signin');

  }
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
      if ($user['id'] !== $follow_user['id'] 
          && !$following_repository->isFollowing($user['id'], $follow_user['id'])
      ) {
          $following_repository->insert($user['id'], $follow_user['id']);
      }

      return $this->redirect('/account');
  }

}
