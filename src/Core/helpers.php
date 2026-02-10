<?php
/*
base_path,base_url,asset_url,uploads_path,uploads_url,redirect,is_logged_in, check_if_user_logged_in, get_post_data,is_post_data,

*/
function base_path(string $path = ""):string{
    return __DIR__ . ltrim($path,'/');
}

function base_url(string $path = ""):string{
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http');

    $host = $_SERVER['HTTP_HOST'];

    $project_folder = basename(__DIR__);

    return $protocol . $host .'/' . $project_folder . "/";
}

function asset_url(string $url = ""):string{
    return base_url($url,'/');
}
function upload_path(string $path = "") : string{
    return base_path($path,'/');
}
function redirect(string $url):void{
    header("Location: " . base_url($url,"/"));
}
function is_logged_in():bool{
return isset($_SESSION['user_id']);
}
function check_user_logged_in(){
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['user_id'])){
        redirect("login.php");
    }
}

function get_post_data($field, $default = ""){
    return $_POST[$field] ?? $default;
}

function is_post_data(){
    return $_SERVER['REQUEST_METHOD'] === "POST";
}














/*
function is_user_logged_in(){
    return isset($_SESSION['username']) && $_SESSION['username'] === true;
}

function user_exists($connect,$username){
$sql = 'SELECT * FROM users WHERE username = ? LIMIT 1';
$stmt = mysqli_prepare($connect,$sql);
mysqli_stmt_bind_param($stmt,'s',$username);
mysqli_execute($stmt);
mysqli_stmt_store_result($stmt);

return mysqli_stmt_num_rows($stmt) > 0;
}

function redirect($location){
    header("Location: $location");
    exit;
}
*/

?>