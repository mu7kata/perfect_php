<?php
class StatusController extends Controller
{
  protected $auth_actions = array('index', 'post');


  public function indexAction()
  {
    $user = $this->session->get('user');

    $statuses = $this->db_manager->get('Status')
      ->fetchAllByUserId($user['id']);


    return $this->render(array(
      'statuses' => $statuses,
      'body' => '',
      '_token' => $this->generateCsrfToken('status/post'),

    ));
  }



  public function postAction()
  {
    //リクエストがpost意外だったら４０４エラー
    if (!$this->request->ispost()) {
      $this->forward404();
    }
    //postの値を格納（セキュリティチェックしたトークン）
    $token = $this->request->getPost('_token');
    if (!$this->checkCsrfToken('status/post', $token)) {
      return $this->redirect('/');
    }

    //post された’body'の値を取得
    $body = $this->request->getPost('body');


    $errors = array();

    //バリデーション
    if (!strlen($body)) {
      $errors[] = 'ひとことを入力してください';
    } else if (mb_strlen($body) > 200) {
      $errors[] = 'ひとことは２００文字以内で入力してください';
    }

    //エラーがなければ保存処理
    if (count($errors) === 0) {
      $user = $this->session->get('user');
      $this->db_manager->get('Status')->insert($user['id'], $body);

      return $this->redirect('/');
    }
    //投稿一覧データを取得し、ホームへリダイレクト
    $user = $this->session->get('user');
    $statuses = $this->db_manager->get('Status')
      ->fetchAllPersonalArchivesByUserId($user['id']);

    return $this->render(array(
      'errors' => $errors,
      'body' => $body,
      'statuses' => $statuses,
      '_token' => $this->generateCsrfToken('status/post'),
    ), 'index');
  }

  public function userAction($params)
  {
    //外部データからユーザ情報を取得

    $user = $this->db_manager->get('user')
      ->fetchByUserName($params['user_name']);
    $follower = $this->db_manager->get('Following')->Follower($user['id']);
    $follow = $this->db_manager->get('Following')->Follow($user['id']);
    //ユーザーの存在を確認数
    if (!$user) {
      $this->forward404();
    }

    //対象ユーザーの投稿一覧を取得
    $statuses = $this->db_manager->get('Status')
      ->fetchAllPersonalArchivesByUserId($user['id']);
    $following = null;
    if ($this->session->isAuthenticated()) {
      $my = $this->session->get('user');

      //自分自身のフォローは表示しないようにする
      //外部からのデータ（ユーザー名）が自分のものではなかったら。フォロー情報の取得（存在してるかTRUE or FALSE）
      if ($my['id'] !== $user['id']) {
        $following = $this->db_manager
          ->get('Following')
          ->isFollowing($my['id'], $user['id']); //フォローしている値を抽出
      }
    }

    $user_status = $this->db_manager->get('Status')
      ->fetchAllPersonalArchivesByUserId($user['id']);

    return $this->render(array(
      'user' => $user,
      'statuses' => $statuses,
      'following' => $following,
      '_token' => $this->generateCsrfToken('account/follow'),
      'follower' => $follower,
      'follow' => $follow,
      'user_status' => $user_status,

    ));
  }
  public function showAction($params)
  {
    //外部からんデータ（$param）を元に投稿情報を取得
    $status = $this->db_manager->get('Status')
      ->fetchByIdAndUserName($params['id'], $params['user_name']);

    if (!$status) {
      $this->forward404();
    }
    return $this->render(array('status' => $status));
  }

  public function usersAction()
  {

    $users = $this->db_manager->get('Status')
      ->fetchByusername();

    if (!$users) {
      $this->forward404();
    }
    return $this->render(array('users' => $users));
  }
  // 修正箇所-----------------------------------------------------------------------
  public function followAction($params)
  {

    $follower_name = $this->db_manager->get('Status')
      ->fetchByFollower($params['id'], $params[1]);
    return $this->render(array('follower_name' => $follower_name, 'params' => $params));
  }
}
