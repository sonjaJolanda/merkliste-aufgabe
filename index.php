<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="bootstrap.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Merkliste</h1>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Beschreibung</th>
              <th scope="col">Datum</th>
              <th scope="col">Uhrzeit</th>
              <th scope="col">Erledigt</th>
              <th scope="col">Aktion</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              require_once 'notes.php';
              $notes = Note::get_notes();
              while ($row = mysqli_fetch_assoc($notes)) {
                ?>
                <td>
                  <?php echo $row['Name']; ?>
                </td>
                <td>
                  <?php echo $row['Beschreibung']; ?>
                </td>
                <td>
                  <?php echo $row['Datum']; ?>
                </td>
                <td>
                  <?php echo $row['Uhrzeit']; ?>
                </td>
                <td><input type="checkbox" /></td> <!-- <?php echo $row['Status']; ?> -->
                <td><span class="fa fa-edit mr-1"></span><span class="fa fa-times"></span></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <hr />
        <h2>Neue Notiz anlegen</h2>
        <?php
          if(isset($_POST['insert'])) { 
            echo "Insertion has been isseted: isset: " . isset($_POST['insert']) . "\n";
            require_once 'notes_post.php';
            $note = new Note_post();
            $note->post_note();
            unset($_POST['insert']);
            echo "Insertion has been unseted: isset: " . isset($_POST['insert']);
          }
        ?>
        <form method="post">
          <div class="row">
            <div class="col-12">
              <label>Name</label>
              <input class="form-control" id="name" name="name" />
            </div>
            <div class="col-12">
              <label>Beschreibung</label>
              <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="col-6">
              <label>Datum</label>
              <input class="form-control" id="date" name="date" />
            </div>
            <div class="col-6">
              <label>Uhrzeit</label>
              <input class="form-control" id="time" name="time" />
            </div>
            <div class="col-12">
              <br />
              <button class="btn btn-success" name="insert">Anlegen</button>
              <button class="btn btn-danger">Zurücksetzen</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>