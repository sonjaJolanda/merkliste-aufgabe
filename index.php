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
              require_once 'notes_get.php';
              $notes = Note_get::get_notes();
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
                <td><input type="checkbox" id="status-checkbox" <?php echo $row['Status']==1 ? "checked" : ""; ?>/></td> 
                <script>
                    document.getElementById('status-checkbox').addEventListener("change", function () {
                      var statusCheckbox = document.getElementById('status-checkbox').value;
                      var formData = {
                        id: $row['ID'],
                        status: statusCheckbox.checked};
                      var xhr = new XMLHttpRequest();
                      xhr.open('POST', 'notes.php');
                      xhr.setRequestHeader('Content-Type', 'application/json');
                      xhr.send(JSON.stringify(formData));
                          });
                  </script>
                <td><span class="fa fa-edit mr-1"></span><span class="fa fa-times"></span></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <hr />
        <h2>Neue Notiz anlegen</h2>
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
              <button class="btn btn-success" id="insert-button" type="submit">Anlegen</button>
              <button class="btn btn-danger">Zurücksetzen</button>
            </div>
          </div>
          <script>
            document.getElementById('insert-button').addEventListener("click", function () {

              var name = document.getElementById('name').value;
              var description = document.getElementById('description').value;
              var date = document.getElementById('date').value;
              var time = document.getElementById('time').value;
              var formData = {
                name: name,
                description: description,
                date: date ? date : "do change today", // Todo
                time: time ? time : "do change time", // Todo
              };

              var xhr = new XMLHttpRequest();
              xhr.open('POST', 'notes.php');
              xhr.setRequestHeader('Content-Type', 'application/json');
              xhr.send(JSON.stringify(formData));
            });
          </script>
        </form>
      </div>
    </div>
  </div>
</body>

</html>