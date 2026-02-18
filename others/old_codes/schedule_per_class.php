<?php 
/*
function renderScheduleTable(mysqli $connect, string $className): void
{
  //schedule_per_class

  $sql = "
        SELECT 
            d.day        AS day_name,
            t.time_id    AS time_id,
            t.start_time AS start_time,
            t.end_time   AS end_time,
            c.course_name AS course_name
        FROM days d
        CROSS JOIN time_slots t
        LEFT JOIN schedule s
            ON s.day_id  = d.day_id
            AND s.time_id = t.time_id
        LEFT JOIN classes cl
            ON cl.class_id = s.class_id
            AND cl.class_name = ?
        LEFT JOIN courses c
            ON c.course_id = s.course_id
        ORDER BY t.start_time, d.day_id
    ";
  $stmt = mysqli_prepare($connect, $sql);
  mysqli_stmt_bind_param($stmt, 's', $className);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $days       = [];
  $timeLabels = [];
  $timeMeta   = [];
  $map        = [];

  if ($result) {
    while ($r = mysqli_fetch_assoc($result)) {
      $day    = $r['day_name'];
      $timeId = $r['time_id'];

      $startShort = substr($r['start_time'], 0, 5);
      $endShort   = substr($r['end_time'],   0, 5);
      $label      = $startShort . ' - ' . $endShort;

      if (!in_array($day, $days, true)) {
        $days[] = $day;
      }

      if (!isset($timeLabels[$timeId])) {
        $timeLabels[$timeId] = $label;
        $timeMeta[$timeId]   = [
          'start' => $startShort,
          'end'   => $endShort,
        ];
      }

      if (!empty($r['course_name'])) {
        $map[$timeId][$day] = $r['course_name'];
      }
    }
}
}