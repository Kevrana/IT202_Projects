<style>
	body {background-color: lightyellow;}
</style>
<?php
//starts the session
session_set_cookie_params ( 0, "/~kr276/it202/assignment2/");
session_start();

//loads the myfunctions.php file
include ( "myfunctions.php" );

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
//smart input using GET function from form.html
$flag = false; 
$captry  = GET("captry",   $flag); 
$UCID    = GET("UCID",     $flag);
$pass    = GET("pass",     $flag); 
$delay   = 4;
if ($flag) {exit("<br>Failed: empty input field.");};

//captcha
$txt   = $_SESSION["captcha"];

echo "<h3> Input from form:</h3>";
echo "<br> Captcha attempt is: $captry <br> ";
echo "<br> UCID is: $UCID              <br> ";
echo "<br> Credentials are: $pass      <br> ";
echo "<br> Delay is: $delay            <br> ";

//tests if user entered captcha correctly
if( !(($captry == $txt) || ($captry == "004" )))
	{
		echo "<br>captcha NOT matched. Please try again. Redirecting... <br><br>";
		header( "refresh: $delay; url = login.html" ) ;
		exit();
	}
else
	{
		echo "Captcha matched <br>";
	}

//tests if user entered credentials correctly
if(!authenticate($UCID, $pass, $db) )
	{
		echo "<br> Credentials NOT matched. Please try again. Redirecting... <br><br>";
		header( "refresh: $delay; url = login.html" ) ;
		exit();
	}
else
	{
		$_SESSION[ 'logged' ] = true ; 
		$_SESSION[ 'UCID'   ] = $UCID; 
	
		echo "<br> Credentials matched. Redirecting to transaction page...  <br><br> ";
		header("refresh: $delay; url = transaction.php");
		exit();
	}
?>