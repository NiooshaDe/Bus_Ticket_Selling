<?php

require_once "dataSource/DB.php";

class Professor
{
    public function addProfessor($name)
    {
        $connection = DB::connect();

        $sql = "INSERT INTO professor (name) VALUES ('$name')";
        $connection->query($sql);

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error!" . $connection->error;
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