<?php


function renderGenericClassBasicInfo(mysqli $connect, int $classId): void
 {
  //basic_infos_per_class
  $sql = "
        SELECT class_name, classroom, start_academic_year, end_academic_year, capacity
        FROM classes
        WHERE class_id = ?
        LIMIT 1
    ";
  $stmt = mysqli_prepare($connect, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $classId);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = $res ? mysqli_fetch_assoc($res) : null;

  if (!$row) {
    echo "<p>No information for this class yet.</p>";
    return;
  }

  $className = $row['class_name'];
  $room      = $row['classroom'] ?: 'TBD';
  $startY    = $row['start_academic_year'] ?: 'TBD';
  $endY      = $row['end_academic_year'] ?: 'TBD';
  $capacity  = $row['capacity'] ?: 'TBD';

  $classIdValue = $classId;

  $sqlCount = "
        SELECT
          (SELECT COUNT(*) FROM students WHERE class_id = ?) AS nb_students,
          (SELECT COUNT(DISTINCT teacher_id) FROM courses WHERE class_id = ?) AS nb_teachers,
          (SELECT COUNT(*) FROM courses WHERE class_id = ?) AS nb_courses
    ";
  $stmt2 = mysqli_prepare($connect, $sqlCount);
  mysqli_stmt_bind_param($stmt2, 'iii', $classIdValue, $classIdValue, $classIdValue);
  mysqli_stmt_execute($stmt2);
  $counts = mysqli_stmt_get_result($stmt2);
  $countsRow = $counts ? mysqli_fetch_assoc($counts) : ['nb_students' => 0, 'nb_teachers' => 0, 'nb_courses' => 0];

 ?>

  <div class="basic-info-container">
    <div class="basic-info">
      <span><?= h($className) ?></span>
      <h2>Academic Year: <?= h($startY) ?> - <?= h($endY) ?></h2>
      <h2>Classroom #: <?= h($room) ?></h2>
      <h2>Capacity: <?= h($capacity) ?></h2>
      <h2>Number of Students: <?= (int)$countsRow['nb_students'] ?></h2>
      <h2>Number of Teachers: <?= (int)$countsRow['nb_teachers'] ?></h2>
      <h2>Number of Courses: <?= (int)$countsRow['nb_courses'] ?></h2>
    </div>
    <div class="tutor-info">
      <div class="tutor-info-left">
        <img src="images/default-tutor.png" alt="">
      </div>
      <div class="tutor-info-right">
        <h2>Class Tutor</h2>
        <h4>To be assigned</h4>
        <p><strong>Email:</strong> <a href="#">tutor@sti.edu.ht</a></p>
        <p><strong>Phone:</strong> <a href="#">+509 0000 0000</a></p>
        <p>This placeholder uses your database for class information. Once you configure the
          <code>tutors</code> table you can replace it with a dynamic tutor card.
        </p>
      </div>
    </div>
  </div>
<?php
}