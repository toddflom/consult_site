<?php


/*
 * used by init.js to determine if an 'admin' is logged in
 */

session_start();

if( isset($_SESSION['user']) ) {
	print "Active";
}
else {
	print "Expired";
}

?>