<?php
include_once "Pupil.php";
include_once "Professor.php";

class Course
{
    public $courseName;

    public function __construct($courseName){
        $this->courseName = $courseName;
    }


}