<?php

class DB
{
    private static $conn;

    public static function connect()
    {
        $servername = "localhost";
        $dbname = "university";
        $username = "root";
        $password = "";

        // Create connection
        self::$conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!self::$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return self::$conn;
    }

    public static function close()
    {
        self::$conn->close();
    }
}