<html>
<head>
<title>1 php</title>
</head>
<body>
1 php

<?php
/*	$myvar = "This is my variable";
	$number = 5;
	$number2 = 3;
	$sum = $number + $number2;
	$name = "Jake";
	echo "Hello world php";
	echo $myvar;
	echo $sum;
	echo "Hello, " . $name;
	($x == $y) //czy jest rowne
	($x !== $y) //czy nie jest rowne
	//($x or $y)i
*/	
	$loggedIn = false;

	if ($loggedIn == true) {
		echo "You are logged in";
	} else {
		echo "Please log in";
	}
?>

<form action="process.php" method="post">
	Enter your name: <input name="name" type="text">
	<input type="submit">
</form>

</body>
</html>
