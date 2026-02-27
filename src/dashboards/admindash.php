<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../Controller/AdmindashController.php';
require_once __DIR__ . '/../Core/partials/header.php';

use Controller\AdmindashController;

if (!function_exists('h')) {
    function h(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

$admindash_controller = new AdmindashController();

$flash_message       = $admindash_controller->handle_post_actions_controller();
$dashboard_viewmodel = $admindash_controller->dashboard_viewmodel_controller();

//View Models extraction
$dashboard_counts    = (array)($dashboard_viewmodel['counts'] ?? []);
$dashboard_lists     = (array)($dashboard_viewmodel['lists'] ?? []);
$classes_list        = (array)($dashboard_viewmodel['classes'] ?? []);
$gender_list         = (array)($dashboard_viewmodel['gender_list'] ?? []); 
$teachers_list       = (array)($dashboard_viewmodel['teachers_basic'] ?? []);
$selected_data       = (array)($dashboard_viewmodel['selected'] ?? ['class_name' => '', 'class_id' => null]);

$courses_for_class   = (array)($dashboard_viewmodel['courses_for_class'] ?? []);
$schedule_viewmodel  = (array)($dashboard_viewmodel['schedule'] ?? ['days'=>[], 'timeLabels'=>[], 'timeMeta'=>[], 'map'=>[]]);

$days_list           = (array)($schedule_viewmodel['days'] ?? []);
$time_labels         = (array)($schedule_viewmodel['timeLabels'] ?? []);
$time_meta           = (array)($schedule_viewmodel['timeMeta'] ?? []);
$schedule_map        = (array)($schedule_viewmodel['map'] ?? []);

//cards
$cards = [
    ['key' => 'teachers', 'title' => 'Teachers',   'img' => '../images/dashboardImage/teachers.png'],
    ['key' => 'admins',   'title' => 'S. Members', 'img' => '../images/dashboardImage/staff.png'],
    ['key' => 'students', 'title' => 'Students',   'img' => '../images/dashboardImage/students.png'],
    ['key' => 'parents',  'title' => 'Parents',    'img' => '../images/dashboardImage/family.png'],
];

$success_message = '';
if (($flash_message['success'] ?? false) === true && (string)($flash_message['message'] ?? '') !== '') {
    $success_message = (string)$flash_message['message'];
}
?>

<?php if ($success_message !== ''): ?>
  <div class="success-toast">
    <?= h($success_message) ?>
  </div>
<?php endif; ?>

<?php if (!empty($flash_message['errors'] ?? [])): ?>
  <div class="flash-error">
    <strong>Errors:</strong>
    <ul>
      <?php foreach (($flash_message['errors'] ?? []) as $error_item): ?>
        <li><?= h((string)$error_item) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<section class="dashboard-container">
  <aside id="sidebar">
    <div class="dashboard-logo-container">
      <a href="index.html"><img src="images/logowhite.png" alt=""></a>
    </div>

    <button class="dashboard-tab-button" data-tab="1">Overview/Analytics</button>
    <button class="dashboard-tab-button" data-tab="2">User Management</button>
    <button class="dashboard-tab-button" data-tab="3">Classes & Courses</button>
    <button class="dashboard-tab-button" data-tab="4">Documents & Admissions</button>
    <button class="dashboard-tab-button" data-tab="5">Announcements / Notifications</button>
    <button class="dashboard-tab-button" data-tab="6">System Settings</button>
  </aside>

  <main id="main-content">
    <div class="dashboards-header-outer-container">
      <div class="dashboards-header">
        <div class="dashboards-header-left">
          <h1>Welcome to STI</h1>
        </div>

        <div class="dashboard-middle-header">
          <form action="" class="search-form">
            <input type="search" placeholder="Search students, teachers, classes...">
            <button type="submit"><i class="fa-brands fa-searchengin"></i></button>
          </form>
        </div>

        <div class="dashboards-header-right">
          <span>Academic Year: 2025-2026</span>
          <div class="dashboard-icons-container">
            <i class="fa-solid fa-user"></i>
            <i class="fa-solid fa-bell"></i>
            <i class="fa-solid fa-gear"></i>
            <i class="fa-solid fa-question"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 1 -->
    <div class="dashboard-tabs-content dashboards-content-active" data-tab="1">
      <div class="dashboard-card-outer-container">
        <div class="dashboard-card-container">
          <?php foreach ($cards as $card_item): ?>
            <div class="card-child">
              <div class="card-child-left">
                <img src="<?= h($card_item['img']) ?>" alt="">
              </div>
              <div class="card-child-right">
                <span><?= (int)($dashboard_counts[$card_item['key']] ?? 0) ?></span>
                <h2><?= h($card_item['title']) ?></h2>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="socratetech-statistic">
        <div class="socratetech-statistic-left">
          <h1>Attendance Rate</h1>
          <div id="chart"></div>
        </div>
        <div class="socratetech-statistic-right">
          <h1>Performance Statistics</h1>
          <div id="performanceChart"></div>
        </div>
      </div>
    </div>

    <!-- TAB 2 -->
    <div class="dashboard-tabs-content" data-tab="2">
      <div class="user-management-tab-container">

        <div class="user-management-button-container">
          <button class="user-management-tab-button" data-tab="1">Admins</button>
          <button class="user-management-tab-button" data-tab="2">Teachers</button>
          <button class="user-management-tab-button" data-tab="3">Students</button>
          <button class="user-management-tab-button" data-tab="4">Parents</button>
        </div>

        <?php
          $admin_rows   = (array)($dashboard_lists['admins'] ?? []);
          $teacher_rows = (array)($dashboard_lists['teachers'] ?? []);
          $student_rows = (array)($dashboard_lists['students'] ?? []);
          $parent_rows  = (array)($dashboard_lists['parents'] ?? []);
        ?>

        <div class="user-management-content-container userManagementActiveContentContainer" data-tab="1">
          <div class="admin-table-container">
            <table class="table-container">
              <thead>
                <tr>
                  <th>Admin ID</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($admin_rows)): ?>
                  <?php foreach ($admin_rows as $row): ?>
                    <tr>
                      <td><?= (int)($row['admin_id'] ?? 0) ?></td>
                      <td><?= h((string)($row['username'] ?? '')) ?></td>
                      <td><?= h((string)($row['email'] ?? '')) ?></td>
                      <td><?= h((string)($row['created_at'] ?? '')) ?></td>
                      <td>
                        <div class="button-container">
                          <button class="edit edit-user-btn"
                            data-user-type="admins"
                            data-user-id="<?= (int)($row['admin_id'] ?? 0) ?>"
                            data-user-email="<?= h((string)($row['email'] ?? '')) ?>">
                            <i class="fa-solid fa-pen"></i>
                          </button>
                          <button class="delete delete-user-btn"
                            data-user-type="admins"
                            data-user-id="<?= (int)($row['admin_id'] ?? 0) ?>">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="5">No data available</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="user-management-content-container" data-tab="2">
          <div class="admin-table-container">
            <table class="table-container">
              <thead>
                <tr>
                  <th>Teacher ID</th>
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($teacher_rows)): ?>
                  <?php foreach ($teacher_rows as $row): ?>
                    <tr>
                      <td><?= (int)($row['teacher_id'] ?? 0) ?></td>
                      <td><?= h((string)($row['last_name'] ?? '')) ?></td>
                      <td><?= h((string)($row['first_name'] ?? '')) ?></td>
                      <td><?= h((string)($row['email'] ?? '')) ?></td>
                      <td><?= h((string)($row['phone'] ?? '')) ?></td>
                      <td><?= h((string)($row['created_at'] ?? '')) ?></td>
                      <td>
                        <div class="button-container">
                          <button class="edit edit-user-btn"
                            data-user-type="teachers"
                            data-user-id="<?= (int)($row['teacher_id'] ?? 0) ?>"
                            data-user-email="<?= h((string)($row['email'] ?? '')) ?>">
                            <i class="fa-solid fa-pen"></i>
                          </button>
                          <button class="delete delete-user-btn"
                            data-user-type="teachers"
                            data-user-id="<?= (int)($row['teacher_id'] ?? 0) ?>">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="7">No data available</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="user-management-content-container" data-tab="3">
          <div class="admin-table-container">
            <table class="table-container">
              <thead>
                <tr>
                  <th>Student ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Class ID</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($student_rows)): ?>
                  <?php foreach ($student_rows as $row): ?>
                    <tr>
                      <td><?= (int)($row['student_id'] ?? 0) ?></td>
                      <td><?= h((string)($row['first_name'] ?? '')) ?></td>
                      <td><?= h((string)($row['last_name'] ?? '')) ?></td>
                      <td><?= (int)($row['class_id'] ?? 0) ?></td>
                      <td><?= h((string)($row['email'] ?? '')) ?></td>
                      <td><?= h((string)($row['phone'] ?? '')) ?></td>
                      <td><?= h((string)($row['created_at'] ?? '')) ?></td>
                      <td>
                        <div class="button-container">
                          <button class="edit edit-student-btn"
                            data-student-id="<?= (int)($row['student_id'] ?? 0) ?>"
                            data-student-fname="<?= h((string)($row['first_name'] ?? '')) ?>"
                            data-student-lname="<?= h((string)($row['last_name'] ?? '')) ?>"
                            data-student-email="<?= h((string)($row['email'] ?? '')) ?>"
                            data-student-phone="<?= h((string)($row['phone'] ?? '')) ?>"
                            data-student-class-id="<?= (int)($row['class_id'] ?? 0) ?>">
                            <i class="fa-solid fa-pen"></i>
                          </button>
                          <button class="delete delete-student-btn"
                            data-student-id="<?= (int)($row['student_id'] ?? 0) ?>"
                            data-student-name="<?= h((string)(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''))) ?>">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="8">No data available</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="user-management-content-container" data-tab="4">
          <div class="admin-table-container">
            <table class="table-container">
              <thead>
                <tr>
                  <th>Parent ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($parent_rows)): ?>
                  <?php foreach ($parent_rows as $row): ?>
                    <tr>
                      <td><?= (int)($row['parent_id'] ?? 0) ?></td>
                      <td><?= h((string)($row['first_name'] ?? '')) ?></td>
                      <td><?= h((string)($row['last_name'] ?? '')) ?></td>
                      <td><?= h((string)($row['email'] ?? '')) ?></td>
                      <td><?= h((string)($row['phone'] ?? '')) ?></td>
                      <td><?= h((string)($row['created_at'] ?? '')) ?></td>
                      <td>
                        <div class="button-container">
                          <button class="edit edit-user-btn"
                            data-user-type="parents"
                            data-user-id="<?= (int)($row['parent_id'] ?? 0) ?>"
                            data-user-email="<?= h((string)($row['email'] ?? '')) ?>">
                            <i class="fa-solid fa-pen"></i>
                          </button>
                          <button class="delete delete-user-btn"
                            data-user-type="parents"
                            data-user-id="<?= (int)($row['parent_id'] ?? 0) ?>">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="7">No data available</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

                <!--Courses and Classes-->
    <div class="dashboard-tabs-content" data-tab="3">
      <div class="classes-main-container">

        <div class="classes-buttons-tab-container">
          <button class="class-button-tab button" data-tab="1">7e</button>
          <button class="class-button-tab button" data-tab="2">8e</button>
          <button class="class-button-tab button" data-tab="3">9e</button>
          <button class="class-button-tab button" data-tab="4">NS1</button>
          <button class="class-button-tab button" data-tab="5">NS2</button>
          <button class="class-button-tab button" data-tab="6">NS3</button>
          <button class="class-button-tab button" data-tab="7">NS4</button>
        </div>

        <div class="classes-content-container classesContentContainerActive" data-tab="1">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <!-- Basic Info -->
          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <div class="basic-info-container">
              <div class="basic-info">
                <span><?= h((string)($selected_data['class_name'] ?? '')) ?></span>
                <h2>Academic Year: 2025-2026</h2>
              </div>
            </div>
          </div>

          <!-- Courses -->
          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>

            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($courses_for_class)): ?>
                    <tr><td colspan="6">No courses for this class yet.</td></tr>
                  <?php else: ?>
                    <?php foreach ($courses_for_class as $row): ?>
                      <tr>
                        <td><?= h((string)($row['course_code'] ?? '')) ?></td>
                        <td><?= h((string)($row['course_name'] ?? '')) ?></td>
                        <td><?= h((string)($row['teacher_fullname'] ?? '')) ?></td>
                        <td><?= h((string)($row['coefficient'] ?? '')) ?></td>
                        <td><?= h((string)($row['description'] ?? '')) ?></td>
                        <td>
                          <div class="button-container">
                            <button class="edit edit-course-btn"
                              data-course-id="<?= (int)($row['course_id'] ?? 0) ?>"
                              data-course-name="<?= h((string)($row['course_name'] ?? '')) ?>"
                              data-course-coef="<?= h((string)($row['coefficient'] ?? '')) ?>"
                              data-course-desc="<?= h((string)($row['description'] ?? '')) ?>"
                              data-class-id="<?= (int)($row['class_id'] ?? 0) ?>"
                              data-teacher-id="<?= (int)($row['teacher_id'] ?? 0) ?>">
                              <i class="fa-solid fa-pen"></i>
                            </button>

                            <button class="delete delete-course-btn"
                              data-course-id="<?= (int)($row['course_id'] ?? 0) ?>"
                              data-course-name="<?= h((string)($row['course_name'] ?? '')) ?>">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Schedule -->
          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php if (empty($time_labels)): ?>
              <p>No schedule data yet.</p>
            <?php else: ?>
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Time</th>
                    <?php foreach ($days_list as $day_name): ?>
                      <th><?= h((string)$day_name) ?></th>
                    <?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($time_labels as $time_id => $label): ?>
                    <?php
                      $start_time = (string)($time_meta[$time_id]['start'] ?? '');
                      $end_time   = (string)($time_meta[$time_id]['end'] ?? '');
                    ?>
                    <tr>
                      <td><?= h((string)$label) ?></td>
                      <?php foreach ($days_list as $day_name): ?>
                        <?php
                          $value     = (string)($schedule_map[$time_id][$day_name] ?? '');
                          $cell_class = '';

                          if ($value === '') {
                            if ($start_time === '08:00' && $end_time === '10:00') {
                              $value = 'Flag / Exercises';
                              $cell_class = 'schedule-flag';
                            } elseif ($start_time === '12:00' && $end_time === '13:00') {
                              $value = 'Break';
                              $cell_class = 'schedule-break';
                            } elseif ($start_time === '15:00' && $end_time === '15:30') {
                              $value = 'Break';
                              $cell_class = 'schedule-break';
                            }
                          }
                        ?>
                        <td class="<?= h($cell_class) ?>"><?= h($value === '' ? '—' : $value) ?></td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>

                        <!--Student per class-->
          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="<?= (int)($selected_data['class_id'] ?? 0) ?>">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>

            <div class="student-container">
              <table class="courses-table students-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Class ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $students_rows = (array)($dashboard_lists['students'] ?? []); ?>
                  <?php if (empty($students_rows)): ?>
                    <tr><td colspan="7">No students registered yet for this class.</td></tr>
                  <?php else: ?>
                    <?php foreach ($students_rows as $row): ?>
                      <tr>
                        <td><?= (int)($row['student_id'] ?? 0) ?></td>
                        <td><?= h((string)($row['first_name'] ?? '')) ?></td>
                        <td><?= h((string)($row['last_name'] ?? '')) ?></td>
                        <td><?= (int)($row['class_id'] ?? 0) ?></td>
                        <td><?= h((string)($row['email'] ?? '')) ?></td>
                        <td><?= h((string)($row['phone'] ?? '')) ?></td>
                        <td>
                          <div class="button-container">
                            <button class="edit edit-student-btn"
                              data-student-id="<?= (int)($row['student_id'] ?? 0) ?>"
                              data-student-fname="<?= h((string)($row['first_name'] ?? '')) ?>"
                              data-student-lname="<?= h((string)($row['last_name'] ?? '')) ?>"
                              data-student-email="<?= h((string)($row['email'] ?? '')) ?>"
                              data-student-phone="<?= h((string)($row['phone'] ?? '')) ?>"
                              data-student-class-id="<?= (int)($row['class_id'] ?? 0) ?>">
                              <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="delete delete-student-btn"
                              data-student-id="<?= (int)($row['student_id'] ?? 0) ?>"
                              data-student-name="<?= h((string)(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''))) ?>">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="dashboard-tabs-content" data-tab="4">Documents & Admissions…</div>
    <div class="dashboard-tabs-content" data-tab="5">Announcements / Notifications…</div>
    <div class="dashboard-tabs-content" data-tab="6">System Settings…</div>

  </main>
</section>

<!-- Keep your original script dependencies -->
<script src="../js/script2.js"></script>
<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<?php
$footer_path = __DIR__ . '/../Core/partials/footer.php';
?>
<script src="../../assets/js/script2.js"></script>
<script src="../../assets/js/script.js"></script>
