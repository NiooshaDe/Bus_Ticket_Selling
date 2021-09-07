<?php

include_once 'model/course.php';
include_once 'model/Register.php';

class RegisterClassController
{
    public function register_class_page($data)
    {
        $course = new Course();
        $courses = $course->getCourse();
        $student_id = 1;

        include 'View/register_course.php';
    }

    public function register_class($data)
    {
        $student_id = 1;
        $register = new Register();
        $register->add($data['course'], $student_id);
    }
}