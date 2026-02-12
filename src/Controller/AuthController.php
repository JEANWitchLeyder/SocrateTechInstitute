<?php 
namespace Controller;

use Service\AuthService;

class AuthController{
   
    public function register_control(): array{
      $username = trim(get_post_data('username'));
      $email = trim(get_post_data('email'));
      $password = trim(get_post_data('password'));
      $password_confirm = trim(get_post_data('password_confirm'));
      $role = trim(get_post_data('role'));

      $service = new AuthService();
      $result = $service->register_service($username,$email, $password,$password_confirm, $role);

      if($result['success'] ?? false){
        redirect('login.php');
      }
      return $result;
    }

    public function login_control(): array{
        $username = trim(get_post_data('username'));
        $password = trim(get_post_data('password'));

        $service = new AuthService();
        $result = $service->login_service($username,$password);
  
        if($result['success'] ?? false){
          redirect('login.php');
        }
        return $result;
    }
}













?>