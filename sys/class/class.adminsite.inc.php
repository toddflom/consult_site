<?php

	/**
	 * Builds and manipulates a CL Consultant Administration Website
	 * 
	 * @author Todd Flom
	 * @copyright 2013 Carmichael Lynch
	 * 
	 */


class AdminSite extends DB_Connect
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
		
	

	
	public function displayLandingPage() {
		
		$html = "<div class='horizontalRule'></div>";
		
		$greeting = $this->_loadGreeting();
		
		$copy = html_entity_decode($greeting[0]['copy'], ENT_QUOTES, "utf-8" );
		
		$html .= "<div id='greeting_edit'><div id='greeting'>" . $copy . "</div>";

		$html .= "<div id='signature'>Sincerely,<img src='" 
				. $greeting[0]['signatureImg'] 
				. "' /></div>";
		
		$html .= '<form action="assets/inc/process.inc.php" method="post">';
		$html .= '<input type="hidden" name="token" value="$_SESSION[token]" />';
		$html .= '<input type="hidden" name="greeting_id" value="' . $greeting[0]['id'] . '" value="$id" />';
   		$html .= '</form>';
		
		$html .= '<a class="admin" href="#">Save Edits</a></div>';

	
		
		
		
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
	
	
	
	
	
	
	
	
	/**
	 * Validates the form and saves the greeting
	 *
	 * @return mixed TRUE on success, an error message on failure
	 */
	public function saveGreeting()
	{
		/*
		 * Exit if the action isn't set properly
		*/
		if ( $_POST['action']!='edit_greeting' )
		{
			return "The method saveGreeting was accessed incorrectly";
		}
	
		/*
		 * Escape data from the form
		*/
		$copy = htmlentities($_POST['text'], ENT_QUOTES);
	
		$id = (int) $_POST['greeting_id'];
	
			
		/*
		 * If no greeting ID passed, create a new greeting
		*/
		if ( empty($_POST['greeting_id']) )
		{
			$sql = "INSERT INTO `greeting`
                        (`copy`)
                    VALUES
                        (:copy)";
		}
	
		/*
		 * Update the greeting if it's being edited
		*/
		else
		{
			/*
			 * Cast the greeting ID as an integer for security
			*/
			$sql = "UPDATE `greeting`
			SET
			`copy`=:copy
			WHERE `id`=$id";
		}
			
		/*
		 * Execute the create or edit query after binding the data
		*/
		try
		{
			
			error_log($sql);
	
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":copy", $copy, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
			/*
			 * Returns the ID of the greeting
			*/
			// return $this->db->lastInsertId();
	
			if ($id > 0) {
				$greeting_id = $id;
			} else {
				$greeting_id = $this->db->lastInsertId();
			}
	
			//	error_log($greeting_id, 0);
	
			return $greeting_id;
	
		}
		catch ( Exception $e )
		{
			return $e->getMessage();
		}
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
					. "<div class='title'><a href='" . $thoughts[$i]['article_url'] . "' target='_blank'>" 
					.  $thoughts[$i]['title'] . "</a></div>"
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
		$sql = "SELECT `id`, `copy`, `signatureImg` FROM `greeting` LIMIT 1;";
		
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
	
	
	
	
	
}
?>
