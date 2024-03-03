<?php
// make get and post in same format 
// insertion of time and date doesnt work
// throw exceptions and or catch exceptions and errors
// nach einfügen von  neuer notiz die liste neu laden damit sie aktualisiert wird
// form button reset
// test with a fresh data set (delete all data and try)
// git repo is private
// make a config file for open connection


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    print_r("post method from notes"); // Todo remove
    $entityBody = json_decode(file_get_contents('php://input'), true);
    $note = new Note($entityBody["name"], $entityBody["description"]);
    $note->post_note();
} 

class Note
{
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "merkliste_db";

    private $name;
    private $description;
    private $date;
    private $time;

    function __construct($new_name, $new_description)
    {
        $this->name = $new_name ? $new_name : null;
        $this->description = $new_description ? $new_description : null;
        $this->date = isset($_POST['date']) ? $_POST['date'] : null;
        $this->time = isset($_POST['time']) ? $_POST['time'] : null;
        //$this->state = $_POST['status']; // Todo
    }

    public function post_note()
    {
        $connection = Note::open_connection();

        $post_query = 'insert into notizen(Name, Beschreibung) values(?, ?)';
        //$insertion = $connection->prepare("insert into notizen(Name, Beschreibung, Datum, Uhrzeit) values(?, ?, ?, ?)");
        $post_stmt = $connection->prepare($post_query);
        $post_stmt->bind_param("ss", $this->name, $this->description);
        //$insertion->bind_param("ssii", $this->name, $this->description, $this->date, $this->time); //state

        $post_stmt->execute() or trigger_error($post_stmt->error, E_USER_ERROR);
        $post_stmt->close();
        $connection->close();
    }

    public static function get_notes()
    {
        $connection = Note::open_connection();
        $get_query = 'select * from notizen';
        $result = mysqli_query($connection, $get_query);
        $connection->close();
        return $result;
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
