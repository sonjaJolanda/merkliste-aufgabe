<?php
// object orientation
// change primary key from name to another id
// make get and post in same format 
// insertion of time and date doesnt work
// throw exceptions
// nach einfügen von  neuer notiz die liste neu laden damit sie aktualisiert wird
// form button reset
// test with a fresh data set (delete all data and try)
// git repo is private
// make a config file for open connection


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entityBody = json_decode(file_get_contents('php://input'), true);
    $note = new Note_post($entityBody["name"], $entityBody["description"]);
    $note->post_note();
    print_r("Ofsawed\n");
} 

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

    function __construct($new_name, $new_description)
    {
        $this->name = $new_name ? $new_name : null;
        $this->description = $new_description ? $new_description : null;
        $this->date = isset($_POST['date']) ? $_POST['date'] : null;
        $this->time = isset($_POST['time']) ? $_POST['time'] : null;
        //echo 'this has been created: '. $this->name .''. $this->description;
        //$this->state = $_POST['status']; //do 
    }

    public function post_note()
    {
        //echo 'this is going to be posted: '. $this->name .''. $this->description;
        $connection = Note_post::open_connection();

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
        $connection = new mysqli(Note_post::$servername, Note_post::$username, Note_post::$password, Note_post::$dbname);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        else return $connection;
    }

}
?>
