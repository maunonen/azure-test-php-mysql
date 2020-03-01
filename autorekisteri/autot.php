<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<h1>Autot</h1>
<?php 
  try {
    $con=  mysqli_connect("localhost","omnia","omnia2020","omnia") or die;
  } catch (Exception $e) {
    $info = $e->getMessage();
  } 

  if (isset($_POST['merkki']) && isset($_POST['vari']) && isset($_POST['rekisterinro'])){
    $merkki = trim(strip_tags( $_POST['merkki'])); 
    $vari = trim(strip_tags( $_POST['vari']));  
    $rekisterinro = trim(strip_tags( $_POST['rekisterinro'])); 

    if ( isset( $_POST['add'])){
      if ((
        $merkki !== "" && $vari !== "" && $rekisterinro !== ""
      )) {
        try {
            $smtp = $con->prepare("INSERT INTO auto (merkki, vari, rekisterinro) VALUE ( ?, ?, ?)"); 
            $smtp->bind_param("sss", $merkki, $vari, $rekisterinro);
            $smtp->execute(); 
            if ( mysqli_insert_id($con) === 0){
              $info = mysqli_error($con); 
            } else {
              $info = "lisatty"; 
            }
          } catch(Exception $e){
            $info = $e->getMessage(); 
            echo $e->getMessage(); 
        }
      }
    }
  }

  if ($_REQUEST['button'] == 'remove'){
    $id = $_GET['id'];    
    try { 
      $result = $con->query("DELETE from auto WHERE id = '$id'");
      if ($result === TRUE) {
        echo "Auto has been removed.";
      } 
      else {
        echo "Virhe: " . $query . "<br>" . $yhteys->error;
      } 
    } catch (Exception $e ){
      $info = $e->getMessage(); 
      echo $e->getMessage();
    }
  }
?>

<form id="autot" method="POST">
    Merkki<br>
    <input id="merkki" type="text" name="merkki"><br>
    Väri<br>
    <input id="vari" type="text" name="vari"><br>
    Rekisteri numero<br>
    <input id="rekisterinro" type="text" name="rekisterinro"><br>
    <button name="add">save</button>
  </form>

<?php 
  $result = $con->query("SELECT * FROM auto");
  echo "
    <table style='width:100%>'
      <tr>
        <th>Merkki</th>
        <th>Väri</th>
        <th>Rekisteri numero</th>
        <th>Action</th>
        <th>Action</th>
      </tr>
  ";
  while( $row = mysqli_fetch_array($result)) {
    echo "<tr>
            <td>".$row['merkki']."</td>
            <td>".$row['vari']."</td>
            <td>".$row['rekisterinro']."</td>
            <td><a href=\"autoupdate.php?id=".$row['id']."&button=update\">Update</a></td>
            <td><a href=\"autot.php?id=".$row['id']."&button=remove\">Remove</a></td> 
          </tr>
    ";
  }

  echo "</table>";
  $con->clos();
?>

</body>
</html>
