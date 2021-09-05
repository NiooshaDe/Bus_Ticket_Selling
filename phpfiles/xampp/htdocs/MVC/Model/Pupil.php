<?php


class Pupil
{
    public $studentID, $name;

    public function __construct($studentID, $name){
        $this->studentID = $studentID;
        $this->name = $name;
    }

}