<?php 

namespace Service;


require_once __DIR__ . '/../Repository/AuthRepository.php';

use Repository\AdminRepo;
use Repository\AuthRepository;

class AdmindashService{
    private AdminRepo $user;

    public function __construct(private AdminRepo $repo){}

    public function course_details_per_class_service(int $classId){
     return $this->repo->course_details_per_class_repo($classId);
    }
    
    
    public function schedule_per_class_service(string $className): array
    {
    $rows = $this->repo->schedule_per_class_repo($className);

    $days = [];
    $timeLabels = [];
    $timeMeta = [];
    $map = [];

    foreach ($rows as $r) {
        $day = $r['day_name'];
        $timeId = (int)$r['time_id'];

        $startShort = substr($r['start_time'], 0, 5);
        $endShort   = substr($r['end_time'], 0, 5);
        $label      = $startShort . ' - ' . $endShort;

        if (!in_array($day, $days, true)) {
            $days[] = $day;
        }

        if (!isset($timeLabels[$timeId])) {
            $timeLabels[$timeId] = $label;
            $timeMeta[$timeId] = ['start' => $startShort, 'end' => $endShort];
        }

        if (!empty($r['course_name'])) {
            $map[$timeId][$day] = $r['course_name'];
        }
    }

    return [
        'days' => $days,
        'timeLabels' => $timeLabels,
        'timeMeta' => $timeMeta,
        'map' => $map,
    ];
}

  public function student_per_class_service(int $classId){
    return $this->repo->students_details_per_class_repo($classId);
  }

  public basic_info_per_class_service(int $classId){
    $row = $this->repo->basic_info_per_class_repo($classId);

    if (!$row) {
        return ['found' => false];
    }

    return [
        'found' => true,
        'class_name' => $row['class_name'],
        'classroom'  => $row['classroom'] ?: 'TBD',
        'startY'     => $row['start_academic_year'] ?: 'TBD',
        'endY'       => $row['end_academic_year'] ?: 'TBD',
        'capacity'   => $row['capacity'] ?: 'TBD',
        'nb_students'=> (int)($row['nb_students'] ?? 0),
        'nb_teachers'=> (int)($row['nb_teachers'] ?? 0),
        'nb_courses' => (int)($row['nb_courses']  ?? 0),
    ];
  }

  public function add_course(array $data): array
    {
        $courseName = trim($data['course_name'] ?? '');
        $coefficient = (int)($data['coefficient'] ?? 0);
        $description = trim($data['description'] ?? '');
        $classId = (int)($data['class_id'] ?? 0);
        $teacherId = (int)($data['teacher_id'] ?? 0);

        if ($courseName === '' || $coefficient <= 0 || $classId <= 0 || $teacherId <= 0) {
            return ['success' => false, 'message' => 'Please fill all course fields correctly.'];
        }

        $courseId = $this->repo->insertCourse($courseName, $coefficient, $description, $classId, $teacherId);

        if (!$courseId) {
            return ['success' => false, 'message' => 'Database error while adding course.'];
        }

        $courseCode = strtoupper(substr($courseName, 0, 3)) . $courseId;
        $this->repo->updateCourseCode($courseId, $courseCode);

        return ['success' => true, 'message' => 'The course has been added successfully.'];
    }

    public function edit_course(array $data): array
    {
        $courseId = (int)($data['course_id'] ?? 0);
        $courseName = trim($data['course_name'] ?? '');
        $coefficient = (int)($data['coefficient'] ?? 0);
        $description = trim($data['description'] ?? '');
        $classId = (int)($data['class_id'] ?? 0);
        $teacherId = (int)($data['teacher_id'] ?? 0);

        if ($courseId <= 0 || $courseName === '' || $coefficient <= 0 || $classId <= 0 || $teacherId <= 0) {
            return ['success' => false, 'message' => 'Please fill all course fields correctly.'];
        }

        $updated = $this->repo->updateCourse($courseId, $courseName, $coefficient, $description, $classId, $teacherId);

        if (!$updated) {
            return ['success' => false, 'message' => 'Database error while updating course.'];
        }

        $courseCode = strtoupper(substr($courseName, 0, 3)) . $courseId;
        $this->repo->updateCourseCode($courseId, $courseCode);

        return ['success' => true, 'message' => 'The course has been updated successfully.'];
    }

    public function delete_course(array $data): array
    {
        $courseId = (int)($data['course_id'] ?? 0);

        if ($courseId <= 0) {
            return ['success' => false, 'message' => 'Invalid course selected.'];
        }

        $deleted = $this->repo->deleteCourse($courseId);

        return $deleted
            ? ['success' => true, 'message' => 'The course has been deleted successfully.']
            : ['success' => false, 'message' => 'Database error while deleting course.'];
    }


    public function add_student(array $data): array
    {
        $firstName = trim($data['first_name'] ?? '');
        $lastName = trim($data['last_name'] ?? '');
        $classId = (int)($data['class_id'] ?? 0);
        $genderId = (int)($data['gender_id'] ?? 0);
        $dob = $data['date_of_birth'] ?? null;

        if ($firstName === '' || $lastName === '' || $classId <= 0 || $genderId <= 0) {
            return ['success' => false, 'message' => 'Please fill all required fields.'];
        }

        $inserted = $this->repo->insertStudent($data);

        return $inserted
            ? ['success' => true, 'message' => 'The student has been added successfully.']
            : ['success' => false, 'message' => 'Database error while adding student.'];
    }

    public function edit_student(array $data): array
    {
        $studentId = (int)($data['student_id'] ?? 0);

        if ($studentId <= 0) {
            return ['success' => false, 'message' => 'Invalid student selected.'];
        }

        $updated = $this->repo->updateStudent($studentId, $data);

        return $updated
            ? ['success' => true, 'message' => 'The student has been updated successfully.']
            : ['success' => false, 'message' => 'Database error while updating student.'];
    }

    public function delete_student(array $data): array
    {
        $studentId = (int)($data['student_id'] ?? 0);

        if ($studentId <= 0) {
            return ['success' => false, 'message' => 'Invalid student selected.'];
        }

        $deleted = $this->repo->deleteStudent($studentId);

        return $deleted
            ? ['success' => true, 'message' => 'The student has been deleted successfully.']
            : ['success' => false, 'message' => 'Database error while deleting student.'];
    }


    public function edit_user(array $data): array
    {
        $userType = $data['user_type'] ?? '';
        $userId = (int)($data['user_id'] ?? 0);
        $email = trim($data['email'] ?? '');

        if ($userType === '' || $userId <= 0 || $email === '') {
            return ['success' => false, 'message' => 'Invalid user data.'];
        }

        $updated = $this->repo->updateUserEmail($userType, $userId, $email);

        return $updated
            ? ['success' => true, 'message' => 'The user email has been updated.']
            : ['success' => false, 'message' => 'Database error while updating user.'];
    }

    public function delete_user(array $data): array
    {
        $userType = $data['user_type'] ?? '';
        $userId = (int)($data['user_id'] ?? 0);

        if ($userType === '' || $userId <= 0) {
            return ['success' => false, 'message' => 'Invalid user selected.'];
        }

        $deleted = $this->repo->deleteUser($userType, $userId);

        return $deleted
            ? ['success' => true, 'message' => 'The user has been deleted.']
            : ['success' => false, 'message' => 'Database error while deleting user.'];
    }








}



    







?>