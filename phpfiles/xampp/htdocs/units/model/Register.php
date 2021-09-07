<?php

class register
{
    public function add($course_id, $student_id)
    {
        $connection = DB::connect();

        $sql = "INSERT INTO register (student_id, course_id)
VALUES ($student_id, $course_id)";

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error!" . $connection->error;
        }
    }
}