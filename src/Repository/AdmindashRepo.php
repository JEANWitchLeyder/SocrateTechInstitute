<?php 
namespace Repository;

require_once __DIR__ . '/../Core/database/Database.php';

use database\Database;

use PDO;

class AdminRepo{
    
    private $table = "";

    private PDO $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function course_details_per_class_repo(int $classId): array
    {
         $sql = "
            SELECT 
                c.course_id,
                c.course_code,
                c.course_name,
                c.coefficient,
                c.description,
                c.class_id,
                CONCAT(t.last_name, ' ', t.first_name) AS teacher_fullname
            FROM courses c
            INNER JOIN teachers t ON c.teacher_id = t.teacher_id
            WHERE c.class_id = :class_id
            ORDER BY c.course_id ASC
         ";

         $stmt = $this->conn->prepare($sql);
         $stmt->bindValue(':class_id', $classId, PDO::PARAM_INT);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     }

?>