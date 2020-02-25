<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<h1>Please update user data</h1>
<?php 

try {
  $con=  mysqli_connect("localhost","omnia","omnia2020","omnia") or die;
} catch (Exception $e) {
  $info =  $e->getMessage();
} 

if(isset( $_POST['backToHenkilot'])){
  header("Location: http://localhost:8888/henkilot.php"); 
}

if(isset( $_POST['save'])){
  $etunimi = trim(strip_tags($_POST['etunimi']));
  $sukunimi = trim(strip_tags($_POST['sukunimi']));
  $htunnus = trim(strip_tags($_POST['htunnus']));
  $maa = trim(strip_tags($_POST['maa']));
  $kaupunki = trim(strip_tags($_POST['kaupunki']));
  $postinumero = trim(strip_tags($_POST['postinumero']));
  $katuosoite = trim(strip_tags($_POST['katuosoite']));
  $puhelinnumero = trim(strip_tags($_POST['puhelinnumero']));
  $id = $_GET['id'];   
  
  try {
    $smtp = $con->prepare("UPDATE henkilot SET etunimi='$etunimi', htunnus='$htunnus', katuosoite='$katuosoite', kaupunki='$kaupunki', maa='$maa', postinumero='$postinumero', puhelinnumero='$puhelinnumero', sukunimi='$sukunimi' WHERE id='$id'");
    $smtp->bind_param("ssssssssi", $etunimi, $tunnus, $katuosoite, $kaupunki, $maa, $postinumero, $puhelinnumero, $sukunimi , $id);
    $smtp->execute();
    header("Refresh:0");
    //header("Location: http://localhost:8888/henkilot.php");
    if ( mysql_insert_id($con)=== 0) {
      $info = mysql_error($con);
    } else {
      $info = "updated";
    }
  } catch (Exception $e) {
    $info = $e->getMessage(); 
    echo $e->getMessage();
  } 
}

elseif ($_REQUEST['button'] == 'update'){

    $id = $_GET['id'];    
    try {
      $result = $con->query("SELECT * FROM henkilot WHERE id='$id'");  
    } catch (Exception $e) {
      $info = $e->getMessage(); 
      echo $e->getMessage();
    } 

    $row = mysqli_fetch_array($result); 
    $etunimi = $row['etunimi'];
    $sukunimi = $row['sukunimi'];
    $htunnus = $row['htunnus'];
    $maa = $row['maa'];
    $kaupunki = $row['kaupunki'];
    $postinumro = $row['postinumero'];
    $katuosoite = $row['katuosoite'];
    $puhelinnumero = $row['puhelinnumero'];

    echo "
      <form method='POST'>
        Etunimi<br>
        <input id='etunimi' type='text' name='etunimi' value='$etunimi'><br>
        Sukunimi<br>
        <input id='sukunimi' type='text' name='sukunimi' value='$sukunimi'><br>
        Henkilötunnus<br>
        <input id='htunnus' type='text' name='htunnus' value='$htunnus'><br>
        Puhelinnumero<br>
        <input id='puhelinumero' type='text' name='puhelinnumero' value='$puhelinnumero'><br>
        Maa<br>
        <input id='maa' type='text' name='maa' value='$maa'><br>
        Kaupunki<br>
        <input id='kaupunki' type='text' name='kaupunki' value='$kaupunki'><br>
        Postinumero<br>
        <input id='postinumero' type='text' name='postinumero' value='$postinumro'><br>
        Katuosoite<br>
        <input id='katuosoite' type='text' name='katuosoite' value='$katuosoite'><br>
        <button name='save'>update</button>
        <button name='backToHenkilot'>Henkilot rekisteri</button>
      </form>    
    ";
}
?>
</body>
</html>
