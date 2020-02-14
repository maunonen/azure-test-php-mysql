<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Henkilot</h1>
  <?php
  
  try {
    $con=  mysqli_connect("localhost","omnia","omnia2020","omnia") or die;
  } catch (Exception $e) {
    $info =  $e->getMessage();
  } 

  if ( isset($_POST['etunimi']) && isset($_POST['sukunimi']) &&
       isset($_POST['htunnus']) && isset($_POST['maa']) && 
       isset($_POST['kaupunki']) && isset($_POST['postinumero']) ){ 

    $etunimi = trim(strip_tags($_POST['etunimi']));
    $sukunimi = trim(strip_tags($_POST['sukunimi']));
    $htunnus = trim(strip_tags($_POST['htunnus']));
    $maa = trim(strip_tags($_POST['maa']));
    $kaupunki = trim(strip_tags($_POST['kaupunki']));
    $postinumro = trim(strip_tags($_POST['postinumero']));
    $katuosoite = trim(strip_tags($_POST['katuosoite']));
    $puhelinnumero = trim(strip_tags($_POST['puhelinnumero']));
    
    if ( isset($_POST['add'])){
      if ((
            $etunimi !== "" && $sukunimi !== "" && $htunnus !== "" && 
            $maa !== "" && $kaupunki !== "" && $postinumro !=="" && 
            $katuosoite !== "" && $puhelinnumero !== "" )){
        try {
          $smtp = $con->prepare("INSERT INTO henkilot (etunimi, htunnus, katuosoite, kaupunki, maa, postinumero, puhelinnumero, sukunimi) VALUES (?, ?, ?, ?, ?, ?, ?, ? )");
          $smtp->bind_param("ssssssss", $etunimi, $htunnus, $katuosoite, $kaupunki, $maa, $postinumro, $puhelinnumero, $sukunimi); 
          $smtp->execute();
          if (mysql_inset_id($con) === 0){
            $info = mysqli_error($con);
          } 
          else {
            $info = "lisatty"; 
          }
        } catch (Exception $e) {
          $info = $e->getMessage(); 
          echo $e->getMessage();
        } 
        header("Refresh:0");
    }
    } 
  }

  if ($_REQUEST['button'] == 'remove'){
    $id = $_GET['id'];    
    try { 
      $result = $con->query("DELETE from henkilot WHERE id = '$id'");
      if ($result === TRUE) {
        echo "Person has been removed.";
      } 
      else {
        echo "Virhe: " . $query . "<br>" . $yhteys->error;
      } 
    } catch (Exception $e ){
      $info = $e->getMessage(); 
      echo $e->getMessage();
    }
  }

  echo "<div id='info'><p>$info</p></div>"

  ?>  
  <form id="henkilot" method="POST">
    Etunimi<br>
    <input id="etunimi" type="text" name="etunimi"><br>
    Sukunimi<br>
    <input id="sukunimi" type="text" name="sukunimi"><br>
    Henkilötunnus<br>
    <input id="htunnus" type="text" name="htunnus"><br>
    Puhelinnumero<br>
    <input id="puhelinnumero" type="text" name="puhelinnumero"><br>
    Maa<br>
    <input id="maa" type="text" name="maa"><br>
    Kaupunki<br>
    <input id="kaupunki" type="text" name="kaupunki"><br>
    Postinumero<br>
    <input id="postinumero" type="text" name="postinumero"><br>
    Katuosoite<br>
    <input id="katuosoite" type="text" name="katuosoite"><br>
    <button name="add">save</button>
  </form>

  <?php
    
    $result = $con->query("SELECT * FROM henkilot");
    echo '<table style="width:100%">
            <tr>
            <th>Etunimi</th>
            <th>Sukunimi</th>
            <th>Katuosoite</th>
            <th>Kaupunki</th>
            <th>Maa</th>
            <th>Puhelinnumero</th>
            <th>Action</th>
            <th>Maa</th>
          </tr>';

    while ( $row = mysqli_fetch_array($result)){
    
    echo "<tr>
            <td>".$row['etunimi']."</td>
            <td>".$row['sukunimi']."</td>
            <td>".$row['katuosoite']."</td>
            <td>".$row['kaupunki']."</td>
            <td>".$row['maa']."</td>
            <td>".$row['puhelinnumero']."</td>
            <td><a href=\"updateform.php?id=".$row['id']."&button=update\">Update</a></td>
            <td><a href=\"henkilot.php?id=".$row['id']."&button=remove\">Remove</a></td> 
          </tr>";
    }
    echo "</table>";
    $con->close(); 

  ?>
</body>
</html>