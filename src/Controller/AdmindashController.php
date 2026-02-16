<?php
declare(strict_types=1);

namespace Controller;

require_once __DIR__ . '/../Service/AdmindashService.php';

use Service\AdmindashService;

class AdmindashController
{
   public function __construct(private AdmindashService $service){}

   public function course_details_per_class_controller():array{
    return [
        'courses_by_class' => [
            1 => $this->service->course_details_per_class_service(1),
            2 => $this->service->course_details_per_class_service(2),
            3 => $this->service->course_details_per_class_service(3),
            4 => $this->service->course_details_per_class_service(4),
            5 => $this->service->course_details_per_class_service(5),
            6 => $this->service->course_details_per_class_service(6),
            7 => $this->service->course_details_per_class_service(7),
        ],
    ];
   }
}
