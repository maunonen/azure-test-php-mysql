<html>
<head>
	<title>foo</title>
	<style>
		body {width:60%;margin:50px auto 50px auto;}
		* {margin:0;padding:0;	font-family:Verdana, Geneva, sans-serif;font-size:10px;}
		h1 {font-size:20px;padding:6px;margin-bottom:25px}
		input {padding:1px;margin:1px;width:200px;}
		input[type="submit"]{float:left;height:30px;background-color:#585;color:#FFF;margin-top:25px;margin-bottom:25px;}	
		.gen {margin-left:-25px;width:100px; float:left;text-align:center;}
		p {clear:both;margin-bottom:5px;margin-top:5px;color:#585;text-decoration:underline}
		datalist {display:none;}
		.edit:hover>.gen {background-color:#f00;}
		#poi, #muu {width:70px;display:none;} 
		#info {position:absolute;top:80px;
		}
	</style>
	<script>
		function edit (id,merkki,vari,rek){
			document.getElementById("input1").value = rek;
			document.getElementById("input2").value = merkki;
			document.getElementById("input3").value = vari;
			document.getElementById("input4").value = id;
			document.getElementById("poi").style.display = "block";
			document.getElementById("muu").style.display = "block";
			document.getElementById("lis").style.width = "70px";
			//document.getElementById("lis").disabled  = true;
			//document.getElementById("lis").style.display = "none";	
			document.getElementById("info").innerHTML="&nbsp;";
		}
</script>
</head>
<body>
	<h1>Autorekisteri<br><h1>
	<?php

  try {
    $con=  mysqli_connect("localhost","omnia","omnia2020","omnia") or die;
  } catch (Exception $e) {
    $info =  $e->getMessage();
  } 

	if (isset($_POST['REK']) && isset($_POST['MERK']) && isset($_POST['VARI'])){
		$reknro = strtoupper(trim(strip_tags($_POST['REK'])));
		$merkki = trim(strip_tags($_POST['MERK']));
		$vari = trim(strip_tags($_POST['VARI']));
		if (isset($_POST['lisaa'])) {
			if ($reknro !=="" && $merkki !=="" && $vari !==""){
				$result= $con->query("INSERT INTO auto(rekisterinro, merkki, vari) VALUES ('$reknro','$merkki','$vari')");
				if(mysqli_insert_id($con)===0)
					$info = mysqli_error($con) ;
				else $info = "lisätty" ;
			}
			else {
				$info = "Ei lisätty.. Tyhjiä kenttiä..";
			}
		} else if (isset($_POST['id']) && isset($_POST['poista'])){
			$id = trim(strip_tags($_POST['id']));
			$result= $con->query("DELETE FROM auto WHERE id = '$id'");
			$info = "poistettu!";
		} else if (isset($_POST['id']) && isset($_POST['muuta'])){
			$id = trim(strip_tags($_POST['id']));
			$result= $con->query("UPDATE auto SET rekisterinro='$reknro',merkki='$merkki',vari='$vari' WHERE id='$id'");
			$info = "muutettu";
		}
	} 
  
	
  echo "<div id='info'><p>$info</p></div>";
	?>
	<form method="POST" >
		Rekisterinumero<br>
		<input id="input1" type="text" name="REK" autocomplete="off"><br>
		Merkki<br>
		<input id="input2" list="merkit" name="MERK" autocomplete="off"><br>
		<datalist id="merkit">
			<option value="BMW">
			<option value="mersu">
			<option value="kia">
			<option value="lada">
			<option value="opel">
		</datalist>
		Väri<br>
		<input id="input3" list="varit" name="VARI" autocomplete="off"><br>
		<datalist id="varit">
			<option value="sininen">
			<option value="punainen">
			<option value="vihreä">
			<option value="keltainen">
			<option value="orassi">
			<option value="musta">
			<option value="valkoinen">
		</datalist>
		<input id="input4" name='id' type="hidden" value="0">
		<input id="lis" type="submit" name="lisaa" value="lisää">
		<input id="poi" type="submit" name="poista" value="poista">
		<input id="muu" type="submit" name="muuta" value="muuta">
		<br>
	</form>
​
	<p>viimeiset 15:</p><br>
	<div class='gen'><b><u>Merkki:</u></b></div>
	<div class='gen'><b><u>Rekisterinro:</u></b></div>
	<div class='gen'><b><u>Väri:</u></b></div><br>
	</div>
​
<?php
//$result = $con->query("SELECT * from auto");
$result = $con->query("SELECT id, rekisterinro, merkki, vari from auto ORDER BY id DESC limit 15");
 while($row = mysqli_fetch_array($result)){
    echo "<div class='edit' onclick='edit(\"".$row['id']."\",\"".$row['merkki']."\",\"".$row['vari']."\",\"".$row['rekisterinro']."\")'>";
    echo "<div class='gen'>".$row['merkki']."</div><div class='gen'>".$row['rekisterinro']."</div><div class='gen'>".$row['vari']."</div></div><br>";
 }
?>
​
</body>
</html>
