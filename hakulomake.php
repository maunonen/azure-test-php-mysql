<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Hakulomake</title>
  <!-- 
    1. Toteuta yksinkertainen hakulomake, 
    jolla voi hakea elokuvan nimellä tai nimen osalla. 
    Hakutuloksissa näytetään 
    elokuvan nimi, kuvaus, ikäraja ja julkaisuvuosi.
  -->
</head>
<body>
  <?php
  
    try {
      $con = mysqli_connect("localhost", "omnia", "omnia2020", "sakila" ) or die;
    } catch (Exception $e) {
      $info = $e->getMessage(); 
      echo "No connection to server". $info;    
    }
    //LIKE '%cat%'
    if (isset ($_POST['title'])){
      $title = trim( strip_tags( $_POST['title']));
      // Search button pressed 
      if ( isset( $_POST['search'])) {
        if( $title !== ""){
            try {
              $result = $con->query("SELECT * FROM film WHERE title LIKE '%$title%'");
            } catch ( Exception $e){
              $info = $e->getMessage();
              echo $e->getMessage();
            }
        }
      }

    }
  ?>  
  <h1>Hakulomake</h1>
  
  <form id="film" method="POST">
    Name: <br>
    <input id="title" type="text" name="title"><br>
    <button name="search">Search</button>
  </form>
  </tr>
  <?php 

  try { 
    if ($result->num_rows > 0) {
      echo "
        <table style='width:70%'>
          <tr>
            <th>Film name</th>
            <th>Description</th>
            <th>Rating</th>
            <th>Release</th>
          </tr>
      ";
      while($row = $result->fetch_assoc()) {
          echo "
              <tr>
                <td>".$row['title']."</td>
                <td>".$row['description']."</td>
                <td>".$row['rating']."</td>
                <td>".$row['release_year']."</td>
              </tr>
          ";
      };    
      echo "</table>";
    }
    else {
        echo "No results";
    };
    $con->close();
  } catch (Exception $e) {
    $info = $e->getMessage();
    echo $e->getMessage();
  }
?>
</body>
</html>