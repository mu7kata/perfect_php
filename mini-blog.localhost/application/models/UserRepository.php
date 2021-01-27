<?php

//userテーブルを操作するクラス
class UserRepository extends DbRepository
{
  public function insert($user_name, $password)
  {
    $password = $this->hashPassword($password);
    $now = new Datetime(); //現在時刻を表すオブジェクト

    $sql = "INSERT INTO user(user_name,password,created_at) VALUES(:user_name,:password,:created_at)";

    $stmt = $this->execute($sql, array(
      ':user_name' => $user_name,
      ':password' => $password,
      ':created_at' => $now->format('Y-m-d H:i:s'),
    ));
  }

  public function hashPassword($password)
  {
    return sha1($password . 'SecretKey');
  }

  //ユーザーIDを元にユーザー情報を取得
  public function fetchByUserName($user_name)
  {
    $sql = "SELECT * FROM user WHERE user_name =:user_name";

    //fetch()・・・
    return $this->fetch($sql, array(':user_name' => $user_name));
  }

  //ユーザーIDを元にレコード（行）件数を取得、ユーザー情報の存在を確認するためのメソッド？
  public function isUniqueUserName($user_name)
  {
    $sql = "SELECT COUNT(id) as count FROM user WHERE user_name = :user_name ";
    $row = $this->fetch($sql, array(':user_name' => $user_name));
    if ($row['count'] === '0') {
      return true;
    }
    return false;
  }
  // 修正箇所-----------------------------------------------------------------------
  public function fetchAllFollowingsByUserId($user_id)
  {
    $sql = "
          SELECT u.*
              FROM user u
                  LEFT JOIN following f ON f.following_id = u.id
              WHERE f.user_id = :user_id
      ";

    return $this->fetchAll($sql, array(':user_id' => $user_id));
  }

  public function update($user_name, $edit_name, $edit_image)
  {
    $sql = "
    update user set 
    user_name= :edit_name,
    icon=:edit_image 
    where user_name=:user_name;
    ";


    $stmt = $this->fetchAll(
      $sql,
      array(
        ':edit_name' => $edit_name,
        ':edit_image' => $edit_image,

        
        ':user_name' => $user_name,
      )
    );

    if ($stmt) {
      $maru = '成功';
      return  $maru;
    } else {
      $maru = '失敗';
    }
    return  $maru; 
  }
}
