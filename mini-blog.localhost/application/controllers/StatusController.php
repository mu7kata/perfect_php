<?php
class StatusController extends Controller
{
  protected $auth_actions = array('index', 'post');
  public function indexAction()
  {

    $user = $this->session->get('user');

    $statuses = $this->db_manager->get('Status')
      ->fetchAllPersonalArchivesByUserId($user['id']);

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
    $user = $this->db_manager->get('user')
      ->fetchByUserName($params['user_name']);

    //ユーザーの存在を確認数
    if (!$user) {
      $this->forward404();
    }

    //対象ユーザーの投稿一覧を取得
    $statuses = $this->db_manager->get('Status')
      ->fetchAllByUserId($user['id']);

    $following = null;
    if ($this->session->isAuthenticated()) {
      $my = $this->session->get('user');

      //自分自身のフォローは表示しないようにする
      if ($my['id'] !== $user['id']) {
        $following = $this->db_manager
          ->get('Fllowing')
          ->isFollowing($my['id'], $user['id']);//フォローしている値を抽出
      }
    }

    return $this->render(array(
      'user' => $user,
      'statuses' => $statuses,
      'following' => $following,
       '_token' => $this->generateCsrfToken('account/follow'),
      ));
  }
  public function showAction($params)
  {
    //外部からんデータ（$param）を元に投稿情報を取得
    $status = $this->db_manager->get('Status')
      ->fetchByIdAndUserName($param['id'], $params['user_name']);

    if (!$status) {
      $this->forward404();
    }

    return $this->render(array('status' => $status));
  }
}
