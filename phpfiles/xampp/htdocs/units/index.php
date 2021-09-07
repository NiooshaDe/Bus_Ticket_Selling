<?php
include_once "controller/CourseController.php";
include_once "controller/RegisterClassController.php";
include_once "controller/ProfessorController.php";

//routing request to appropriate Controller
$route = isset($_GET['route']) ? $_GET['route'] : '' ;
switch ($route) {
    case 'add_course_page':
        $course = new CourseController();
        $course->add_course_page($_POST);
        break;

    case 'do_add_course':
        $course = new CourseController();
        $course->add_course($_POST);
        break;

    case 'register_class_page':
        $registerClass = new RegisterClassController();
        $registerClass->register_class_page($_POST);
        break;

    case 'register_class':
        $registerClass = new RegisterClassController();
        $registerClass->register_class($_POST);
        break;

    case 'do_add_professor':
        $professor = new ProfessorController();
        $professor->add_professor($_POST);
        break;

    case 'add_professor_page' :
        $professor = new ProfessorController();
        $professor->add_professor_page();
        break;
    default:
        echo '404 not found!';
}