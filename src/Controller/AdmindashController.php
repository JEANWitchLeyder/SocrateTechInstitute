<?php
declare(strict_types=1);

namespace Controller;

require_once __DIR__ . '/../Service/AdmindashService.php';

use Service\AdmindashService;

final class AdmindashController
{
    private AdmindashService $service;

    public function __construct()
    {
        $this->service = new AdmindashService();
    }

    public function dashboard_viewmodel_controller(): array
    {
        $selected_class_name = (string)($_GET['class'] ?? '');
        return $this->service->build_dashboard_viewmodel_service($selected_class_name);
    }

    public function handle_post_actions_controller(): array
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            return ['success' => true, 'message' => '', 'errors' => []];
        }

        $action_name = (string)($_POST['action'] ?? '');

        if ($action_name === 'create_course') {
            $service_result = $this->service->create_course_service($_POST);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Course created.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

        if ($action_name === 'update_course') {
            $course_id = (int)($_POST['course_id'] ?? 0);
            $service_result = $this->service->update_course_service($course_id, $_POST);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Course updated.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

        if ($action_name === 'delete_course') {
            $course_id = (int)($_POST['course_id'] ?? 0);
            $service_result = $this->service->delete_course_service($course_id);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Course deleted.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

         //schedule
        if ($action_name === 'upsert_schedule_cell') {
            $class_id  = (int)($_POST['class_id'] ?? 0);
            $time_id   = (int)($_POST['time_id'] ?? 0);
            $day_id    = (int)($_POST['day_id'] ?? 0);
            $course_id = (int)($_POST['course_id'] ?? 0);

            $service_result = $this->service->upsert_schedule_cell_service($class_id, $time_id, $day_id, $course_id);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Schedule updated.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

        if ($action_name === 'delete_schedule_cell') {
            $class_id = (int)($_POST['class_id'] ?? 0);
            $time_id  = (int)($_POST['time_id'] ?? 0);
            $day_id   = (int)($_POST['day_id'] ?? 0);

            $service_result = $this->service->delete_schedule_cell_service($class_id, $time_id, $day_id);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Schedule cell cleared.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

          //students
        if ($action_name === 'create_student') {
            $service_result = $this->service->create_student_service($_POST);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Student created.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

        if ($action_name === 'update_student') {
            $student_id = (int)($_POST['student_id'] ?? 0);
            $service_result = $this->service->update_student_service($student_id, $_POST);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Student updated.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

        if ($action_name === 'delete_student') {
            $student_id = (int)($_POST['student_id'] ?? 0);
            $service_result = $this->service->delete_student_service($student_id);
            $is_success = (bool)($service_result['success'] ?? false);

            return [
                'success' => $is_success,
                'message' => $is_success ? 'Student deleted.' : '',
                'errors'  => (array)($service_result['errors'] ?? []),
            ];
        }

        return ['success' => false, 'message' => '', 'errors' => ['Unknown action']];
    }
}