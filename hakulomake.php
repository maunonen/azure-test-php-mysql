<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
      //$con=  mysqli_connect("localhost","omnia","omnia2020","sakila") or die;
      $con = mysqli_connect("127.0.0.1:51250", "azure", "6#vWHD_$", "sakila" ) or die;
    } catch (Exception $e) {
      $info = $e->getMessage(); 
      echo "No connection to server". $info;    
    }
    //LIKE '%cat%'
    if (isset ($_POST['title'])){
      
      $title = trim( strip_tags( $_POST['title']));
      // Search button pressed 
      if ( isset( $_REQUEST['search'])) {
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

  <div class="container my-2">
    <div class="row">
      <div class="col">
        <h1 class="display-6 text-left my-2">Haku lomake</h1>
          <form id="film" method="POST">
            <div class="form-group">
              <label for="title">
              <input type="text" class="form-control" placeholder="title" id="title" name="title">
              <button type="submit" class="btn btn-outline-secondary mt-2" name="search">Search</button>
            </div>
          </form>          
      </div>
    </div>
  
  <?php 
  try { 
    if ($result->num_rows > 0) {
      
      echo "
          <div class='row'>
            <div class='col'>
            <table class='table table-hover'>
              <thead class='thead-dark'>
                <tr>
                  <th scope='col'>Name</th>
                  <th scope='col'>Description</th>
                  <th scope='col'>Rating</th>
                  <th scope='col'>Release</th>
                </tr>
              </thead>
            <tbody>";
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
    
    //End of film card
      echo "
              </tbody>
            </table>    
            </div>
          </div>";
    }
    else {
      
        echo "
              <div class='row'>
                <div class='col'>
                  <p>Nothing found</p>
                </div>
              </div>";
    };
    $con->close();
  } catch (Exception $e) {
    $info = $e->getMessage();
    echo $e->getMessage();
  }
?>
  <!--  End of container -->
  </div>
</body>
</html>