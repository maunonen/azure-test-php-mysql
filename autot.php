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
    $info =  $e->getMessage();
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
      </tr>
  ";
  while( $row = mysqli_fetch_array($result)) {
    echo "<tr>
            <td>".$row['merkki']."</td>
            <td>".$row['vari']."</td>
            <td>".$row['rekisterinro']."</td>
          </tr>
    ";
  }

  echo "<table>";
  $con->clos();
?>

  
</body>
</html>