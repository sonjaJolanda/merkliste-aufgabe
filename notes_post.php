<?php

class Note_post
{
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "merkliste_db";

    private $name;
    private $description;
    private $date;
    private $time;

    function __construct()
    {
        $this->name = isset($_POST['name']) ? $_POST['name'] : null;
        $this->description = isset($_POST['description']) ? $_POST['description'] : null;
        $this->date = isset($_POST['date']) ? $_POST['date'] : null;
        $this->time = isset($_POST['time']) ? $_POST['time'] : null;
        //echo 'this has been created: '. $this->name .''. $this->description;
        //$this->state = $_POST['status']; //do 
    }

    public function post_note()
    {
        //echo 'this is going to be posted: '. $this->name .''. $this->description;
        $connection = Note::open_connection();

        $post_query = 'insert into notizen(Name, Beschreibung) values(?, ?)';
        //$insertion = $connection->prepare("insert into notizen(Name, Beschreibung, Datum, Uhrzeit) values(?, ?, ?, ?)");
        $post_stmt = $connection->prepare($post_query);
        $post_stmt->bind_param("ss", $this->name, $this->description);
        //$insertion->bind_param("ssii", $this->name, $this->description, $this->date, $this->time); //state

        $post_stmt->execute() or trigger_error($post_stmt->error, E_USER_ERROR);
        //echo "insertion of " . $this->name . " note successful";
        $post_stmt->close();
        $connection->close();
    }

    public static function open_connection(){
        $connection = new mysqli(Note::$servername, Note::$username, Note::$password, Note::$dbname);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        else return $connection;
    }

}
?>
