<?php
declare(strict_types=1);

namespace Repository;

require_once __DIR__ . '/../Core/database/Database.php';

use database\Database;
use PDO;

final class AdmindashRepo
{
    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
     

    // UI cards

    public function count_table(string $key): int
    {

        $map = [
            'admins'     => ['table' => 'admin',       'id' => 'admin_id'],
            'admin'      => ['table' => 'admin',       'id' => 'admin_id'],

            'teachers'   => ['table' => 'teachers',    'id' => 'teacher_id'],
            'students'   => ['table' => 'students',    'id' => 'student_id'],
            'parents'    => ['table' => 'parents',     'id' => 'parent_id'],

            'classes'    => ['table' => 'classes',     'id' => 'class_id'],
            'courses'    => ['table' => 'courses',     'id' => 'course_id'],

            'times'      => ['table' => 'time_slots',  'id' => 'time_id'],
            'time_slots' => ['table' => 'time_slots',  'id' => 'time_id'],

            'schedule'   => ['table' => 'schedule',    'id' => 'schedule_id'],
        ];

        if (!isset($map[$key])) {
            return 0;
        }

        $table = $map[$key]['table'];
        $idCol = $map[$key]['id'];

        $sql = "SELECT COUNT($idCol) AS c FROM $table";

        try {
            $stmt = $this->conn->query($sql);
            $row  = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
            return (int)($row['c'] ?? 0);
        } catch (\PDOException $e) {
            return 0;
        }
    }

    //User management
    public function list_admins_repo(int $limit = 50): array
    {
        $limit = max(1, min(200, $limit));

        $sql = "
            SELECT
                admin_id,
                CONCAT(admin_firstname, ' ', admin_lastname) AS username,
                email,
                '' AS created_at
            FROM admin
            ORDER BY admin_id DESC
            LIMIT $limit
        ";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function list_teachers_repo(int $limit = 50): array
    {
        $limit = max(1, min(200, $limit));

        $sql = "
            SELECT
                t.teacher_id,
                t.first_name,
                t.last_name,
                t.email,
                t.phone,
                COALESCE(u.created_at, '') AS created_at
            FROM teachers t
            LEFT JOIN users u ON u.user_id = t.user_id
            ORDER BY t.teacher_id DESC
            LIMIT $limit
        ";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function list_students_repo(int $limit = 50): array
    {
        $limit = max(1, min(200, $limit));

        $sql = "
            SELECT
                student_id,
                first_name,
                last_name,
                email,
                phone,
                class_id,
                '' AS created_at
            FROM students
            ORDER BY student_id DESC
            LIMIT $limit
        ";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function list_parents_repo(int $limit = 50): array
    {
        $limit = max(1, min(200, $limit));

        $sql = "
            SELECT
                parent_id,
                first_name,
                last_name,
                email,
                phone,
                '' AS created_at
            FROM parents
            ORDER BY parent_id DESC
            LIMIT $limit
        ";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $e) {
            return [];
        }
    }

   //Classes and courses
    public function list_classes_repo(): array
    {
        $sql = "
            SELECT class_id, class_name
            FROM classes
            ORDER BY class_id ASC
        ";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function class_id_by_name_repo(string $class_name): ?int
    {
        $sql = "SELECT class_id FROM classes WHERE class_name = :class_name LIMIT 1";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':class_name', $class_name, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return isset($row['class_id']) ? (int)$row['class_id'] : null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function list_teachers_basic_repo(): array
    {
        $sql = "
            SELECT teacher_id, first_name, last_name
            FROM teachers
            ORDER BY last_name ASC, first_name ASC
        ";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function course_details_per_class_repo(int $class_id): array
    {
        $sql = "
            SELECT
                c.course_id,
                c.course_code,
                c.course_name,
                c.coefficient,
                c.description,
                c.class_id,
                c.teacher_id,
                CONCAT(t.last_name, ' ', t.first_name) AS teacher_fullname
            FROM courses c
            INNER JOIN teachers t ON c.teacher_id = t.teacher_id
            WHERE c.class_id = :class_id
            ORDER BY c.course_id ASC
        ";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function create_course_repo(array $payload): bool
    {
        $sql = "
            INSERT INTO courses (course_code, course_name, coefficient, description, class_id, teacher_id)
            VALUES (:course_code, :course_name, :coefficient, :description, :class_id, :teacher_id)
        ";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':course_code', (string)($payload['course_code'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':course_name', (string)($payload['course_name'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':coefficient', (string)($payload['coefficient'] ?? '1'), PDO::PARAM_STR);
            $stmt->bindValue(':description', (string)($payload['description'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':class_id', (int)($payload['class_id'] ?? 0), PDO::PARAM_INT);
            $stmt->bindValue(':teacher_id', (int)($payload['teacher_id'] ?? 0), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function update_course_repo(int $course_id, array $payload): bool
    {
        $sql = "
            UPDATE courses
            SET course_code = :course_code,
                course_name = :course_name,
                coefficient = :coefficient,
                description = :description,
                class_id    = :class_id,
                teacher_id  = :teacher_id
            WHERE course_id = :course_id
            LIMIT 1
        ";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);
            $stmt->bindValue(':course_code', (string)($payload['course_code'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':course_name', (string)($payload['course_name'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':coefficient', (string)($payload['coefficient'] ?? '1'), PDO::PARAM_STR);
            $stmt->bindValue(':description', (string)($payload['description'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':class_id', (int)($payload['class_id'] ?? 0), PDO::PARAM_INT);
            $stmt->bindValue(':teacher_id', (int)($payload['teacher_id'] ?? 0), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete_course_repo(int $course_id): bool
    {
        $sql = "DELETE FROM courses WHERE course_id = :course_id LIMIT 1";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    //Time slots , Schedule
    public function list_days_repo(): array
{
    $sql_query = "
        SELECT time_id, start_time, end_time
        FROM time_slots
        ORDER BY start_time ASC
    ";

    try {
        $stmt = $this->conn->query($sql_query);
        return $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    } catch (\PDOException $exception_instance) {
        return [];
    }
}

    public function schedule_rows_by_class_id_repo(int $class_id): array
{
    $sql_query = "
        SELECT 
            s.schedule_id,
            s.class_id,
            s.time_id,
            s.day_id,
            d.day_name,
            s.course_id,
            c.course_name,
            c.course_code,
            CONCAT(t.last_name, ' ', t.first_name) AS teacher_fullname
        FROM schedule s
        INNER JOIN days d     ON s.day_id = d.day_id
        INNER JOIN courses c  ON s.course_id = c.course_id
        INNER JOIN teachers t ON c.teacher_id = t.teacher_id
        WHERE s.class_id = :class_id
        ORDER BY s.time_id ASC, s.day_id ASC, s.schedule_id ASC
    ";

    try {
        $query_stmt = $this->conn->prepare($sql_query);
        $query_stmt->bindValue(':class_id', $class_id, \PDO::PARAM_INT);
        $query_stmt->execute();
        return $query_stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $exception_instance) {
        return [];
    }
}

public function upsert_schedule_cell_repo(int $class_id, int $time_id, int $day_id, int $course_id): bool
{
    $update_sql = "
        UPDATE schedule
        SET course_id = :course_id
        WHERE class_id = :class_id
          AND time_id  = :time_id
          AND day_id   = :day_id
        LIMIT 1
    ";

    try {
        $update_stmt = $this->conn->prepare($update_sql);
        $update_stmt->bindValue(':course_id', $course_id, \PDO::PARAM_INT);
        $update_stmt->bindValue(':class_id', $class_id, \PDO::PARAM_INT);
        $update_stmt->bindValue(':time_id', $time_id, \PDO::PARAM_INT);
        $update_stmt->bindValue(':day_id', $day_id, \PDO::PARAM_INT);
        $update_stmt->execute();

        if ($update_stmt->rowCount() > 0) {
            return true;
        }

        $insert_sql = "
            INSERT INTO schedule (class_id, time_id, day_id, course_id)
            VALUES (:class_id, :time_id, :day_id, :course_id)
        ";

        $insert_stmt = $this->conn->prepare($insert_sql);
        $insert_stmt->bindValue(':class_id', $class_id, \PDO::PARAM_INT);
        $insert_stmt->bindValue(':time_id', $time_id, \PDO::PARAM_INT);
        $insert_stmt->bindValue(':day_id', $day_id, \PDO::PARAM_INT);
        $insert_stmt->bindValue(':course_id', $course_id, \PDO::PARAM_INT);

        return $insert_stmt->execute();
    } catch (\PDOException $exception_instance) {
        return false;
    }
}

public function delete_schedule_cell_repo(int $class_id, int $time_id, int $day_id): bool
{
    $sql_query = "
        DELETE FROM schedule
        WHERE class_id = :class_id
          AND time_id  = :time_id
          AND day_id   = :day_id
        LIMIT 1
    ";

    try {
        $query_stmt = $this->conn->prepare($sql_query);
        $query_stmt->bindValue(':class_id', $class_id, \PDO::PARAM_INT);
        $query_stmt->bindValue(':time_id', $time_id, \PDO::PARAM_INT);
        $query_stmt->bindValue(':day_id', $day_id, \PDO::PARAM_INT);
        return $query_stmt->execute();
    } catch (\PDOException $exception_instance) {
        return false;
    }
}

    //Students CRUD
    public function create_student_repo(array $payload): bool
    {
        $sql = "
            INSERT INTO students (first_name, last_name, email, phone, class_id)
            VALUES (:first_name, :last_name, :email, :phone, :class_id)
        ";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':first_name', (string)($payload['first_name'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':last_name',  (string)($payload['last_name'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':email',      (string)($payload['email'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':phone',      (string)($payload['phone'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':class_id',   (int)($payload['class_id'] ?? 0), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function update_student_repo(int $student_id, array $payload): bool
    {
        $sql = "
            UPDATE students
            SET first_name = :first_name,
                last_name  = :last_name,
                email      = :email,
                phone      = :phone,
                class_id   = :class_id
            WHERE student_id = :student_id
            LIMIT 1
        ";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
            $stmt->bindValue(':first_name', (string)($payload['first_name'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':last_name',  (string)($payload['last_name'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':email',      (string)($payload['email'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':phone',      (string)($payload['phone'] ?? ''), PDO::PARAM_STR);
            $stmt->bindValue(':class_id',   (int)($payload['class_id'] ?? 0), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete_student_repo(int $student_id): bool
    {
        $sql = "DELETE FROM students WHERE student_id = :student_id LIMIT 1";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}