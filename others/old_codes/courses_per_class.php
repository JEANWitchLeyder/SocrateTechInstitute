<?php 
function renderCoursesRows(mysqli $connect, int $classId): void
{
  //course_details_per_class

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
        WHERE c.class_id = ?
        ORDER BY c.course_id ASC
    ";
  $stmt = mysqli_prepare($connect, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $classId);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);

  if (!$res || mysqli_num_rows($res) === 0) {
    echo '<tr><td colspan="6">No courses for this class yet.</td></tr>';
    return;
  }

  while ($row = mysqli_fetch_assoc($res)) {
?>
    <tr>
      <td><?= h($row['course_code']) ?></td>
      <td><?= h($row['course_name']) ?></td>
      <td><?= h($row['teacher_fullname']) ?></td>
      <td><?= h($row['coefficient']) ?></td>
      <td><?= h($row['description']) ?></td>
      <td>
        <div class="button-container">
          <button
            class="edit edit-course-btn"
            data-course-id="<?= (int)$row['course_id'] ?>"
            data-course-name="<?= h($row['course_name']) ?>"
            data-course-coef="<?= (int)$row['coefficient'] ?>"
            data-course-desc="<?= h($row['description']) ?>"
            data-class-id="<?= (int)$row['class_id'] ?>">
            <i class="fa-solid fa-pen"></i>
          </button>
          <button
            class="delete delete-course-btn"
            data-course-id="<?= (int)$row['course_id'] ?>"
            data-course-name="<?= h($row['course_name']) ?>">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </td>
    </tr>
  <?php
  }
}






?>


