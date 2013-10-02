<?php 
/*
 * Include necessary files
*/
include_once 'sys/core/init.inc.php';

/*
 * Load the AdminSite
*/
$admin = new AdminSite($dbo, 0);

/*
if ( is_object ($consult) )
{
	echo "
", var_dump($consult), "
";
}
*/

/*
 * Set up the page title and CSS files
*/
$page_title = "Carmichael Lynch Consultant Site Administration";
$css_files = array('reset.css','style.css', 'admin.css', 'ajax.css');

/*
 * Include the header
*/
include_once 'assets/common/header.inc.php';



/*
 * Display the site HTML
*/
echo $admin->displayLandingPage();

/*
 * Include the footer
*/
include_once 'assets/common/admin_footer.inc.php';

?>
