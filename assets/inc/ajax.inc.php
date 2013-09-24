<?php
/*
 * Enable sessions
*/
session_start();

/*
 * Include necessary files
*/
include_once '../../sys/config/db-cred.inc.php';

/*
 * Define constants for config info
*/
foreach ( $C as $name => $val )
{
	define($name, $val);
}


/*
 * Create a lookup array for form actions
*/
$actions = array(
		'process_user' => array(
				'object' => 'ConsultSite',
				'method' => 'processUser'
		),		
		'landingPage_view' => array(
				'object' => 'ConsultSite',
				'method' => 'displayLandingPage'
		)
		
);


//error_log(var_dump($_POST), 0);
//error_log("files action = " . $_FILES, 0);

/*
 * Make sure the anti-CSRF token was passed and that the
* requested action exists in the lookup array
*/
if ( isset($actions[$_POST['action']]) )
{	
	$use_array = $actions[$_POST['action']];
	$obj = new $use_array['object']($dbo);

	/*
	 * Check for an ID and sanitize it if found
	*/
	if ( isset($_POST['step_id']) )
	{
		$id = (int) $_POST['step_id'];
	}
	else if (isset($_POST['position_id']))
	{
		$id = (int)$_POST['position_id'];
	}
	else if (isset($_POST['definition_id']))
	{
		$id = (int)$_POST['definition_id'];
	}
	else if (isset($_POST['department_id']))
	{
		$id = (int)$_POST['department_id'];
	}
	else if (isset($_POST['glossary_letter']))
	{
		$id = $_POST['glossary_letter'];
	}
	else if (isset($_POST['search_id'])) // Search id is bullshit
	{
		$id = (int)$_POST['search_id'];
	}
	else { $id = NULL; }
	
	$ob = $use_array['object'];
	$tmp = $use_array['method'];
	
// 	error_log("$ob --> $tmp($id)", 0);

	
	echo $obj->$use_array['method']($id);
}




function __autoload($class_name)
{
	$filename = '../../sys/class/class.'
			. strtolower($class_name) . '.inc.php';
	if ( file_exists($filename) )
	{
		include_once $filename;
	}
}

?>