<?php
namespace Loadwave\App;
use Loadwave\App\Library;
require __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';

class Model
{

    protected $connection;

    function __construct($db = 'mysql')
    {
        $dsn = $db . ":dbname=" . BASE . ";host=" . SERVER . ";charset=UTF8";
        $connection = new \PDO($dsn, USER, PASS);
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $this->connection = $connection;
    }

//Videos
    public function getVideos($search = null)
    {
        if ($search == null) {
            $ask_for = "SELECT COUNT(*) AS theCount, video_id FROM comments GROUP BY video_id ORDER BY theCount DESC LIMIT 10;";
            $sql = $this->connection->prepare($ask_for);
            $sql->execute();
            return $sql->fetchAll();
        } else {
            $ask_for = "SELECT video_id, video_time, seconds, GROUP_CONCAT(content,'&likes:',likes SEPARATOR '&ldwav,')
			 				AS comments FROM comments WHERE content LIKE :search GROUP BY video_id, video_time ORDER BY likes DESC LIMIT 10;";
            $values = array("search" => "%{$search}%");
            $sql = $this->connection->prepare($ask_for);
            $sql->execute($values);
            return $sql->fetchAll();
        }

    }

//Comments
    public function getComments($id, $time, $offset, $limit, $user_id)
    {
        $compare = Library::sumTheTime($time, "00:00:" . $offset);
        $time = Library::sumTheTime($time, "00:00:00");
        $ask_for = "SELECT a.*, (SELECT COUNT(*) FROM user_like b WHERE b.user_id = :user_id AND b.comment_id = a.id) liked FROM comments a
                    WHERE a.video_id = :id AND a.video_time < :compare AND (a.video_time > :time OR a.video_time = :time) ORDER BY a.likes DESC, a.created_at DESC LIMIT :limit;";
        echo $ask_for; exit;
        $sql = $this->connection->prepare($ask_for);
        $sql->bindValue(":user_id", $user_id, \PDO::PARAM_INT);
        $sql->bindValue(":id", $id, \PDO::PARAM_INT);
        $sql->bindValue(":compare", $compare, \PDO::PARAM_STR);
        $sql->bindValue(":time", $time, \PDO::PARAM_STR);
        $sql->bindValue(":limit", $limit, \PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function addComment($values)
    {
        $query = "INSERT INTO comments (video_id, content, likes, created_at, video_time, seconds, username)
					VALUES (:video_id, :content, :likes, :created_at, :video_time, :seconds, :username);";
        $sql = $this->connection->prepare($query);
        $sql->execute($values);
        return $this->connection->lastInsertId();
    }

    public function addLike($comment_id, $user_id)
    {
        $query = "INSERT INTO user_like (user_id, comment_id) VALUES (:user_id, :comment_id);";
        $sql = $this->connection->prepare($query);
        $values = array('user_id' => $user_id, 'comment_id' => $comment_id);
        $sql->execute($values);
    }

    public function incrLike($comment_id, $user_id)
    {
        $ask_for = "UPDATE comments SET likes=likes+1 WHERE id = :comment_id;";
        $values = array("comment_id" => $comment_id);
        $sql = $this->connection->prepare($ask_for);
        $sql->execute($values);
        $ask_for = "UPDATE users SET likes=likes+1 WHERE id = :user_id;";
        $values = array("user_id" => $user_id);
        $sql = $this->connection->prepare($ask_for);
        $sql->execute($values);
    }

//User
    public function getUser($post)
    {
        if (is_array($post)) {
            $values = array("email" => $post['email']);
            $ask_for = "SELECT * FROM users WHERE email = :email;";
        } else {
            $values = array("id" => $post);
            $ask_for = "SELECT * FROM users WHERE id = :id;";
        }
        $sql = $this->connection->prepare($ask_for);
        $sql->execute($values);
        return $sql->fetch();
    }

    public function setUser($post)
    {
        $query = "INSERT INTO users (email, username, password, firstname, lastname, gender, country, birthday, likes, joined_at, hash, confirmed)
 					VALUES (:email, :username, :password, :firstname, :lastname, :gender, :country, :birthday, :likes, :joined_at, :hash, :confirmed);";
        $sql = $this->connection->prepare($query);
        $sql->execute($post);
        return $this->connection->lastInsertId();
    }

    public function confirmUser($id)
    {
        $values = array("id" => $id, "confirmed" => true);
        $ask_for = "UPDATE users SET confirmed=:confirmed WHERE id = :id;";
        $sql = $this->connection->prepare($ask_for);
        $sql->execute($values);
    }

    public function deleteUser($id)
    {
        $values = array("id" => $id);
        $ask_for = "DELETE FROM users WHERE id = :id;";
        $sql = $this->connection->prepare($ask_for);
        $sql->execute($values);
    }

//Session
    public function getSession($hash)
    {
        $values = array("hash" => $hash);
        $ask_for = "SELECT * FROM user_auth WHERE hash = :hash;";
        $sql = $this->connection->prepare($ask_for);
        $sql->execute($values);
        return $sql->fetch();
    }

    public function addSession($values)
    {
        $query = "INSERT INTO user_auth (user_id, username, hash, init_date, expire_date, confirmed, limit_date)
		 			VALUES (:user_id, :username, :hash, :init_date, :expire_date, :confirmed, :limit_date);";
        $sql = $this->connection->prepare($query);
        $sql->execute($values);
    }

    public function confirmSession($hash)
    {
        $values = array("hash" => $hash, "confirmed" => true);
        $ask_for = "UPDATE user_auth SET confirmed=:confirmed WHERE hash = :hash;";
        $sql = $this->connection->prepare($ask_for);
        $sql->execute($values);
    }

    public function deleteSession($attr)
    {
        if (is_numeric($attr)) {
            $values = array("user_id" => $attr);
            $ask_for = "DELETE FROM user_auth WHERE user_id = :user_id;";
            $sql = $this->connection->prepare($ask_for);
            $sql->execute($values);
        } else {
            $values = array("hash" => $attr);
            $ask_for = "DELETE FROM user_auth WHERE hash = :hash;";
            $sql = $this->connection->prepare($ask_for);
            $sql->execute($values);
        }
    }

//Feedback
    public function sendMessage($values)
    {
        $query = "INSERT INTO feedback (username, message, created_at) VALUES (:username, :message, :created_at);";
        $sql = $this->connection->prepare($query);
        $sql->execute($values);
    }

}

