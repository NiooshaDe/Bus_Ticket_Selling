<?php
include_once "model/Professor.php";
class ProfessorController
{

    public function add_professor_page(){
        include 'View/add_professor.php';
    }

    public function add_professor($data){
        $professor = new Professor();
        $professor->addProfessor($data['name']);
    }
}