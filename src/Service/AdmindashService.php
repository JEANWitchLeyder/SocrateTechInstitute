<?php 

namespace Service;


require_once __DIR__ . '/../Repository/AuthRepository.php';

use Repository\AdminRepo;
use Repository\AuthRepository;

class AdmindashService{
    private AdminRepo $user;

    public function __construct(private AdminRepo $repo){}

    public function course_details_per_class_service(int $classId){
     return $this->repo->course_details_per_class_repo($classId);
    }

    
}






?>