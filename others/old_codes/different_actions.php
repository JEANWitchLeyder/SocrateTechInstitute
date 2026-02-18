
<?php
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
  //add_course


  $course_name = trim($_POST['course_name'] ?? '');
  $coefficient = (int)($_POST['coefficient'] ?? 0);
  $description = trim($_POST['description'] ?? '');
  $class_id    = (int)($_POST['class_id'] ?? 0);
  $teacher_id  = (int)($_POST['teacher_id'] ?? 0);

  if ($course_name === '' || $coefficient <= 0 || $class_id <= 0 || $teacher_id <= 0) {
    $courseError = "Please fill all course fields correctly.";
  } else {
    $sql = "INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
                VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'sisii', $course_name, $coefficient, $description, $class_id, $teacher_id);

    if (mysqli_stmt_execute($stmt)) {
      $course_id   = mysqli_insert_id($connect);
      $course_code = strtoupper(substr($course_name, 0, 3)) . $course_id;

      $sql2  = "UPDATE courses SET course_code = ? WHERE course_id = ?";
      $stmt2 = mysqli_prepare($connect, $sql2);
      mysqli_stmt_bind_param($stmt2, 'si', $course_code, $course_id);
      mysqli_stmt_execute($stmt2);

      $courseAdded     = true;
      $successMessage  = "The course has been added successfully.";
    } else {
      $courseError = "Database error while adding course.";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {

  //edit_course
  $course_id   = (int)($_POST['course_id'] ?? 0);
  $course_name = trim($_POST['course_name'] ?? '');
  $coefficient = (int)($_POST['coefficient'] ?? 0);
  $description = trim($_POST['description'] ?? '');
  $class_id    = (int)($_POST['class_id'] ?? 0);
  $teacher_id  = (int)($_POST['teacher_id'] ?? 0);

  if ($course_id <= 0 || $course_name === '' || $coefficient <= 0 || $class_id <= 0 || $teacher_id <= 0) {
    $courseError = "Please fill all course fields correctly.";
  } else {
    $sql = "UPDATE courses
                SET course_name = ?, coefficient = ?, description = ?, class_id = ?, teacher_id = ?
                WHERE course_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param(
      $stmt,
      'sisiii',
      $course_name,
      $coefficient,
      $description,
      $class_id,
      $teacher_id,
      $course_id
    );

    if (mysqli_stmt_execute($stmt)) {
      $courseEdited    = true;
      $successMessage  = "The course has been updated successfully.";

      $course_code = strtoupper(substr($course_name, 0, 3)) . $course_id;
      $stmt2 = mysqli_prepare($connect, "UPDATE courses SET course_code = ? WHERE course_id = ?");
      mysqli_stmt_bind_param($stmt2, 'si', $course_code, $course_id);
      mysqli_stmt_execute($stmt2);
    } else {
      $courseError = "Database error while updating course.";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_course'])) {
  //delete_course

  $course_id = (int)($_POST['course_id'] ?? 0);
  if ($course_id > 0) {
    $stmt = mysqli_prepare($connect, "DELETE FROM courses WHERE course_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $course_id);
    if (mysqli_stmt_execute($stmt)) {
      $courseDeleted   = true;
      $successMessage  = "The course has been deleted successfully.";
    } else {
      $courseError = "Database error while deleting course.";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
  //add_student
  $first_name        = trim($_POST['first_name'] ?? '');
  $last_name         = trim($_POST['last_name'] ?? '');
  $class_id          = (int)($_POST['class_id'] ?? 0);
  $gender_id         = (int)($_POST['gender_id'] ?? 0);
  $phone             = trim($_POST['phone'] ?? '');
  $email             = trim($_POST['email'] ?? '');
  $place_of_birth    = trim($_POST['place_of_birth'] ?? '');
  $address           = trim($_POST['address'] ?? '');
  $date_of_birth_raw = trim($_POST['date_of_birth'] ?? '');

  if ($date_of_birth_raw === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_birth_raw)) {
    $date_of_birth = null;
  } else {
    $date_of_birth = $date_of_birth_raw;
  }

  if ($first_name === '' || $last_name === '' || $class_id <= 0 || $gender_id <= 0) {
    $studentError = "Please fill all required fields for the student.";
  } else {

    $sql = "
          INSERT INTO students 
              (first_name, last_name, class_id, date_of_birth, gender_id, phone, email, place_of_birth, address)
          VALUES 
              (?, ?, ?, ?, ?, ?, ?, ?, ?)
      ";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param(
      $stmt,
      'ssisissss',
      $first_name,
      $last_name,
      $class_id,
      $date_of_birth,
      $gender_id,
      $phone,
      $email,
      $place_of_birth,
      $address
    );

    if (mysqli_stmt_execute($stmt)) {
      $studentAdded   = true;
      $successMessage = "The student has been added successfully.";
    } else {
      $studentError   = "Database error while adding student: " . mysqli_error($connect);
    }
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student'])) {
  //edit_student
  $student_id        = (int)($_POST['student_id'] ?? 0);
  $first_name        = trim($_POST['first_name'] ?? '');
  $last_name         = trim($_POST['last_name'] ?? '');
  $class_id          = (int)($_POST['class_id'] ?? 0);
  $gender_id         = (int)($_POST['gender_id'] ?? 0);
  $phone             = trim($_POST['phone'] ?? '');
  $email             = trim($_POST['email'] ?? '');
  $place_of_birth    = trim($_POST['place_of_birth'] ?? '');
  $address           = trim($_POST['address'] ?? '');
  $date_of_birth_raw = trim($_POST['date_of_birth'] ?? '');

  if ($date_of_birth_raw === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_birth_raw)) {
    $date_of_birth = null;
  } else {
    $date_of_birth = $date_of_birth_raw;
  }

  if ($student_id <= 0 || $first_name === '' || $last_name === '' || $class_id <= 0 || $gender_id <= 0) {
    $studentError = "Please fill all required fields for the student.";
  } else {

    $sql = "
          UPDATE students
             SET first_name     = ?,
                 last_name      = ?,
                 class_id       = ?,
                 date_of_birth  = ?,
                 gender_id      = ?,
                 phone          = ?,
                 email          = ?,
                 place_of_birth = ?,
                 address        = ?
           WHERE student_id     = ?
      ";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param(
      $stmt,
      'ssisissssi',
      $first_name,
      $last_name,
      $class_id,
      $date_of_birth,
      $gender_id,
      $phone,
      $email,
      $place_of_birth,
      $address,
      $student_id
    );

    if (mysqli_stmt_execute($stmt)) {
      $studentEdited   = true;
      $successMessage  = "The student has been updated successfully.";
    } else {
      $studentError = "Database error while updating student: " . mysqli_error($connect);
    }
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
  //delete_student
  $student_id = (int)($_POST['student_id'] ?? 0);

  if ($student_id <= 0) {
    $studentError = "Invalid student selected for deletion.";
  } else {
    $sql = "DELETE FROM students WHERE student_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);

    if (mysqli_stmt_execute($stmt)) {
      $studentDeleted   = true;
      $successMessage   = "The student has been deleted successfully.";
    } else {
      $studentError = "Database error while deleting student: " . mysqli_error($connect);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
  //edit_user
  $userType = $_POST['user_type'] ?? '';
  $userId   = (int)($_POST['user_id'] ?? 0);
  $email    = trim($_POST['email'] ?? '');

  if ($userId <= 0 || $userType === '' || $email === '') {
    $userError = "User type, id and email are required.";
  } else {
    switch ($userType) {
      case 'admins':
        $sql = "UPDATE admin SET email = ? WHERE admin_id = ?";
        break;
      case 'teachers':
        $sql = "UPDATE teachers SET email = ? WHERE teacher_id = ?";
        break;
      case 'parents':
        $sql = "UPDATE parents SET email = ? WHERE parent_id = ?";
        break;
      case 'students':
        $sql = "UPDATE students SET email = ? WHERE student_id = ?";
        break;
      default:
        $sql = '';
    }

    if ($sql !== '') {
      $stmt = mysqli_prepare($connect, $sql);
      mysqli_stmt_bind_param($stmt, 'si', $email, $userId);
      if (mysqli_stmt_execute($stmt)) {
        $userEdited     = true;
        $successMessage = "The user email has been updated.";
      } else {
        $userError = "Database error while updating user.";
      }
    } else {
      $userError = "Unknown user type.";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
  //delete_user
  $userType = $_POST['user_type'] ?? '';
  $userId   = (int)($_POST['user_id'] ?? 0);

  if ($userId <= 0 || $userType === '') {
    $userError = "User type and id are required.";
  } else {
    switch ($userType) {
      case 'admins':
        $sql = "DELETE FROM admin WHERE admin_id = ?";
        break;
      case 'teachers':
        $sql = "DELETE FROM teachers WHERE teacher_id = ?";
        break;
      case 'parents':
        $sql = "DELETE FROM parents WHERE parent_id = ?";
        break;
      case 'students':
        $sql = "DELETE FROM students WHERE student_id = ?";
        break;
      default:
        $sql = '';
    }

    if ($sql !== '') {
      $stmt = mysqli_prepare($connect, $sql);
      mysqli_stmt_bind_param($stmt, 'i', $userId);
      if (mysqli_stmt_execute($stmt)) {
        $userDeleted    = true;
        $successMessage = "The user has been deleted.";
      } else {
        $userError = "Database error while deleting user.";
      }
    } else {
      $userError = "Unknown user type.";
    }
  }
}