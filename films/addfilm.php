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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Add New Film</title>


  
</head>
<body>

  <!-- 
    Toteuta lomake, jolla voi lisätä tietokantaan uuden elokuvan 
    //(nimi, kuvaus, julkaisuvuosi, kieli, vuokra-aika, vuokrahinta, 
    pituus, korvaushinta, ikäraja, special features //). 
    Vihje: kieltä varten tee pudotusvalikko, 
    jonka value-arvoina käytät tietokannasta löytyviä language_id-arvoja 
    ja näytettävänä tekstinä vastaavaa kielen nimeä. 
    Tätä ei tarvitse hakea tietokannasta, 
    vaan voit ns. "kovakoodata" arvot lomakkeeseen.
  -->

  <?php 
  
  // get langaugeResult 

  try {
      // gitbdfbd
        $con=  mysqli_connect("localhost","omnia","omnia2020","sakila") or die("No connection to server");
      //$con = mysqli_connect("127.0.0.1:51250", "azure", "6#vWHD_$", "sakila" ) or die("No connection to server");
      $lanResult = $con->query("SELECT language.language_id , language.name FROM language");
      
    } catch (Exception $e) {
      $info = $e->getMessage(); 
      echo "No connection to server". $info;    
    }
  // 
  ?>

  <?php

if (
      isset($_POST['title']) && isset($_POST['description']) && isset($_POST['release_year']) &&
      isset($_POST['language']) && isset($_POST['rental_duration']) && isset($_POST['rental_price']) &&
      isset($_POST['film_length']) && isset($_POST['replacement_cost']) &&
      isset($_POST['rating']) && isset($_POST['special_features'])
    ){
      
      $title = (string)trim(strip_tags( $_POST['title']));
      $description = (string)trim(strip_tags($_POST['description']));
      $release_year = (int) trim(strip_tags($_POST['release_year']));
      $language = (int) trim(strip_tags($_POST['language']));
      $rental_duration = (int) trim(strip_tags($_POST['rental_duration'])); 

      $rental_price = (double)trim(strip_tags($_POST['rental_price'])); 
      $film_length = (int)trim(strip_tags($_POST['film_length'])); 
      $replacement_cost =(double)trim(strip_tags($_POST['replacement_cost']));
      $rating = (string) trim( strip_tags( $_POST['rating']));
      $special_features = (string)trim(strip_tags( $_POST['special_features'])); 
      
      if (isset($_POST['addfilm'])){
       
        if ( 
          $title !== "" && $description !== "" && $release_year !== "" && 
          $language !== "" && $rental_duration !== "" && $rental_price !== "" && 
          $film_length !== ""  && $replacement_cost !== "" && 
          $rating !== "" && $special_features !== "" 
        ){
            
            try {
              $smtp = $con -> prepare("
                                      INSERT INTO film ( 
                                        title, description, release_year, language_id, 
                                        rental_duration, rental_rate, length, replacement_cost, 
                                        rating, special_features 
                                      ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                      
              $smtp->bind_param('ssiiididss', $title, $description, $release_year, $language, 
                                      $rental_duration, $rental_price, $film_length, $replacement_cost, 
                                      $rating, $special_features ); 
              $smtp->execute(); 
              $info = mysqli_error($con); 
              if(mysqli_insert_id($con) === 0){
                $info = mysqli_error($con); 
                echo "<h1>ERROR.$info</h1>"; 
              } else { 
                $info = "added"; 
              }

            } catch (Exception $e ){
              $info  = $e->getMessage();
              echo $e->getMessage(); 
            }
        } else {
          echo "<h1>Not all fields provided</h1>"; 
        }

      }
  } else {
    /* echo "<h1>ADD FILM DATA didn't provide</h1>"; 
    echo "POST" . var_dump($_POST) ; */
  }

  ?> 
  

<div class="container">
  <div class="row">
    <div class="col-6">
      <h1 class="display-6 text-left my-2">Add new film</h1> 
      <form id="newfilm" method="POST">
        <div class="row">
          <div class="col my-2">
            <label for="name">Name</label>
            <input 
              class="form-control" 
              name="title"
              type="text" 
              placeholder="title" 
              id="title" 
            >
          </div>
        </div>
        <div class="row mb-2">
            <div class="col">
            <label for="description">Description</label>
            <textarea 
              class="form-control" 
              aria-label="With textarea"
              name="description"
              type="text" 
              placeholder="description" 
              id="description" 
            >
            </textarea>
          </div>
        </div>          
        <div class="row">
            <div class="col-md">
                <label for="release_year">Release year</label>
                <input 
                  class="form-control my-1" 
                  name="release_year"
                  type="text" 
                  placeholder="release year" 
                  id="release_year" 
                >
            </div>
            <div class="col-md">
              <label for="language">Language</label>
              <select class="custom-select my-1" name="language" id="language" aria-label="select with button addon">
                <option selected>Language...</option>
                <?php 
                  while ($row = $lanResult->fetch_assoc()){
                    echo "
                      <option value=".$row['language_id'].">".$row['name']."</option>
                    "; 
                }
                ?>
              </select>  
            </div>
        </div>
          
        <div class="row">
        
          <div class="col-md">
            <label for="rental_duration">Rental duration</label>
            <input 
              class="form-control my-1" 
              name="rental_duration"
              type="text" 
              placeholder="rental duration" 
              id="rental_duration" 
            >
          </div>
          <div class="col-md">
            <label for="rental_price">Price</label>
            <input 
              class="form-control my-1" 
              name="rental_price"
              type="text" 
              placeholder="rental price" 
              id="rental_price" 
            >
          </div>
        </div>  
        <div class="row">
          <div class="col-md">
            <label for="film_length">Length</label>
            <input 
              class="form-control my-1" 
              name="film_length"
              type="text" 
              placeholder="rental length" 
              id="film_length" 
            >
          </div>
          <div class="col-md">
            <label for="replacement_cost">Replacement cost</label>
            <input 
              class="form-control my-1" 
              name="replacement_cost"
              type="text" 
              placeholder="replacement cost" 
              id="replacement_cost" 
            >
          </div>  
        </div>
          

        <div class="row">
          
          <div class="col-md">
            <label for="rating">Rating</label>
            <select class="custom-select my-1" id="rating" aria-label="select with button addon" name="rating">
            <option selected>Rating...</option>
            <option value="G">G</option>
            <option value="PG">PG</option>
            <option value="PG-13">PG-13</option>  
            <option value="R">R</option>
            <option value="NC-17">NC-17</option>
          </select>
          </div>
        
        </div> 
          
        <div class="row">
          <div class="col">
            <label for="special_features">Special features</label>
            <select multiple class="form-control" id="special_features" name="special_features">
              <option>Trailers</option>
              <option>Commentaries</option>
              <option>Behind the Scenes</option>
              <option>Deleted Scenes</option>
            </select>
          </div>
        </div>  
        <button type="submit" class="btn btn-primary my-2" name="addfilm" id="sendFilm">Send</button>
      </form>
    </div>
  </div>
</div>




<script>

$(document).ready(function(){
  
$("#sendFilm").submit(function(event){

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    alert("")

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = $.ajax({
        url: "/form.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Hooray, it worked!");
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});


});


</script>  
  
</body>
</html>