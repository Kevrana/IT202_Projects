<?php

//echos the accounts from AA for the given UCID
$s = "select * from AA where UCID = '$UCID'";
$sr = mysqli_query($db, $s) or die(mysqli_error($db));

while ( $r = mysqli_fetch_array ( $sr, MYSQLI_ASSOC) ) 
	{ 
		$account       = $r[ "account"      ];
		$current       = $r[ "current"      ];
		echo "<input type='radio' name='account' value='$account'> Account $account , with Current Balance: $ $current";
		echo "<br>";
	}
?>