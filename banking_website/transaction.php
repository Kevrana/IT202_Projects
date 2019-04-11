<style>
	body {background-color: lightyellow;}
</style>
<?php
//loads the functions file
include ( "myfunctions.php" );

//cookie and continue session
session_set_cookie_params ( 0, "/~kr276/it202/assignment2/", "web.njit.edu");
session_start();

//barrier
if ( ! isset($_SESSION['logged']) )
{
	echo "<br> Login required! <br><br>";
	header( "refresh:3; url = login.html");
	exit();
}

//error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);

//database connection 
include (  "account.php"     ) ;
$db = mysqli_connect($hostname,$username, $password ,$project);
if (mysqli_connect_errno())
  {	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
  }
mysqli_select_db( $db, $project );

$UCID = $_SESSION [ "UCID" ];
echo "<br> This is $UCID in transaction.php ! <br>";
?>


<!DOCTYPE html>
<meta charset='UTF-8'>

<!--HTML hyperlink to display.php page-->
<a href="display.php">Go to display</a><br><br>

<!--HTML hyperlink to logout.php page-->
<a href="logout.php">Logout</a><br><br>

<style>
	#receipt { width: 1em;}
	#amount { width: 10em;}
</style>

<!--creates a form with action target to withdraw-or-deposit.php -->
<form action ="w-or-d-stub.php">
	<input type=hidden name="UCID" value="<?php echo $UCID; ?>"> <br>
	Enter amount: <input type = number min="0" step ="0.01" name="amount" id = "amount" autocomplete="off" required placeholder = "0.00" > <br><br>
	Select choice of service:
	<select name="type" required>
		<option value="" disabled selected hidden> Choose One </option>
		<option value="D" > Deposit  </option>
		<option value="W" > Withdraw </option>
	</select><br><br>
	
	<?php 
	echo "Select account of $UCID: <br>"; 
	require ("radio-buttons.php"); 
	echo "<br>";	
	?>
	
	email receipt: (Y/N) <input type = text name = "mail_choice" id="receipt" value="N" ><br>
	Don't Time-out: <input type="checkbox" checked id="box" ><br><br>
	<input type="submit" value="Submit">
</form>


<!--timeout and log out if inactive after given time -->
<span id="timeout"></span>
<script type="text/javascript">
	"use strict"
	var timer1, d, dsec;
	var ptrbox = document.getElementById("box");
	var ptrspan = document.getElementById("timeout");
	document.addEventListener("click", resetTimer);
	
	function resetTimer()
	{
		if (ptrbox.checked){return;};
		d = new Date();
		dsec = d.getSeconds();
		ptrspan.innerHTML = "<h1>seconds is:" + dsec + "</h1>";
		clearTimeout(timer1);
		timer1 = setTimeout(logout,4000);
	}
    
	function logout()
	{
		if (ptrbox.checked){return;};
		window.location.href='logout.php';
	}
</script>