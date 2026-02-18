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



     public function schedule_per_class_repo(string $className): array
     {
     $sql = "
        SELECT 
            d.day AS day_name,
            t.time_id AS time_id,
            t.start_time AS start_time,
            t.end_time AS end_time,
            c.course_name AS course_name
        FROM days d
        CROSS JOIN time_slots t
        LEFT JOIN schedule s
            ON s.day_id = d.day_id
            AND s.time_id = t.time_id
        LEFT JOIN classes cl
            ON cl.class_id = s.class_id
            AND cl.class_name = :class_name
        LEFT JOIN courses c
            ON c.course_id = s.course_id
        ORDER BY t.start_time, d.day_id
     ";

     $stmt = $this->conn->prepare($sql);
     $stmt->bindValue(':class_name', $className, PDO::PARAM_STR);
     $stmt->execute();

     return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


     public function students_details_per_class_repo($classId){
        $sql = "
        SELECT
            s.student_id,
            s.first_name,
            s.last_name,
            s.class_id,
            s.gender_id,
            c.class_name AS grade_level,
            s.date_of_birth,
            g.gender_name,
            s.phone,
            s.email,
            s.place_of_birth,
            s.address,
            TIMESTAMPDIFF(YEAR, s.date_of_birth, CURDATE()) AS age
        FROM students s
        INNER JOIN classes c 
            ON c.class_id = s.class_id
        INNER JOIN gender g 
            ON g.gender_id = s.gender_id
        WHERE s.class_id = ?
        ORDER BY s.student_id
    ";
  
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':class_id',$classId,PDO::PARAM_INT);
    $stmt->execute();

     return $stmt->fetchAll(\PDO::FETCH_ASSOC);

  
     }

     public function basic_info_per_class_repo(int $classId){
        $sql = "
        SELECT class_name, classroom, start_academic_year, end_academic_year, capacity
        FROM classes
        WHERE class_id = ?
        LIMIT 1
    ";
  $stmt = $this->conn->prepare($sql);
  $stmt->bindValue(':class_id',$classId,PDO::PARAM_INT);
  $stmt->execute();

  $class_row =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
 

   if(!$class_row){
    return null;
   }


  $classIdValue = $classId;

  $sqlCount = "
        SELECT
          (SELECT COUNT(*) FROM students WHERE class_id = ?) AS nb_students,
          (SELECT COUNT(DISTINCT teacher_id) FROM courses WHERE class_id = ?) AS nb_teachers,
          (SELECT COUNT(*) FROM courses WHERE class_id = ?) AS nb_courses
    ";

    $stmt2 = $this->conn->prepare($sqlCount);
    $stmt2->bindValue(':class_id',$classId,PDO::PARAM_INT);
    $stmt2->execute();
   
    $countRow = $stmt2->fetch(PDO::FETCH_ASSOC) ?: [
        'nb_students' => 0,
        'nb_teachers' => 0,
        'nb_courses'  => 0,
    ];

return array_merge($class_row,$countRow);
}

}

?>