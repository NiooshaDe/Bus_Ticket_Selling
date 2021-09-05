<?php
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Model\Professor.php';
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Model\Pupil.php';
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Model\Course.php';

class Reserve
{
    public $information = [];

    public function __construct(Pupil $student, Professor $teacher, Course $course){
        $this->information['student'] = $student;
        $this->information['teacher'] = $teacher;
        $this->information['course'] = $course;
    }


}