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
	
	/*$loggedIn = false;

	if ($loggedIn == true) {
		echo "You are logged in";
	} else {
		echo "Please log in";
	}
	*/
	//$person1 = "Alice";
	//$person2 =  "Bob";
	$people = array("Alice", "Bob", "Catherine");
	//print_r($people);
	//echo $people[2];
	foreach ($people as $person) {
		echo $person . ' ';
	}
	$numbers = array(5, 3, 7);
	$sum = 0;

	foreach ($numbers as $number) {
		$sum = $sum + $number;
	}

	echo $sum;
	

?>

<form action="process.php" method="post">
	Enter your name: <input name="name" type="text">
	<input type="submit">
</form>

</body>
</html>
