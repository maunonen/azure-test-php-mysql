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

<!-- 
  To do list. 
  0. Bootstrap bootswatch.com 
  1. Make include connect. 

  2. Make menu with categories. 
      https://www.php.net/manual/ru/reserved.variables.post.php
      <form ....>
        <input name="person[0][first_name]" value="john" />
        <input name="person[0][last_name]" value="smith" />
        ...
        <input name="person[1][first_name]" value="jane" />
        <input name="person[1][last_name]" value="jones" />
       
        //var_dump($_POST['person']);
        will get you something like:
        //array (
        //0 => array('first_name'=>'john','last_name'=>'smith'),
        //1 => array('first_name'=>'jane','last_name'=>'jones'),
        //)

      </form>


  3. RegExpression on server side. 
  4. Try to do with MVC. 
  5. Get familiar with bit operator to make where for filter by categories. 
  6. 
  
  

-->
  <?php 
        
  try {
      // gitbdfbd
      $con=  mysqli_connect("localhost","omnia","omnia2020","sakila") or die;
      //$con = mysqli_connect("127.0.0.1:51250", "azure", "6#vWHD_$", "sakila" ) or die;
        
      $catResult = $con->query("select category_id, name from category");
      //echo var_dump($catResult);
      
    } catch (Exception $e) {
      $info = $e->getMessage(); 
      echo "No connection to server". $info;    
    }
  
  ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/films/addfilm.php">Add New</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <form action="hakulomake.php" method="post">
          <?php 
            while( $row = $catResult->fetch_assoc() ){
              echo "<button 
                class='btn dropdown-item btn-link' 
                role='button'
                type='submit'
                value=".$row['category_id']."
                name='category'
              >
              ".$row['name']."</button>";
            }
          ?>
          </form>
        </div>
      </li>
    </ul>
  </div>
  <form class="form-inline my-2 my-lg-0" id="film" method="POST">
      <input class="form-control mr-sm-2" type="search" placeholder="title" aria-label="Search" name="title" id="title">
      <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="search">Search</button>
    </form>
</nav>

<?php

    $result; 
    echo "
      <div class='container'>
        <div class='row'>
          <div class='col'>
            <table class='table table-hover mt-3'>
                <thead class='thead-dark'>
                  <tr>
                    <th scope='col'>Name</th>
                    <th scope='col'>Description</th>
                    <th scope='col'>Rating</th>
                    <th scope='col'>Release</th>
                  </tr>
                </thead>
              <tbody>";
    

    if (isset ($_POST['title'])){
      
      global $result;
      $title = trim( strip_tags( $_POST['title']));
      // Search button pressed 
      if ( isset( $_REQUEST['search'])) {
        if( $title !== ""){
            try {
              $result = $con->query("SELECT * FROM film WHERE title LIKE '%$title%'");
              if ($result->num_rows > 0) {
                echo "<h3 class=\"display-6 text-left my-2\">Total films - $result->num_rows</h3>";
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
              } else {
                  echo "<h1 class=\"display-6 text-left my-2\">Nothing found</h1>";
              }
            } catch ( Exception $e){
              $info = $e->getMessage();
              echo $e->getMessage();
            }
        }
      }
    } 
    elseif ( isset ($_POST['category'])) {

        global $result;
        $category = trim(strip_tags($_POST['category']));
        if ($category !== null ){
          try { 

            //name, Description, rating, release
            //$result = $con->query(" ");
            $result = $con->query(" 
                SELECT film.title, film.description,  film.rating , film.release_year
                FROM film
                LEFT JOIN film_category
                ON film_category.film_id=film.film_id
                WHERE film_category.category_id='$category';"
            );
            
            if ($result->num_rows > 0) {
              
              echo "<h3 class=\"display-6 text-left my-2\">Total films in category:  $result->num_rows</h3>";
              while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>".$row['title']."</td>
                    <td>".$row['description']."</td>
                    <td>".$row['rating']."</td>
                    <td>".$row['release_year']."</td>
                  </tr>
                  ";
                };
            } else {
              echo "<h1 class=\"display-6 text-left my-2\">Nothing found</h1>";
            }
          } catch ( Exception $e){ 
            $info = $e->getMessage(); 
            echo $e->getMessage(); 
          }
        }
    }
     echo "  </tbody>
            </table>";  

     
      
    
    //End of film card
     
  ?>  




      
      <?php 
  /* try { 
    if ($result->num_rows > 0) {
      
      echo "
          <table class='table table-hover mt-3'>
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
      echo "  </tbody>
            </table>";    
    }
    else {
      echo "<h1 class=\"display-6 text-left my-2\">Nothing found</h1>";
    };
    $con->close();
  } catch (Exception $e) {
    $info = $e->getMessage();
    echo $e->getMessage();
  } */
?>
      
      </div>
    </div>
  </div>
  
  
  <!--  End of container -->
  </div>
</body>
</html>