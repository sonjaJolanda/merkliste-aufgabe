<?php

class Note_get
{
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "merkliste_db";

    public static function get_notes()
    {
        $connection = Note_get::open_connection();
        $get_query = 'select * from notizen';
        $result = mysqli_query($connection, $get_query);
        $connection->close();
        return $result;
    }

    public static function open_connection(){
        $connection = new mysqli(Note_get::$servername, Note_get::$username, Note_get::$password, Note_get::$dbname);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        else return $connection;
    }

}
?>
