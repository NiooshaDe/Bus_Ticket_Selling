<?php

require_once "dataSource/DB.php";

class Professor
{
    public $flag;
    public function addProfessor($name)
    {
        $connection = DB::connect();

        $sqlNames = "SELECT name FROM professor";
        $results = mysqli_fetch_all($connection->query($sqlNames));
        $this->flag = 0;
        foreach( $results as $result){
           if($result[0] == $name){
               echo "An error has occured";
               $this->flag = 1;
               die();
           }
       }

        if($this->flag == 0){
        $sql = "INSERT INTO professor (name) VALUES ('$name')";
        $connection->query($sql);

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error!" . $connection->error;
        }
        }
    }

    public function getProfessor()
    {
        $connection = DB::connect();

        $sql = "SELECT id, name FROM professor";
        $result = $connection->query($sql);

        DB::close();

        return $result->fetch_all();
    }

}