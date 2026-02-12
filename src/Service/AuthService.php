<?php 

namespace Service;

use Repository\AuthRepository;

class AuthService{
    private AuthRepository $user;

    public function __construct(){
        $this->user = new AuthRepository();
    }

    public function register_service($username,$email,$password,$password_confirm,$role){
      if( empty($username) ||
      empty($email) ||
      empty($password) ||
      empty($password_confirm) ||
      empty($role)){
        return ['success'=>false,
                'error'  =>'Field cannot be empty'];
      } elseif ($password !== $password_confirm) {
        return ['success'=>false,
                'error'  =>'Password and Password Confirm cannot be different'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success'=>false,
                'error'  =>'Incorrect Email Format'];
    } elseif (strlen($password) < 8 || strlen($password_confirm) < 8) {
        return ['success'=>false,
                'error'  =>'Password should have at least 8 characters'];
    } else{
         $hash = password_hash($password,PASSWORD_DEFAULT);

         $created = $this->user->register_repo($username,$email,$hash,$role);

         if(!$created){
            return ['success'=>false,
                    'error'  =>'Error while creating the user'];
         }else{
            return ['success'=>true,
                    'error'  =>'User created successfully'];
         }
    }
}
    
    public function login_service($username,$password){
        if(empty($username) || empty($password)){
             return ['success'=>false,
                'error'  =>'Field cannot be empty'];
        }else if(strlen($password) < 8){
            return ['success'=>false,
                'error'  =>'Password should have at least 8 characters'];
        }else{
            $user = $this->user->login_repo($username);

            if(!$user || password_verify($password,$user['password'])){
                return ['success'=>false,
                'error'  =>'Invalid Credentials'];
            }

            return ['success'=>true];
        }
    }
}






?>