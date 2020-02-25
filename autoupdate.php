<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

<?php 
try {
  $con=  mysqli_connect("localhost","omnia","omnia2020","omnia") or die;
} catch (Exception $e) {
  $info =  $e->getMessage();
} 

if ( isset($_POST['backToAuto'])){
  header("Location: http://localhost:8888/autot.php");
}

elseif(isset( $_POST['save'])){
  $merkki = trim(strip_tags($_POST['merkki']));
  $vari = trim(strip_tags($_POST['vari']));
  $rekisterinro = trim(strip_tags($_POST['rekisterinro']));
  $id = $_GET['id'];   
  
  try {

    $smtp = $con->prepare("UPDATE auto SET merkki=?, vari=?, rekisterinro=? WHERE id=?");
    $smtp->bind_param("sssi", $merkki, $vari, $rekisterinro, $id);
    $smtp->execute();
    header("Refresh:0");
    
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

    echo "Save data to Maysql"; 
    $id = $_GET['id'];    
    try {
      $result = $con->query("SELECT * FROM auto WHERE id='$id'");  
    } catch (Exception $e) {
      $info = $e->getMessage(); 
      echo $e->getMessage();
    } 

    $row = mysqli_fetch_array($result); 
    $merkki = $row['merkki'];
    $vari = $row['vari'];
    $rekisterinro = $row['rekisterinro'];
    echo "
      <form method='POST'>
        Etunimi<br>
        <input id='merkki' type='text' name='merkki' value='$merkki'><br>
        Sukunimi<br>
        <input id='vari' type='text' name='vari' value='$vari'><br>
        Rekisteri numero<br>
        <input id='rekisterinro' type='text' name='rekisterinro' value='$rekisterinro'><br>
        <button name='save'>update</button>
        <button name='backToAuto'>Autot</button>
      </form>    
    ";
}
?>
</body>
</html>
