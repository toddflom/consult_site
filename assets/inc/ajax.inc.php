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
		'user_login' => array(
				'object' => 'Admin',
				'method' => 'processLoginForm'
		),
		'user_logout' => array(
				'object' => 'Admin',
				'method' => 'processLogout'
		),
		'landingPage_view' => array(
				'object' => 'ConsultSite',
				'method' => 'displayLandingPage'
		),
		'projectsPage_view' => array(
				'object' => 'ConsultSite',
				'method' => 'displayProjectsPage'
		),
		'newsPage_view' => array(
				'object' => 'ConsultSite',
				'method' => 'displayNewsPage'
		),
		'thoughtPage_view' => array(
				'object' => 'ConsultSite',
				'method' => 'displayThoughtPage'
		),
		'edit_greeting' => array(
				'object' => 'Admin',
				'method' => 'saveGreeting'
		),
		'edit_client' => array(
				'object' => 'Admin',
				'method' => 'saveClient'
		),
		'delete_client' => array(
				'object' => 'Admin',
				'method' => 'confirmClientDelete'
		),
		'confirm_client_delete' => array(
				'object' => 'Admin',
				'method' => 'confirmClientDelete'
		),
		'edit_project' => array(
				'object' => 'Admin',
				'method' => 'editProject'
		),
		'delete_project' => array(
				'object' => 'Admin',
				'method' => 'confirmProjectDelete'
		),
		'confirm_project_delete' => array(
				'object' => 'Admin',
				'method' => 'confirmProjectDelete'
		),
		'save_project' => array(
				'object' => 'Admin',
				'method' => 'saveProject'
		),		
		'edit_news' => array(
				'object' => 'Admin',
				'method' => 'saveNews'
		),
		'delete_news' => array(
				'object' => 'Admin',
				'method' => 'confirmNewsDelete'
		),
		'confirm_news_delete' => array(
				'object' => 'Admin',
				'method' => 'confirmNewsDelete'
		),		
		'edit_thought' => array(
				'object' => 'Admin',
				'method' => 'saveThought'
		),
		'delete_thought' => array(
				'object' => 'Admin',
				'method' => 'confirmThoughtDelete'
		),
		'confirm_thought_delete' => array(
				'object' => 'Admin',
				'method' => 'confirmThoughtDelete'
		),
		'edit_person' => array(
				'object' => 'Admin',
				'method' => 'savePerson'
		),
		'delete_person' => array(
						'object' => 'Admin',
						'method' => 'confirmPersonDelete'
		),
		'confirm_person_delete' => array(
						'object' => 'Admin',
						'method' => 'confirmPersonDelete'
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
	if ( isset($_POST['greeting_id']) )
	{
		$id = (int) $_POST['greeting_id'];
	}
	else if (isset($_POST['client_id']))
	{
		$id = (int)$_POST['client_id'];
	}
	else if (isset($_POST['project_id']))
	{
		$id = (int)$_POST['project_id'];
	}
	else if (isset($_POST['news_id']))
	{
		$id = (int)$_POST['news_id'];
	}
	else if (isset($_POST['article_id']))
	{
		$id = (int)$_POST['article_id'];
	}
	else if (isset($_POST['person_id']))
	{
		$id = (int)$_POST['person_id'];
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