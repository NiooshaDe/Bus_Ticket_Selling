<?php

include "model/Course.php";
include "model/Register.php";
include "model/Professor.php";

class CourseController
{
    public function add_course_page($data)
    {
        $professor = new Professor();
        $professors = $professor->getProfessor();
        include 'View/add_course.php';
    }

    public function add_course($data)
    {
        $course = new Course();
        $course->addCourse($data['name'], $data['professor']);
    }
}