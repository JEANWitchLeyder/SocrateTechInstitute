<?php




/* 
if(is_user_logged_in()){
  redirect('admindash.php');
  }


*/
/*
  $username = $email = $password = $password_confirm = $role = "";
  $error = "";
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = isset($_POST['username']) ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['username']))) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($connect, trim(strip_tags($_POST['password']))) : '';
    
  
    if(empty($username) ||  empty($password)){
      $error = "The fields cannot be empty";
    }else if(!user_exists($connect,$username)){
    $error = "Unknown Username. Please Register first before Login.";
    }
    
    else if(strlen($password) < 8){
      $error = "Password and Password Confirm should have at least 8 characters";
    }else{
      //Logic
      $sql = "SELECT user_id,username,password FROM users WHERE username = ? LIMIT 1";
      $stmt = mysqli_prepare($connect,$sql);
      mysqli_stmt_bind_param($stmt,'s',$username);
      
     
     
      if( !mysqli_stmt_execute($stmt)){
          if(password_verify($password,$user['password'])){
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = $user['role'];
              
            $routes = [
          
              'parent' => 'parentdash.php',
              'teacher' => 'teacherdash.php',
              'student' => 'studentdash.php',
              'admin' => 'admindash.php'
            ];
    
            $target = $routes[$user['role']] ?? 'index.php'; 
            redirect("$target");
          }
          else{
            $error = "Invalid Username or Password";
          }
         
      }
      mysqli_stmt_close($stmt);
    }
  }


  */