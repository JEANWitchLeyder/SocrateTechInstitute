<?php
declare(strict_types=1);

namespace Controller;

require_once __DIR__ . '/../Service/AuthService.php';

use Service\AuthService;

class AuthController
{
    public function register_control(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username         = trim((string) get_post_data('username'));
        $email            = trim((string) get_post_data('email'));
        $password         = trim((string) get_post_data('password'));
        $password_confirm = trim((string) get_post_data('password_confirm'));
        $role             = trim((string) get_post_data('role'));

        $service = new AuthService();
        $result  = $service->register_service($username, $email, $password, $password_confirm, $role);

        if (($result['success'] ?? false) === true) {

            $routes = [
                'parent'  => BASE_URL . '/src/dashboards/parentdash.php',
                'teacher' => BASE_URL . '/src/dashboards/teacherdash.php',
                'student' => BASE_URL . '/src/dashboards/studentdash.php',
                'admin'   => BASE_URL . '/src/dashboards/admindash.php',
            ];

            if (!isset($routes[$role])) {
                return ['success' => false, 'error' => 'Invalid role for this user'];
            }

            $_SESSION['username']  = $username;
            $_SESSION['logged_in'] = true;
            $_SESSION['role']      = $role;

            header('Location: ' . $routes[$role]);
            exit;
        }

        return is_array($result) ? $result : ['success' => false, 'error' => 'Register failed'];
    }

    public function login_control(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim((string) get_post_data('username'));
        $password = trim((string) get_post_data('password'));

        $service = new AuthService();
        $result  = $service->login_service($username, $password);

        if (($result['success'] ?? false) === true) {

            $role = (string)($result['role'] ?? '');

            $routes = [
                'parent'  => BASE_URL . '/src/dashboards/parentdash.php',
                'teacher' => BASE_URL . '/src/dashboards/teacherdash.php',
                'student' => BASE_URL . '/src/dashboards/studentdash.php',
                'admin'   => BASE_URL . '/src/dashboards/admindash.php',
            ];

            if (!isset($routes[$role])) {
                return ['success' => false, 'error' => 'Invalid role for this user'];
            }

            $_SESSION['username']  = $username;
            $_SESSION['logged_in'] = true;
            $_SESSION['role']      = $role;

            header('Location: ' . $routes[$role]);
            exit;
        }

        return is_array($result) ? $result : ['success' => false, 'error' => 'Login failed'];
    }
}
