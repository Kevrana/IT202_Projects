<style>
	body {background-color: lightblue;}
</style>

<?php
//cookie and continue session
session_set_cookie_params ( 0, "/~kr276/it202/assignment2/", "web.njit.edu");
session_start();

//echo the id of the session
$sidval = session_id(); 
echo "<br>The session id was: " . $sidval . "<br>";

// empty session
$_SESSION = array();
// gets rid of data on the session
session_destroy();
// gets rid of session cookie on the browser
setcookie("PHPSESSID", "", time()-3600, '/~kr276/it202/assignment2/', "", 0,0);

echo "Your session has been terminated !"; 
?>

<!DOCTYPE html>
<!-- hyperlink to login.html -->
<br><a href="login.html">Login</a><br>