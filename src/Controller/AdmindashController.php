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

   public function schedule_per_class_controller():array{
    return [
        'schedule_per_class' => [
            '7e' => $this->service->schedule_per_class_service('7e'),
            '8e' => $this->service->schedule_per_class_service('8e'),
            '9e' => $this->service->schedule_per_class_service('9e'),
            'NS1'=> $this->service->schedule_per_class_service('NS1'),
            'NS2'=> $this->service->schedule_per_class_service('NS2'),
            'NS3'=> $this->service->schedule_per_class_service('NS3'),
            'NS4'=> $this->service->schedule_per_class_service('NS4'),
        ],
    ];
   }

   public function students_per_class_controller(): array
    {
        return [
            'student_per_class' => [
                1 => $this->service->student_per_class_service(1),
                2 => $this->service->student_per_class_service(2),
                3 => $this->service->student_per_class_service(3),
                4 => $this->service->student_per_class_service(4),
                5 => $this->service->student_per_class_service(5),
                6 => $this->service->student_per_class_service(6),
                7 => $this->service->student_per_class_service(7),
            ]
        ];
    }
    public function basic_info_per_class_controller(int $classId): array{
    return [
        'basic_info_per_class' => $this->service->basic_info_per_class_service($classId)
    ];
   }

   
   public function handle_post_actions_controller(array $post): array
    {
        if (!is_post_data()) {
            return [];
        }

        return match (true) {
            isset($post['add_course'])    => $this->service->add_course($post),
            isset($post['edit_course'])   => $this->service->edit_course($post),
            isset($post['delete_course']) => $this->service->delete_course($post),

            isset($post['add_student'])    => $this->service->add_student($post),
            isset($post['edit_student'])   => $this->service->edit_student($post),
            isset($post['delete_student']) => $this->service->delete_student($post),

            isset($post['edit_user'])   => $this->service->edit_user($post),
            isset($post['delete_user']) => $this->service->delete_user($post),

            default => []
        };
    }

   



   
}
