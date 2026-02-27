<?php
declare(strict_types=1);

namespace Service;

require_once __DIR__ . '/../Repository/AdmindashRepo.php';

use Repository\AdmindashRepo;

final class AdmindashService
{
    private AdmindashRepo $repo;

    public function __construct()
    {
        $this->repo = new AdmindashRepo();
    }

     //Dashboard view model
    public function build_dashboard_viewmodel_service(?string $selected_class_name): array
    {
        $classes_list = $this->repo->list_classes_repo();

        if ($selected_class_name === null || $selected_class_name === '') {
            $selected_class_name = (string)($classes_list[0]['class_name'] ?? '');
        }

        $selected_class_id = $selected_class_name !== ''
            ? $this->repo->class_id_by_name_repo($selected_class_name)
            : null;

        $dashboard_counts = [
            'admins'   => $this->repo->count_table('admins'),
            'teachers' => $this->repo->count_table('teachers'),
            'students' => $this->repo->count_table('students'),
            'parents'  => $this->repo->count_table('parents'),
            'classes'  => $this->repo->count_table('classes'),
            'courses'  => $this->repo->count_table('courses'),
        ];

        $admins_list   = $this->repo->list_admins_repo(25);
        $teachers_list = $this->repo->list_teachers_repo(25);
        $students_list = $this->repo->list_students_repo(25);
        $parents_list  = $this->repo->list_parents_repo(25);

        $teachers_basic_list = $this->repo->list_teachers_basic_repo();

        $courses_for_class = $selected_class_id
            ? $this->repo->course_details_per_class_repo($selected_class_id)
            : [];

        $schedule_viewmodel = $selected_class_id
            ? $this->build_schedule_viewmodel_service($selected_class_id)
            : $this->empty_schedule_viewmodel();

        return [
            'counts' => $dashboard_counts,

            'lists' => [
                'admins'   => $admins_list,
                'teachers' => $teachers_list,
                'students' => $students_list,
                'parents'  => $parents_list,
            ],

            'classes'        => $classes_list,
            'teachers_basic' => $teachers_basic_list,

            'selected' => [
                'class_name' => $selected_class_name,
                'class_id'   => $selected_class_id,
            ],

            'courses_for_class' => $courses_for_class,
            'schedule'          => $schedule_viewmodel,
        ];
    }

    private function empty_schedule_viewmodel(): array
    {
        return [
            'days'       => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
            'timeLabels' => [],
            'timeMeta'   => [],
            'map'        => [],
        ];
    }

      //Schedule view model
    public function build_schedule_viewmodel_service(int $class_id): array
    {
        $day_rows  = $this->repo->list_days_repo(5);
        $days_list = [];

        foreach ($day_rows as $dr) {
            $name = trim((string)($dr['day_name'] ?? ''));
            if ($name !== '') {
                $days_list[] = $name;
            }
        }

        if (empty($days_list)) {
            $days_list = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
        }

        $time_rows   = $this->repo->list_days_repo();
        $time_labels = [];
        $time_meta   = [];

        foreach ($time_rows as $time_row) {
            $time_id    = (int)($time_row['time_id'] ?? 0);
            $start_time = trim((string)($time_row['start_time'] ?? ''));
            $end_time   = trim((string)($time_row['end_time'] ?? ''));

            if ($time_id <= 0) {
                continue;
            }

            $time_labels[$time_id] = $start_time . ' - ' . $end_time;
            $time_meta[$time_id] = [
                'start' => $start_time,
                'end'   => $end_time,
            ];
        }

        $schedule_rows = $this->repo->schedule_rows_by_class_id_repo($class_id);

        $schedule_map = [];
        foreach ($schedule_rows as $sr) {
            $time_id  = (int)($sr['time_id'] ?? 0);
            $day_name = trim((string)($sr['day_name'] ?? ''));

            if ($time_id <= 0 || $day_name === '') {
                continue;
            }

            $course_name      = trim((string)($sr['course_name'] ?? ''));
            $teacher_fullname = trim((string)($sr['teacher_fullname'] ?? ''));

            $cell_value = $course_name;
            if ($teacher_fullname !== '') {
                $cell_value .= ' — ' . $teacher_fullname;
            }

            $schedule_map[$time_id][$day_name] = $cell_value;
        }

        return [
            'days'       => $days_list,
            'timeLabels' => $time_labels,
            'timeMeta'   => $time_meta,
            'map'        => $schedule_map,
        ];
    }
    //courses
    public function create_course_service(array $post_data): array
    {
        $payload = $this->clean_course_payload($post_data);
        $errors  = $this->validate_course_payload($payload);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $ok = $this->repo->create_course_repo($payload);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB insert failed']];
    }

    public function update_course_service(int $course_id, array $post_data): array
    {
        if ($course_id <= 0) {
            return ['success' => false, 'errors' => ['Invalid course id']];
        }

        $payload = $this->clean_course_payload($post_data);
        $errors  = $this->validate_course_payload($payload);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $ok = $this->repo->update_course_repo($course_id, $payload);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB update failed']];
    }

    public function delete_course_service(int $course_id): array
    {
        if ($course_id <= 0) {
            return ['success' => false, 'errors' => ['Invalid course id']];
        }

        $ok = $this->repo->delete_course_repo($course_id);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB delete failed']];
    }

    private function clean_course_payload(array $post_data): array
    {
        return [
            'course_code' => trim((string)($post_data['course_code'] ?? '')),
            'course_name' => trim((string)($post_data['course_name'] ?? '')),
            'coefficient' => (float)($post_data['coefficient'] ?? 1),
            'description' => trim((string)($post_data['description'] ?? '')),
            'class_id'    => (int)($post_data['class_id'] ?? 0),
            'teacher_id'  => (int)($post_data['teacher_id'] ?? 0),
        ];
    }

    private function validate_course_payload(array $payload): array
    {
        $errors = [];

        if ($payload['course_code'] === '') $errors[] = 'Course code is required';
        if ($payload['course_name'] === '') $errors[] = 'Course name is required';
        if ($payload['class_id'] <= 0) $errors[] = 'Class is required';
        if ($payload['teacher_id'] <= 0) $errors[] = 'Teacher is required';
        if ($payload['coefficient'] <= 0) $errors[] = 'Coefficient must be > 0';

        return $errors;
    }

     //schedule
    public function upsert_schedule_cell_service(int $class_id, int $time_id, int $day_id, int $course_id): array
    {
        if ($class_id <= 0 || $time_id <= 0 || $day_id <= 0 || $course_id <= 0) {
            return ['success' => false, 'errors' => ['Invalid schedule parameters']];
        }

        $ok = $this->repo->upsert_schedule_cell_repo($class_id, $time_id, $day_id, $course_id);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB schedule upsert failed']];
    }

    public function delete_schedule_cell_service(int $class_id, int $time_id, int $day_id): array
    {
        if ($class_id <= 0 || $time_id <= 0 || $day_id <= 0) {
            return ['success' => false, 'errors' => ['Invalid schedule parameters']];
        }

        $ok = $this->repo->delete_schedule_cell_repo($class_id, $time_id, $day_id);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB schedule delete failed']];
    }

    //students
    public function create_student_service(array $post_data): array
    {
        $payload = $this->clean_student_payload($post_data);
        $errors  = $this->validate_student_payload($payload);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $ok = $this->repo->create_student_repo($payload);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB insert failed']];
    }

    public function update_student_service(int $student_id, array $post_data): array
    {
        if ($student_id <= 0) {
            return ['success' => false, 'errors' => ['Invalid student id']];
        }

        $payload = $this->clean_student_payload($post_data);
        $errors  = $this->validate_student_payload($payload);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $ok = $this->repo->update_student_repo($student_id, $payload);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB update failed']];
    }

    public function delete_student_service(int $student_id): array
    {
        if ($student_id <= 0) {
            return ['success' => false, 'errors' => ['Invalid student id']];
        }

        $ok = $this->repo->delete_student_repo($student_id);
        return ['success' => $ok, 'errors' => $ok ? [] : ['DB delete failed']];
    }

    private function clean_student_payload(array $post_data): array
    {
        return [
            'first_name' => trim((string)($post_data['first_name'] ?? '')),
            'last_name'  => trim((string)($post_data['last_name'] ?? '')),
            'email'      => trim((string)($post_data['email'] ?? '')),
            'phone'      => trim((string)($post_data['phone'] ?? '')),
            'class_id'   => (int)($post_data['class_id'] ?? 0),
        ];
    }

    private function validate_student_payload(array $payload): array
    {
        $errors = [];

        if ($payload['first_name'] === '') $errors[] = 'First name is required';
        if ($payload['last_name'] === '')  $errors[] = 'Last name is required';
        if ($payload['class_id'] <= 0)     $errors[] = 'Class is required';

        return $errors;
    }
}