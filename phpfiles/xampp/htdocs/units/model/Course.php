<?php

require_once "dataSource/DB.php";

class Course
{
    public function addCourse($name, $professor_id)
    {
        $connection = DB::connect();

        $sql = "INSERT INTO course (name, professor_id) VALUES ('$name', $professor_id)";

        $connection->query($sql);

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error!" . $connection->error;
        }
    }

    public function getCourse()
    {
        $connection = DB::connect();

        $sql = "SELECT id, name, professor_id FROM course";
        $result = $connection->query($sql);

        DB::close();

        return $result->fetch_all();
    }


}