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
		
		$html = "<div class='horizontalRule'></div>";
		
		$greeting = $this->_loadGreeting();
		
		$html .= "<div id='greeting'>" . $greeting[0]['copy'];

		$html .= "<div id='signature'>Sincerely,<img src='" 
				. $greeting[0]['signatureImg'] 
				. "' /></div></div>";

		
		
		$html .= "<div id='featured_projects'>";
		
		$html .= "<div class='featured_bar'><div class='title'>New Projects</div><div class='cta'><a href='#'>View All</a></div></div>";
		
		
		$featured = $this->_loadFeaturedProjects();
		
		$tot_featured = count($featured);
		
		$ds = "<div class='featured_proj'>";
		$de = "</div>";
		
		for ($i = 0; $i < $tot_featured; $i++) {
			
			$link = "<img class='thumb' src='" . $featured[$i]['thumbnail_url'] . "' />"
					. "<div class='client_name'>" .  $featured[$i]['client'] . "</div>"
					. "<div class='tag_line'>" .  $featured[$i]['tagline'] . "</div>"
					. "<div class='copy'>" .  $featured[$i]['copy'] . "</div>"
					. "<div class='cta'><a href='" .  $featured[$i]['cta_url'] . "'>Learn More</a></div>";
		
			if($i % 2 == 1) {
				$html .= $ds . $link . "</div><div id='clearance' style='clear:both;'></div>";
			} else {
				$html .= $ds . $link . $de;
			}
		
		}
		
		$html .= "</div><!-- end of featured_projects -->";
		
		return $html;
	}
	
	
	
	private function _loadGreeting() {
		$sql = "SELECT `copy`, `signatureImg` FROM `greeting` LIMIT 1;";
		
		try
		{
			$stmt = $this->db->prepare($sql);
			 		
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
		
			return $results;
		}
		catch ( Exception $e )
		{
			die ( $e->getMessage() );
		}
	}
	
	
	private function _loadFeaturedProjects() {
		
		/*
		SELECT dog.id,dog.name,breed.name AS breed
		FROM dog,breed
		WHERE dog.breed_id = breed.id
		ORDER BY dog.name ASC;
		
		+----+--------+---------+
		| id | name   | breed   |
		+----+--------+---------+
		|  3 | Buster | Terrier |
		|  2 | Jake   | Hounds  |
		|  1 | Max    | Hounds  |
		+----+--------+---------+
		*/
		
		$sql = "SELECT `client_project`.`clientproj_id`, 
				`client_project`.`client`, 
				`client_project`.`tagline`, 
				`client_project`.`copy`, 
				`client_project`.`cta_url`, 
				`project`.`thumbnail_url` 
				FROM 
				`client_project`, `project` 
				WHERE 
				`client_project`.`clientproj_id` = `project`.`clientproj_id` 
				AND 
				`project`.`is_featured` = 1;";
		
		try
		{
			$stmt = $this->db->prepare($sql);
		
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
		
			return $results;
		}
		catch ( Exception $e )
		{
			die ( $e->getMessage() );
		}
		
		
	}
	
	 
	
	
}
?>
