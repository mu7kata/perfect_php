<?php
class FollowingRepository extends DbRepository
{

  public function insert($user_id, $following_id)
  {
    $sql = "INSERT INTO following VALUES(:user_id,:following_id)";

    $stmt = $this->execute($sql, array(
      ':user_id' => $user_id,
      'following_id' => $following_id,
    ));
  }

  public function isFollowing($user_id, $following_id)
  {
    $sql = "
    SELECT COUNT(user_id)as count
    FROM following
    WHERE user_id = :user_id
    AND following_id = :following_id
    ";

    $row = $this->fetch($sql, array(
      ':user_id' => $user_id,
      ':following_id' => $following_id,
    ));
    if ($row['count'] !== '0') {
      return $row['count'];
    }

    return false;
  }
  public function Follower($user_id)
  {
    $sql = "select count(following_id) from following where user_id=:user_id";

    return $this->fetchall($sql, array(
      ':user_id' => $user_id,
    ));
  }
  public function Follow($user_id)
  {
    $sql =  "select count(user_id) from following where following_id=:user_id";

    return $this->fetchall($sql, array(
      ':user_id' => $user_id,
    ));
  }

}
