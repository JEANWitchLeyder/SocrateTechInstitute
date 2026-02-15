<?php 
namespace Repository;

require_once __DIR__ . '/../Core/database/Database.php';

use database\Database;

use PDO;

class AuthRepository{
    private $table = "users";

    private PDO $conn;


    public function __construct(){
        $db = new Database();

        $this->conn = $db->getConnection();
    }
    public function register_repo($username, $email, $password, $role){
      $query = "INSERT INTO users(username, email, password, role)
                VALUES(:username, :email, :password, :role)";
   
      $stmt = $this->conn->prepare($query);
   
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', $password);
      $stmt->bindValue(':role', $role);
   
      return $stmt->execute();
   }
   

    public function login_repo($username){
      $query = "SELECT user_id,username,password FROM users WHERE username = :username LIMIT 1";
      $stmt = $this->conn->prepare($query);
      $stmt -> bindValue(':username',$username);

      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}









?>