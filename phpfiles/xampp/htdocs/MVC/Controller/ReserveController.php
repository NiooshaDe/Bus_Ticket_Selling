<?php
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Model\Course.php';
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Model\Professor.php';
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Model\Reserve.php';
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Model\Pupil.php';
class ReserveController
{
public $courseName;
public $studentName;
public $studentID;
public $teacherID;

function getter()
{
    $this->courseName = $_POST['subject'];
    $this->studentName = $_POST['student'];
    $this->studentID = $_POST['studentId'];
    $this->teacherID = $_POST['teacher'];

    $course = new Course($this->courseName);
    $student = new Pupil($this->studentID, $this->studentName);
    $teacher = new Professor($this->teacherID);
    return new Reserve($student, $teacher, $course);
}}