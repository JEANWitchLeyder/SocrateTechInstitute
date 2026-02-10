<?php
namespace database;

use PDO;

use PDOException;

class Database{
    private string $dbhost = DB_HOST;
    private string $dbname = DB_NAME;
    private string $dbuser = DB_USER;
    private string $dbpass = DB_PASS;
    private string $dbcharset = DB_CHARSET;
    private string $dbport = DB_PORT;

    public ?PDO $conn  = null;


    public function getConnection() : PDO{
        try{
            $dsn = "mysql:host={$this->dbhost};
                          port={$this->dbport};
                          dbname={$this->dbname};
                          charset={$this->dbcharset};
            ";
            $this->conn = new PDO(
              $dsn,
              $this->dbuser,
              $this->dbpass,
              [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO:: ATTR_EMULATE_PREPARES => false
              ]
            );

            return $this->conn;
        }catch(PDOException $e){
            die("DB Error " . $e->getMessage());
         }
    }
}
?>