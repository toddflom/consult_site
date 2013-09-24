<?php

	/**
	 * Builds and manipulates a CL Consultant Website
	 * 
	 * @author Todd Flom
	 * @copyright 2013 Carmichael Lynch
	 * 
	 */


class ConsultSite extends DB_Connect
{
	
	
	/**
	 * Creates a database object and stores relevant data
	 * Upon instantiation, this class accepts a database object
	 * that, if not null, is stored in the object's private $_db
	 * property. If null, a new PDO object is created and stored
	 * instead.
	 *
	 * @param object $dbo a database object
	 * @param int $useStep the step to use to set up the app
	 * @return void
	 *
	 */
	
	public function __construct($dbo=NULL)
	{
		/*
		 * Call the parent constructor to check for a database object
		*/
		parent::__construct($dbo);
	}
	
	
	/**
	 * Returns HTML markup to display the initial Consultant Site View
	 *
	 * @return string the process HTML markup
	 */
	
	public function buildLoginPage()
	{
		$html = '<div id="content">'
					. '<div class="horizontalRule"></div>'
					. '<div class="spacer"></div>'
					. '<div class="spacer"></div>'
					. '<div id="login_modal">'
					. '<h1>User Login</h1>'
					. '<p style="line-spacing:40px">&nbsp;</p>'
					. '<form id="form1" name="form1" action="assets/inc/process.inc.php" method="post">'
					. '<p>'
					. '<label for="username">Username: </label>'
					. '<input type="text" name="username" id="username" />'
					. '</p>'
					. '<p>'
					. '<label for="password">Password: </label>'
					. '<input type="password" name="password" id="password" />'
					. '</p>'
					. '<p id="message">&nbsp;</p>'
					. '<input type="hidden" name="action" value="process_user" />'
					. '<input type="submit" id="login" name="login" value="user_login" />'
					. '</p>'
					. '</form>'
					. '<div id="message"></div>'
					. '</div>'
					. '</div>';
		
		return $html;
	}
	
	
	
	public function processUser() {
		
		/*
		 * Exit if the action isn't set properly
		*/
		if ( $_POST['action']!='process_user' )
		{
			return "The method processSearchForm was accessed incorrectly";
		}
		
		$username = htmlentities($_POST['username'], ENT_QUOTES);
		$password = htmlentities($_POST['password'], ENT_QUOTES);
		
		// session_start(); // we already have a session going
		$_SESSION['username'] = $username; // store session data
		
	//	error_log("username = " . $username . "   password = " . $password);
	
		$pass = $this->getUserPass($username);
		
		error_log($pass);
		
		if($password == $pass)
		{
			return true;
		} else {
			return false;
		}
	}
	
	
	
	private function getUserPass($name) {
		
		$sql = "SELECT `password` FROM `user_login` WHERE `name` = :name "; 
				 
		try
		{
			$stmt = $this->db->prepare($sql);
			 
			$stmt->bindParam(":name", $name, PDO::PARAM_INT);
		
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
		
			return $results[0]['password'];
		}
		catch ( Exception $e )
		{
			die ( $e->getMessage() );
		}
		
	}
	
	
	
	/**
	 * Runs a suppiled SQL statment that has no binding variables
	 * and returns results as an array
	 */
	private function _runSQL($sql)
	{
		try
		{
			$stmt = $this->db->prepare($sql);
			 
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			 
			//echo var_dump($results);
			 
			return $results;
			 
		}
		catch ( Exception $e )
		{
			die ( $e->getMessage() );
		}
	}
	
	
	
	public function displayLandingPage() {
		
		error_log("got here");
		
		return '<div id="someclass">Ppiouydpiuqwhd piuwehfpiuwehfpiwuefh piwfhuipwue fhpwieufh piweufhwipeufhweiufh wieufh</div>';
	}
	
	
	
	 
	
	
}
?>
