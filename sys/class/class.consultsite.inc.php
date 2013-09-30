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
		
/*		$ds = "<div class='featured_proj'>"; */
		$de = "</div>";
		
		for ($i = 0; $i < $tot_featured; $i++) {
						
			$link = "<img class='thumb' src='" . $featured[$i]['thumbnail_url'] . "' />"
					. "<div class='client_name'>" .  $featured[$i]['client'] . "</div>"
					. "<div class='tag_line'>" .  $featured[$i]['tagline'] . "</div>"
					. "<div class='copy'>" .  $featured[$i]['copy'] . "</div>"
					. "<div class='cta'><a href='" .  $featured[$i]['cta_url'] . "'>Learn More</a></div>";
		
			if($i % 2 == 1) {
				$html .=  "<div class='featured_proj col_right'>" . $link . "</div><div id='clearance' style='clear:both;'></div>";
			} else {
				$html .= "<div class='featured_proj col_left'>" . $link . $de;
			}
		
		}
		
		$html .= "</div><!-- end of featured_projects -->";
		
		
	
		
		$html .= "<div id='featured_articles'>";
		
		$html .= "<div class='articles_bar'><div class='title'>Featured Articles</div><div class='cta'><a href='#'>View All</a></div></div>";
		
		$articles = $this->_loadFeaturedArticles();
				
		$tot_articles = count($articles);
		
		/*		$ds = "<div class='featured_proj'>"; */
		$de = "</div>";
		
		for ($i = 0; $i < $tot_articles; $i++) {
		
			$link = "<div class='source'>" .  $articles[$i]['source'] . "</div>"
					. "<div class='title'>" .  $articles[$i]['title'] . "</div>"
					. "<div class='name'>" .  $articles[$i]['name'] . "</div>"
					. "<img class='thumb' src='" . $articles[$i]['photo_url'] . "' />";
		
			if($i % 2 == 1) {
				$html .=  "<div class='featured_article col_right'>" . $link . "</div><div id='clearance' style='clear:both;'></div>";
			} else {
				$html .= "<div class='featured_article col_left'>" . $link . $de;
			}
		
		}
		
		$html .= "</div><!-- end of featured_articles -->";
		
		

		$html .= "<div id='featured_news'>";
		
		$html .= "<div class='news_bar'><div class='title'>In The News</div><div class='cta'><a href='#'>View All</a></div></div>";
		
		$news = $this->_loadFeaturedNews();
		
		$tot_news = count($news);
		
		$ds = "<div class='featured_news_item'>"; 
		$de = "</div>";
		
		for ($i = 0; $i < $tot_news; $i++) {
		
			$link = "<div class='source'>" .  $news[$i]['source'] . "</div>"
					. "<div class='title'>" .  $news[$i]['article_title'] . "</div>"
					. "<div class='copy'>" .  $news[$i]['copy'] . "</div>"
					. "<div class='cta'><a href='" .  $news[$i]['article_url'] . "'>Learn More</a></div>";
		
			$html .= $ds . $link . $de;
		
		}
		
		$html .= "</div><!-- end of featured_news -->";
		
		
		return $html;
	}
	
	
	
	
	public function displayProjectsPage() {
		
		$html = "<div class='header_bar'><div class='title'>New Projects</div></div>";
		
		$html .= "<div id='projects'>";
				
		$projects = $this->_loadProjects();
				
		$tot_projects = count($projects);
		
		
		$last_index;
		
		for ($i = 0; $i < $tot_projects; $i++) {
			
			$this_index = $projects[$i]['clientproj_id'];
			
			$link = "";
			
			// error_log("this_index = " . $this_index . "  last_index = " . $last_index);
			
			if ($this_index != $last_index) {
		
				$ds = "<div class='client_project'>"; 
				$de = "";
				
				$link .= "<div class='client_info'>"
						. "<img class='logo' src='" . $projects[$i]['logo_url'] . "' />"
						. "<div class='client'>" .  $projects[$i]['client'] . "</div>"
						. "<div class='tagline'>" .  $projects[$i]['tagline'] . "</div>"
						. "<div class='copy'>" .  $projects[$i]['copy'] . "</div>"
						. "<div class='cta'><a href='" .  $projects[$i]['cta_url'] . "'>Learn More</a></div>"
						. "</div>";
				
			} else {
				$ds = "";
			}
			
			if ($i + 1 < $tot_projects) {
				if ($this_index != $projects[$i + 1]['clientproj_id']) {
					$de = "<div class='horizontalRule'></div></div>";
				}
			}	
			
			$link .= "<div class='project_video'>";
			
			// error_log($projects[$i]['video_url']);
				
			if	($projects[$i]['video_url'] != 'NULL') {
				$link .= "<iframe class='vimeo' src='http://player.vimeo.com/video/" 
						. $projects[$i]['video_url'] 
						. "?autoplay=0&api=1' "
						. "width='632' height='356' frameborder='0' "
						. "webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
				
			} else if ($projects[$i]['image_url'] != 'NULL'){
				$link .= "<img class='logo' src='" . $projects[$i]['image_url'] . "' />";
			}
					
			$link .= "<div class='video_title'>" . $projects[$i]['title'] . "</div></div>";
		//	$link .= "<div class='horizontalRule'></div>";
				
		
			$html .= $ds . $link . $de;

			$last_index = $this_index;
			
				
		}
		
		$html .= "</div><!-- end of projects -->";
		
		return $html;
	}
	
	
	
	public function displayNewsPage() {
	
		$html = "<div class='header_bar'><div class='title'>In the News</div></div>";
	
		$html .= "<div id='news'>";
	
		$news = $this->_loadNews();
	
		$tot_news = count($news);
		
		// $ds = "<div class='client_project'>";
		$de = "</div>";
			
		for ($i = 0; $i < $tot_news; $i++) {
	
			$link = "<img class='thumbnail' src='" . $news[$i]['thumbnail_url'] . "' />"
					. "<div class='source'>" .  $news[$i]['source'] . "</div>"
					. "<div class='title'>" .  $news[$i]['article_title'] . "</div>"
					. "<div class='cta'><a href='" .  $news[$i]['article_url'] . "'>Learn More</a></div>";
			
			
			if ($news[$i]['pdf_url'] != NULL) {
				$link .= "<div class='pdf'><a href='" .  $news[$i]['pdf_url'] . "' target='_blank'>Download PDF</a></div>";
	
			}
			
			//error_log("i = " . $i . " mod 3 = " . $i % 3);
			
			if($i % 3 == 2) {
				$html .=  "<div class='news_item col_right'>" . $link . "</div><div id='clearance' style='clear:both;'></div>";
			} else {
				$html .= "<div class='news_item col_left'>" . $link . $de;
			}
				
			// $html .= $ds . $link . $de;
	
		}
	
		$html .= "</div><!-- end of news -->";
	
		return $html;
	}
	
	
	
	

	public function displayThoughtPage() {
	
		$html = "<div class='header_bar'><div class='title'>Thought Leadership</div></div>";
	
		$html .= "<div id='thought_leadership'>";
	
		$thoughts = $this->_loadThoughts();
	
		$tot_thoughts = count($thoughts);
	
		// $ds = "<div class='client_project'>";
		$de = "</div>";
			
		for ($i = 0; $i < $tot_thoughts; $i++) {
	
			$link = "<div class='image'><img class='photo' src='" . $thoughts[$i]['photo_url'] . "' /></div>"
					. "<div class='info'>"
					. "<div class='source'>" .  $thoughts[$i]['source'] . "</div>"
					. "<div class='title'>" .  $thoughts[$i]['title'] . "</div>"
					. "<div class='name'>" .  $thoughts[$i]['name'] . "</div>"
					. "</div>";
											
								
			error_log("i = " . $i . " mod 3 = " . $i % 3);
				
			if($i % 2 == 1) {
				$html .=  "<div class='thought col_right'>" . $link . "</div><div id='clearance' style='clear:both;'></div>";
			} else {
				$html .= "<div class='thought col_left'>" . $link . $de;
			}
	
			// $html .= $ds . $link . $de;
	
		}
	
		$html .= "</div><!-- end of thought_leadership -->";
	
		return $html;
	}
	
	
	

	private function _loadThoughts() {
	
		$sql = "SELECT `article`.`id`,
		 `article`.`source`,
		 `article`.`title`,
		 `article`.`article_url`,
		 `person`.`name`,
		 `person`.`photo_url`
		 FROM
		 `article`, `person`
		 WHERE
		 `article`.`person_id` = `person`.`person_id`
		ORDER BY 
		`article`.`id` ASC;";
	
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
	
	
	
	

	private function _loadNews() {
	
		$sql = "SELECT `id`,
				`source`,
				`article_title`,
				`article_url`,
				`pdf_url`,
				`thumbnail_url`
		 FROM
		 `news_item;";
	
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
	
	
	
	
	private function _loadProjects() {
		
		$sql = "SELECT `client_project`.`clientproj_id`,
		 `client_project`.`client`,
		 `client_project`.`logo_url`,
		 `client_project`.`tagline`,
		 `client_project`.`copy`,
		 `client_project`.`cta_url`,
		 `project`.`title`,
		 `project`.`video_url`,
		 `project`.`image_url`
		 FROM
		 `client_project`, `project`
		 WHERE
		 `client_project`.`clientproj_id` = `project`.`clientproj_id`;";
		
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
	
	 	
	
	private function _loadFeaturedArticles() {
	
		$sql = "SELECT `article`.`id`, 
				`article`.`source`, 
				`article`.`title`, 
				`article`.`article_url`, 
				`person`.`name`, 
				`person`.`photo_url` 
				FROM 
				`article`, `person` 
				WHERE 
				`article`.`person_id` = `person`.`person_id` 
				AND 
				`article`.`is_featured` = 1;";
		
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
	
	
	
	private function _loadFeaturedNews() {

		$sql = "SELECT `id`, `source`, `article_title`, `copy`, `article_url`
				FROM
				`news_item`
				WHERE
				`is_featured` = 1;";
		
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
