<?php

class StatusRepository extends DbRepository
{

  //投稿された情報を保存する
  public function insert($user_id, $body)
  {
    $now = new DateTime();
    $sql = "
       INSERT INTO status(user_id, body, created_at)
       VALUES(:user_id, :body, :created_at)
       ";

    $stmt = $this->execute($sql, array(
      ':user_id' => $user_id,
      ':body'    => $body,
      ':created_at' => $now->format('Y-m-d H:i:s'),
    ));
  }

  //指定したユーザー情報の取得（ログインしているユーザー情報用）
  public function fetchAllPersonalArchivesByUserId($user_id)
  {
    $sql = "
        SELECT a.*,u.user_name,u.icon
        FROM status  a
        LEFT JOIN user u ON a.user_id = u.id
        WHERE u.id = :user_id
        ORDER BY a.created_at DESC
        ";
    return $this->fetchAll($sql, array(':user_id' => $user_id));
  }

  //フォローしているひとと自分のユーザー情報を取得（タイムライン用）
  public function fetchAllByUserId($user_id)
  {
    $sql = "
         SELECT a.*, u.user_name,u.icon
         FROM status a
         LEFT JOIN user u ON a.user_id = u.id
         LEFT JOIN following f ON f.following_id = a.user_id
         AND f.user_id = :user_id
         WHERE f.user_id = :user_id OR u.id = :user_id
         ORDER BY a.created_at DESC
         ";
    return $this->fetchall($sql, array(
      ':user_id' => $user_id,
    ));
  }

  //指定した投稿の詳細をみる
  public function fetchByIdAndUserName($id, $user_name)
  {
    $sql = "
        SELECT a.*,u.user_name
        FROM status a
        LEFT JOIN user u ON u.id = a.user_id
        where a.id = :id
        AND u.user_name = :user_name
        ";
    return $this->fetch($sql, array(
      ':id' => $id,
      'user_name' => $user_name,
    ));
  }
  // 修正箇所-----------------------------------------------------------------------
  public function fetchByusername()
  {

    $sql = "select user_name,icon from user
  ";
    return $this->fetchAll($sql);
  }

  public function fetchByFollower($user_id, $param)
  {

    if ($param !== 'to') {
      //フォローされてる人を表示
      $sql = "SELECT user.user_name
      FROM  user
      LEFT JOIN following ON following.following_id = user.id
      where following.user_id=$user_id";
    } else {
      //フォローしている人を表示
      $sql = "SELECT user.user_name
      FROM  user
      LEFT JOIN following ON following.user_id = user.id
      where following.following_id=$user_id";
    }
    return $this->fetchAll($sql);
  }
}
// SELECT a.*, u.user_name
// FROM status  a
// LEFT JOIN user  u ON a.user_id = u.id
// LEFT JOIN following f ON f.following_id = a.user_id
// AND f.user_id = 9
// WHERE f.user_id = 9 OR u.id = 9
// ORDER BY a.created_at DESC

// SELECT a.*,u.user_name
//         FROM status a
//         LEFT JOIN user u ON u.id = a.user_id
//         where a.id = 8
//         AND u.user_name = 12345