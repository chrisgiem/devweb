<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"pl-PL\">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Rezultat zapytania</title>
	

</head>

<body>

<table width="900" align="center" border="1" bordercolor="#d5d5d5" cellpadding="0" cellspacing="0">     
<tr>
<?php 
ini_set("display_errors", 0);
require_once 'dbconnect.php';
$polaczenie = mysqli_connect($host, $user, $password);
mysqli_query($polaczenie, "SET CHARSET utf8");
mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
mysqli_select_db($polaczenie, $database);

$zapytanietxt = file_get_contents("zapytanie.txt");

$rezultat = mysqli_query($polaczenie, $zapytanietxt);
$ile = mysqli_num_rows($rezultat);

if ($ile>=1) 
{
echo<<<END
<td width="50" align="center" bgcolor="e5e5e5">id</td>
<td width="100" align="center" bgcolor="e5e5e5">tresc</td>
<td width="100" align="center" bgcolor="e5e5e5">odpa</td>
<td width="100" align="center" bgcolor="e5e5e5">odpb</td>
<td width="100" align="center" bgcolor="e5e5e5">odpc</td>
<td width="100" align="center" bgcolor="e5e5e5">odpd</td>
<td width="100" align="center" bgcolor="e5e5e5">answer</td>
<td width="100" align="center" bgcolor="e5e5e5">kategoria</td>
<td width="50" align="center" bgcolor="e5e5e5">rok</td>
</tr><tr>
END;
}
	for ($i = 1; $i <= $ile; $i++) 
	{
		
		$row = mysqli_fetch_assoc($rezultat);
		$id = $row['id'];
		$tresc = $row['tresc'];
		$odpa = $row['odpa'];
		$odpb = $row['odpb'];
		$odpc = $row['odpc'];
		$odpd = $row['odpd'];
		$answer = $row['answer'];
		$kategoria = $row['kategoria'];
		$rok = $row['rok'];		
		
echo<<<END
<td width="50" align="center">$id</td>
<td width="100" align="center">$tresc</td>
<td width="100" align="center">$odpa</td>
<td width="100" align="center">$odpb</td>
<td width="100" align="center">$odpc</td>
<td width="100" align="center">$odpd</td>
<td width="100" align="center">$answer</td>
<td width="100" align="center">$kategoria</td>
<td width="50" align="center">$rok</td>
</tr><tr>
END;
			
	}
	

?>


</tr></table>



</body>
</html>
