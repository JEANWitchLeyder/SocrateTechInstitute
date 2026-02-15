<?php



/*if (is_user_logged_in()) {
    redirect('admindash.php');
}*/



/*

$username = $email = $password = $password_confirm = $role = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = isset($_POST['username'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['username'])))
        : '';

    $email = isset($_POST['email'])
        ? mysqli_real_escape_string(
            $connect,
            trim(strip_tags(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)))
        )
        : '';

    $password = isset($_POST['password'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['password'])))
        : '';

    $password_confirm = isset($_POST['password_confirm'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['password_confirm'])))
        : '';

    $role = isset($_POST['role'])
        ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['role'])))
        : '';
    if (
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($password_confirm) ||
        empty($role)
    ) {
        $error = "The fields cannot be empty";
    } elseif (user_exists($connect, $username)) {
        $error = "Username already exists. Please pick another one.";
    } elseif ($password !== $password_confirm) {
        $error = "Password and Password Confirm cannot be different";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Incorrect Email Format";
    } elseif (strlen($password) < 8 || strlen($password_confirm) < 8) {
        $error = "Password and Password Confirm should have at least 8 characters";
    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, email, password, role) VALUES(?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $username, $email, $password_hash, $role);

        if (mysqli_stmt_execute($stmt)) {

            $routes = [
                'parent'  => 'parentdash.php',
                'teacher' => 'teacherdash.php',
                'student' => 'studentdash.php',
                'admin'   => '../dashboards/admindash.php'
            ];

            if (!isset($routes[$role])) {
                $error = "Invalid role selected";
            } else {
                $_SESSION['username']  = $username;
                $_SESSION['logged_in'] = true;
                $_SESSION['role']      = $role;
                redirect($routes[$role]);
            }
        } else {
            $error = "Failed to insert data into DB.";
        }

        mysqli_stmt_close($stmt);
    }
}

*/