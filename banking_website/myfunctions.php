<?php

//GET function for smart input
function GET($fieldname, &$flag){
	global $db ;
	$v = $_GET [$fieldname];
	$v = trim ( $v );
	if ($v == "") 
	  { $flag = true ; echo "<br><br>$fieldname is empty." ; return  ;} ;
	$v = mysqli_real_escape_string ($db, $v );
	return $v; 
}

//authenticates user in AA table by verifying hashed pass with plaintext pass
function authenticate ($UCID, $pass, $db ) 
{
	global $t ; 
	$s    = "select * from AA where UCID='$UCID'";
	print "<br>The SQL select statement from AA is: $s <br>";
	($t = mysqli_query ($db, $s) ) or die ( mysql_error($db) ) ;
	
	$num = mysqli_num_rows ( $t ) ;
	print "<br> The number of rows that were retrieved for $UCID are: $num <br>";
	
	$r   = mysqli_fetch_array( $t , MYSQLI_ASSOC ) ;
	$hpass = $r["pass"];
	print "<br> The hashed password that was retrieved for $UCID is: $hpass <br>";
	
	if ( password_verify($pass,$hpass )) {return true;} else { return false;};
}

// display function to show everything in AA& TT table for the given UCID and account
function display ($UCID, $account, &$output, $db ) 
{
	//display the UCID from AA
	$aa = "select * from AA where UCID='$UCID' and account='$account'";
	$output.= "<br> The SQL statement for AA is: $aa <br>" ;
	$sr = mysqli_query($db,$aa) or die(mysqli_error($db));
	$output.= "<br>The Account ($account) for $UCID from AA:<br>";
	$output.= "<br><table border=3 cellpadding=5>";
	$output.= "<tr>";
	$output.=  "<th>UCID</th>"        ;
	$output.=  "<th>account</th>"     ;
	$output.=  "<th>pass</th>"        ;
	$output.=  "<th>name</th>"        ;
	$output.=  "<th>mail</th>"        ;
	$output.=  "<th>initial</th>"     ;
	$output.=  "<th>current</th>"     ;
	$output.=  "<th>recent</th>"      ;
	$output.=  "<th>plaintext</th>"   ;
	$output.=  "</tr>";
	while ( $r = mysqli_fetch_array ( $sr, MYSQLI_ASSOC) ) 
	{ 
		$UCID       = $r[ "UCID"      ];
		$pass       = $r[ "pass"      ]; 
		$name       = $r[ "name"      ];
		$mail       = $r[ "mail"      ];
		$initial    = $r[ "initial"   ];
		$current    = $r[ "current"   ];
		$recent     = $r[ "recent"    ];
		$plaintext  = $r[ "plaintext" ];
		$output.=  "<tr>";
		$output.=  "<td>$UCID</td>"        ;
		$output.=  "<td>$account</td>"     ;
		$output.=  "<td>$pass</td>"        ;
		$output.=  "<td>$name</td>"        ;
		$output.=  "<td>$mail</td>"        ;
		$output.=  "<td>$initial</td>"     ;
		$output.=  "<td>$current</td>"     ;
		$output.=  "<td>$recent</td>"      ;
		$output.=  "<td>$plaintext</td>"   ;
		$output.=  "</tr>";
	}	
	$output.=  "</table>";
	
	//display the transactions from TT for that account
	$s  = "select * from TT where UCID='$UCID' and account= '$account'";
	$output.= "<br> The SQL statement for TT is: $s <br>" ;
	($t = mysqli_query ($db, $s) ) or die ( mysqli_error($db) ) ;
	$output.= "<br>Here are the transactions for $UCID's account $account from TT: <br>";
	$output.= "<br><table border=3 cellpadding=5>";
	$output.=  "<tr>";
	$output.=  "<th>UCID</th>"   ;
	$output.=  "<th>account</th>"   ;
	$output.=  "<th>type</th>"   ;
	$output.=  "<th>amount</th>"  ;
	$output.=  "<th>date</th>"    ;
	$output.=  "<th>mail</th>"   ;
	$output.=  "</tr>";
	while ( $r = mysqli_fetch_array ( $t, MYSQLI_ASSOC) ) 
	{ 
		$UCID   = $r[ "UCID"  ];
		$type   = $r[ "type"  ]; 
		$amount = $r[ "amount"];
		$date   = $r[ "date"  ];
		$mail   = $r[ "mail"  ];
		$output.=  "<tr>";
		$output.=  "<td>$UCID</td>"     ;
		$output.=  "<td>$account</td>"  ;
		$output.=  "<td>$type</td>"     ;
		$output.=  "<td>$amount</td>"   ;
		$output.=  "<td>$date</td>"     ;
		$output.=  "<td>$mail</td>"     ;
		$output.=  "</tr>";
	}	
	$output.= "</table>";
	$output.= "<br>Bye!" ;
	$output.= "<br>Interaction completed.<br>" ;
}
?>