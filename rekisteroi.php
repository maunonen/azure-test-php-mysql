<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Rekister auto</title>
  <style>
    .search {
      width : 50%; 
      float : left;  

    }
    .searchbox {
      width : 100%; 
    }
  </style>

</head>
<body>
  <h1>Rekisteroi auto</h1>
  <div class="searchbox">

  <?php
    try {
      $con=  mysqli_connect("localhost","omnia","omnia2020","omnia") or die;
    } catch (Exception $e) {
      $info = $e->getMessage();
    } 

  
   ?>
    <!-- search form for auto -->
    <div id="" class="search">
      <h2>Search auto<h2>
      <form method="post">
        Merkki<br>
        <input id='merkki' type='text' name='merkki'><br>
        Vari<br>
        <input id='vari' type='text' name='vari'><br>
        Rekisteri numero<br>
        <input id='rekisterinro' type='text' name='rekisterinro'><br>
        <button name='save'>Search auto</button>
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
          echo 
            "<tr>
              <td>".$row['merkki']."</td>
              <td>".$row['vari']."</td>
              <td>".$row['rekisterinro']."</td>
              <td><a href=\"autoupdate.php?id=".$row['id']."&button=update\">Update</a></td>
              <td><a href=\"autot.php?id=".$row['id']."&button=remove\">Remove</a></td> 
            </tr>";
        }
        echo "<table>";
        $con->clos();
      ?>
    </div>

  <!-- Search form for Henkilot -->

  <div id="" class="search">
    <h2>Search auto<h2>
    <form method="post">
      Merkki<br>
      <input id='merkki' type='text' name='merkki'><br>
      Vari<br>
      <input id='vari' type='text' name='vari'><br>
      Rekisteri numero<br>
      <input id='rekisterinro' type='text' name='rekisterinro'><br>
      <button name='save'>Search auto</button>
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
        echo 
          "<tr>
            <td>".$row['merkki']."</td>
            <td>".$row['vari']."</td>
            <td>".$row['rekisterinro']."</td>
            <td><a href=\"autoupdate.php?id=".$row['id']."&button=update\">Update</a></td>
            <td><a href=\"autot.php?id=".$row['id']."&button=remove\">Remove</a></td> 
          </tr>";
      }
      echo "<table>";
      $con->clos();
    ?>
  </div>
  <!-- finish of henkilot  -->
  </div>
  
  
  

</body>
</html>