<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Les pays</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
<body>
<pre>
<?php
require_once("dao.php");
$dao=new DAO();
$dao->connexion();
if ($dao->getLastError()) print $dao->getLastError();
if (isset($_GET['continent'])){
	if ($_GET['continent']=='Amérique Septentrionale'){
	print 'quatorze';
	$test=$dao->getSelect5();
	$rowsContinent2=$dao->getCalcul6($_GET['continent']);
	} else {
	$test=$dao->getSelect3($_GET['continent']);
	$rowsContinent2=$dao->getCalcul4($_GET['continent']);}
} else {
	$test=$dao->getSelect1();
	$rowsContinent2=$dao->getCalcul2();
}
if (isset($_GET['region'])){
	$region=addslashes($_GET['region']);
	$test=$dao->getSelect7($region);
	$rowsContinent2=$dao->getCalcul8($region);
}
$tableContinent=$dao->getContinent();
$dao->disconnect();
?>
</pre>
<body>
    <h1 class="text-center">Les populations du monde :</h1>
	<article>
	<p>Trier par continent : </p>
	<form method="get">
	<select class="form-select" aria-label="Default select example" id="select" onchange="change()" <?php if (!isset($_GET['continent'])) {if (isset($_GET['region'])){print $_GET['region'];} else {print 'Monde';}} else print $_GET['continent'];?>>
  <option selected disabled>Continent</option>
  <?php foreach($tableContinent as $row) {
	print '<option value = "'.$row['libelle_continent'].'">'.$row['libelle_continent'].'</option>';
}?>
</select>
</form>
<br>
<form>
<select class="form-select" aria-label="Default select example" onchange="change2()" id="select2" <?php if (!isset($_GET['continent']) OR $_GET['continent']=='Amérique Septentrionale') {print 'hidden';} ?>>
<option selected disabled>Région</option>
<?php foreach($test as $row2) {
	print '<option value = "'.$row2['nom'].'">'.$row2['nom'].'</option>';
}?>
</select>
</form>
<br>
	</article>
	<table class="table">
  <thead>
    <tr>
      <th scope="col">Pays</th>
      <th scope="col">Population totale(en milliers)</th>
      <th scope="col">Taux de natalité</th>
      <th scope="col">Taux de mortalité</th>
	  <th scope="col">Espérance de vie</th>
	  <th scope="col">Taux de mortalité infantile</th>
	  <th scope="col">Nombre d'enfant(s) par femme</th>
	  <th scope="col">Taux de croissance</th>
	  <th scope="col">Population de 65 ans et plus(en milliers)</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($test as $row) {
	print "<tr>"."<td>".$row['nom']."</td>"."<td>".$row['pop_pays']."</td>"."<td>".$row['tx_nat']."</td>"."<td>".$row['tx_mort']."</td>"."<td>".$row['espe']."</td>"."<td>".$row['tx_enf']."</td>"."<td>".$row['enf_par_femme']."</td>"."<td>".$row['tx_crois']."</td>"."<td>".$row['pop_plus']."</td>"."</tr>";
}?>
<tr>
<td><?php print $rowsContinent2[0]['nom'];?></td>
<td><?php print $rowsContinent2[0]['pop_pays'];?></td>
<td><?php print $rowsContinent2[0]['tx_nat'];?></td>
<td><?php print $rowsContinent2[0]['tx_mort'];?></td>
<td><?php print $rowsContinent2[0]['espe'];?></td>
<td><?php print $rowsContinent2[0]['tx_enf'];?></td>
<td><?php print $rowsContinent2[0]['enf_femme'];?></td>
<td><?php print $rowsContinent2[0]['tx_crois'];?></td>
<td><?php print $rowsContinent2[0]['pop_plus'];?></td>
</tr>
</tbody>
<script>
	function change() {
			parent.location.href='testdao.php?continent='+document.getElementById('select').options[document.getElementById('select').selectedIndex].value;
		}
		function change2() {
			parent.location.href='testdao.php?region='+document.getElementById('select2').options[document.getElementById('select2').selectedIndex].value;
		}
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
</body>
</html>