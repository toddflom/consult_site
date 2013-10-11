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
		
		$html = '<div id="modal_background"></div>'
				. '<div id="content">'
				. '<div class="horizontalRule"></div>'
				. '<div class="spacer"></div>'
				. '<div class="spacer"></div>'
				. '<div id="login_modal">'
				. '<h1>Please Log In</h1>'
				. '<p style="line-spacing:40px">&nbsp;</p>'
				. '<form id="form1" name="form1" action="assets/inc/process.inc.php" method="post">'
				. '<p>'
				. '<label for="uname">Username: </label>'
				. '<input type="text" name="uname" id="uname" value="" />'
				. '</p>'
				. '<p>'
				. '<label for="pword">Password: </label>'
				. '<input type="password" name="pword" id="pword" value="" />'
				. '</p>'
				. '<p id="message">&nbsp;</p>'
				. '<input type="hidden" name="token" value="' . $_SESSION['token'] . '" />'
				. '<input type="hidden" name="action" value="user_login" />'
				. '<input type="submit" name="login_submit" value="Log In" />'
				. '</p>'
				. '</form>'
				. '<div id="message"></div>'
				. '</div>'
				. '</div>';
		
		return $html;
				
	}
	
	

	
	public function displayLandingPage() {
	
		$html = $this->_adminGeneralOptions();
				
		$html .= "<div class='horizontalRule'></div>";
		
		$greeting = $this->_loadGreeting();
		
		$copy = html_entity_decode($greeting[0]['copy'], ENT_QUOTES, "utf-8" );
		
		$html .= "<div id='greeting_edit'><div id='greeting'>" . $copy . "</div>";
		
		$html .= "<div id='signature'>Sincerely,<img src='"
				. $greeting[0]['signatureImg']
				. "' /></div>";
				
		$html .= $this->_adminGreetingOptions($greeting[0]['id']);
		
		$html .= "<div id='featured_projects'>";
		
		$html .= "<div class='featured_bar'><div class='title'>New Projects</div><div class='cta'>View All</div></div>";
		
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
		
		$html .= "<div class='articles_bar'><div class='title'>Featured Articles</div><div class='cta'>View All</div></div>";
		
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
		
		$html .= "<div class='news_bar'><div class='title'>In The News</div><div class='cta'>View All</div></div>";
		
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
		
		$html .= $this->_adminGeneralOptionsJS();
		
		return $html;
	}
	
	
	
	
	public function displayProjectsPage() {
		
		$html = "<div class='header_bar'><div class='title'>New Projects</div></div>";
		
		$html .= "<div id='projects'>";
				
		$projects = $this->_loadProjects();
				
		$tot_projects = count($projects);
		
		if ($tot_projects <= 0) {
			$this->_adminAddProjectOptions($projects[$i]['clientproj_id']);
		}
		
		$last_index;
		
		for ($i = 0; $i < $tot_projects; $i++) {
			
			$this_index = $projects[$i]['clientproj_id'];
			
			$link = "";
			
			// error_log("this_index = " . $this_index . "  last_index = " . $last_index);
			
			if ($this_index != $last_index) {
		
				$ds = "<div class='client_project'>"; 
				$de = "";
				
				
				$logo_url = html_entity_decode($projects[$i]['logo_url'], ENT_QUOTES, "utf-8" );
				$client = html_entity_decode($projects[$i]['client'], ENT_QUOTES, "utf-8" );
				$tagline = html_entity_decode($projects[$i]['tagline'], ENT_QUOTES, "utf-8" );
				$copy = html_entity_decode($projects[$i]['copy'], ENT_QUOTES, "utf-8" );
				$cta_url = stripslashes(html_entity_decode($projects[$i]['cta_url'], ENT_QUOTES, "utf-8" ));
		
				$link .= "<div class='client_info'>"
						. "<div class='logo_img'><img class='logo' src='" . $logo_url . "' /></div>"
						. "<div class='client'>" .  $client . "</div>"
						. "<div class='tagline'>" .  $tagline . "</div>"
						. "<div class='copy'>" .  $copy . "</div>"
						. "<div class='cta'>" .  $cta_url . "</div>";
				
				$link .= $this->_adminClientOptions($projects[$i]['clientproj_id']);
				
				$link .= "</div>";
				
			} else {
				$ds = "";
			}
			
			$de = '';
			
			if ($this_index != $projects[$i + 1]['clientproj_id']) {
				$de .= $this->_adminAddProjectOptions($projects[$i]['clientproj_id']);
			}
				
			
			if ($i + 1 < $tot_projects) {
				if ($this_index != $projects[$i + 1]['clientproj_id']) {
					$de .= "<div class='horizontalRule'></div></div>";
				}
			}	
			
			$link .= "<div class='project_video'>";
			
			// error_log($projects[$i]['video_url']);
				
			if	($projects[$i]['video_url'] != 'NULL' && $projects[$i]['video_url'] != '') {
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
			
			$link .= $this->_adminProjectOptions($projects[$i]['project_id']);

			$html .= $ds . $link . $de;

			$last_index = $this_index;
		}
		
		$html .= "</div><!-- end of projects -->";
		
		$html .= $this->_adminAddClientOptions();
		
		$html .= $this->_adminClientOptionsJS();
		
		
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
	
			$link = "<div class='thumbnail_url'><img class='thumbnail' src='" . $news[$i]['thumbnail_url'] . "' /></div>"
					. "<div class='source'>" .  $news[$i]['source'] . "</div>"
					. "<div class='title'>" .  $news[$i]['article_title'] . "</div>"
					. "<div class='cta'><a href='" .  $news[$i]['article_url'] . "'>Learn More</a></div>";
			
			if ($news[$i]['pdf_url'] != NULL) {
				$link .= "<div class='pdf'><a href='" .  $news[$i]['pdf_url'] . "' target='_blank'>Download PDF</a></div>";
	
			}
			
			$is_featured = $news[$i]['is_featured'];
			$checked = $is_featured == '1' ? 'checked' : '';
			$link .= $this->_adminNewsOptions($news[$i]['id'], $checked, $news[$i]['copy']);
			
			//error_log("i = " . $i . " mod 3 = " . $i % 3);
			
			if($i % 3 == 2) {
				$html .=  "<div class='news_item col_right'>" . $link . "</div><div id='clearance' style='clear:both;'></div>";
			} else {
				$html .= "<div class='news_item col_left'>" . $link . $de;
			}
				
			// $html .= $ds . $link . $de;
	
		}
	
		$html .= $this->_adminAddNewsOptions();
		
		$html .= "</div><!-- end of news -->";
		
		$html .= $this->_adminNewsOptionsJS();
		
			
		return $html;
	}
	
	
	
	

	public function displayThoughtPage() {
	
		$html = "<div class='header_bar'><div class='title'>Thought Leadership</div></div>";
	
		$html .= "<div id='thought_leadership'>";
	
		$thoughts = $this->_loadThoughts();
	
		$tot_thoughts = count($thoughts);

		$de = "</div>";
		
		
		error_log("total thoughts = " . $tot_thoughts);
			
		for ($i = 0; $i < $tot_thoughts; $i++) {
	
			$link = "<div class='image'><img class='photo' src='" . $thoughts[$i]['photo_url'] . "' /></div>"
					. "<div class='info'>"
					. "<div class='source'>" .  $thoughts[$i]['source'] . "</div>"
					. "<div class='title'><a href='" . $thoughts[$i]['article_url'] . "' target='_blank'>" 
					.  $thoughts[$i]['title'] . "</a></div>"
					. "<div class='name'>" .  $thoughts[$i]['name'] . "</div>"
					. "</div>";
											
								
			// error_log("i = " . $i . " mod 3 = " . $i % 3);
			
			$is_featured = $thoughts[$i]['is_featured'];
			$checked = $is_featured == '1' ? 'checked' : '';
			$link .= $this->_adminThoughtOptions($thoughts[$i]['id'], $thoughts[$i]['person_id'], $checked);
				
			if($i % 2 == 1) {
				$html .=  "<div class='thought col_right'>" . $link . "</div><div id='clearance' style='clear:both;'></div>";
			} else {
				$html .= "<div class='thought col_left'>" . $link . $de;
			}
	
			// $html .= $ds . $link . $de;
	
		}
	
		$html .= $this->_adminAddThoughtOptions();
		
		$html .= "</div><!-- end of thought_leadership -->";

		$html .= $this->_displayPersonsData();
		
		$html .= $this->_adminThoughtOptionsJS();
		
	
		return $html;
	}
	
	
	

	private function _displayPersonsData() {
	
		
		if ( isset($_SESSION['user']) )
		{

			$html = "<div id='people'>";
			
			$html .= "<p>&nbsp;</p><div class='horizontalRule'></div>";
				
			$html .= "<div class='header_bar'><div class='title'>People</div></div>";
			
			$people = $this->_loadPeople();
			
			$tot_people = count($people);
			
			$de = "</div>";
			//error_log("total people = " . $tot_people);
				
			for ($i = 0; $i < $tot_people; $i++) {
			
				$link = "<div class='image'><img class='photo' src='" . $people[$i]['photo_url'] . "' /></div>"
						. "<div class='name'>" .  $people[$i]['name'] . "</div>";
			
				// error_log("i = " . $i . " mod 3 = " . $i % 3);
			
				$link .= $this->_adminPersonOptions($people[$i]['person_id']);
			
				if($i % 4 == 3) {
					$html .=  "<div class='person col_right'>" . $link . "</div><div id='clearance' style='clear:both;'></div>";
				} else {
					$html .= "<div class='person col_left'>" . $link . $de;
				}
			}
			
			$html .= $this->_adminAddPersonOptions();
			
			$html .= "</div><!-- end of people -->";
			
			$html .= $this->_adminPersonOptionsJS();
			
			return $html;
			
		}
		else
		{
			return NULL;
		}
		
	}
	
	

	private function _loadPeople() {
	
		$sql = "SELECT *
		 FROM
		 `person`
		ORDER BY
		`person_id` ASC;";
	
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
	
	
	
	

	private function _loadThoughts() {
	
		$sql = "SELECT `article`.`id`,
		 `article`.`source`,
		 `article`.`title`,
		 `article`.`article_url`,
		 `article`.`person_id`,
		 `article`.`is_featured`,
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
				`is_featured`,
				`article_title`,
				`copy`,
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
		 `project`.`project_id`,
		 `project`.`title`,
		 `project`.`video_url`,
		 `project`.`image_url`
		 FROM
		 `client_project`, `project`
		 WHERE
		 `client_project`.`clientproj_id` = `project`.`clientproj_id`
		ORDER BY
		`client_project`.`clientproj_id`;";
		
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
				`project`.`is_featured` = 1
				ORDER BY
				`client_project`.`clientproj_id`;";
		
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
	
	
	
	private function _adminGeneralOptionsJS() 
	{
		
		if ( isset($_SESSION['user']) )
		{
		
			return <<<ADMIN_OPTIONS
		
		<script type="text/javascript">
		$(function() {
		
		
			tinymce.init({
				selector: "div#greeting",
				inline: true,
				plugins: [
				"autolink lists link charmap",
				],
				toolbar: "undo redo | bold italic | charmap | link",
				menubar: false
		});

						
		});
		</script>
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
			
					
	}
	
	
	
	
	private function _adminGeneralOptions()
	{
		/*
		 * If the user is logged in, display admin controls
		*/
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
	
	<form action="assets/inc/process.inc.php" method="post">
        <div>
            <input type="submit" value="Log Out" class="admin_logout" />
            <input type="hidden" name="token"
                value="$_SESSION[token]" />
            <input type="hidden" name="action"
                value="user_logout" />
        </div>
    </form>
ADMIN_OPTIONS;
		}
	}
	
	
	
	
	
	private function _adminGreetingOptions($id)
	{
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
<form action="assets/inc/process.inc.php" method="post">
<input type="hidden" name="token" value="$_SESSION[token]" />
<input type="hidden" name="greeting_id" value="$id" />
</form>
<a class="admin" href="#">Save Edits</a></div>
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	
	
	private function _adminClientOptionsJS() {
	
		if ( isset($_SESSION['user']) )
		{
	
			return <<<ADMIN_OPTIONS
	
		<script type="text/javascript">
		$(function() {
	
			tinymce.init({
				selector: "div.copy",
				inline: true,
				plugins: [
				"autolink lists link charmap",
				],
				toolbar: "undo redo | bold italic | charmap | link",
				menubar: false

			});
		
			tinymce.init({
				selector: [
				"div.client", 
				"div.tagline"
				],
				inline: true,
				plugins: "charmap",
				toolbar: "undo redo | charmap",
				menubar: false
			});	
		
			tinymce.init({
				selector: ".client_info>div.cta",
				inline: true,
				plugins: "link",
				toolbar: "link",
				menubar: false
			});	
		
			tinymce.init({
				selector: "div.logo_img",
				inline: true,
				plugins: [
				"image",
				"responsivefilemanager"
				],
				toolbar: "image",
				menubar: false,
				external_filemanager_path:"/filemanager/",
				filemanager_title:"CL Filemanager" ,
				external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
			});
						
		});
		</script>
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	
	
	}
	
	
	

	
	
	
	/**
	 * Generates edit and delete options for a given client ID
	 *
	 * @param int $id the client ID to generate options for
	 * @return string the markup for the edit/delete options
	 */
	private function _adminClientOptions($id)
	{
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
	
    <div class="client-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<a class="admin" href="#">Save Edits</a>
		<input type="hidden" name="client_id" value="$id" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    <form action="confirmClientdelete.php" method="post">
		<input type="submit" name="delete_client" value="Delete This Client" />
		<input type="hidden" name="client_id" value="$id" />
    </form>
    </div><!-- end .client-admin-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	

	/**
	 * Generates edit and delete options for a given project ID
	 *
	 * @param int $id the project ID to generate options for
	 * @return string the markup for the edit/delete options
	 */
	private function _adminProjectOptions($id)
	{
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
	
    <div class="project-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<input type="submit" name="edit_project" value="Edit This Project" />
    	<input type="hidden" name="project_id" value="$id" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    <form action="confirmProjectdelete.php" method="post">
		<input type="submit" name="delete_project" value="Delete This Project" />
		<input type="hidden" name="project_id" value="$id" />
    </form>
    </div><!-- end .project-admin-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	/**
	 * Generates Add options for a given client ID
	 *
	 * @param int $id the cleint ID to generate new project options for
	 * @return string the markup for the add options
	 */
	private function _adminAddProjectOptions($id)
	{
		if ( isset($_SESSION['user']) )
		{			
			return <<<ADMIN_OPTIONS
	
    <div class="add-project-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<input type="submit" name="edit_project" value="&#43; Add a New Project" />
    	<input type="hidden" name="client_id" value="$id" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    </div><!-- end .add-project-admin-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	

	/**
	 * Generates Add Client options
	 *
	 * @return string the markup for the add options
	 */
	private function _adminAddClientOptions()
	{
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
	
	<div class='horizontalRule'></div>
			
    <div class="add-client-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<input type="submit" name="edit_client" value="&#43; Add a New Client" />
    	<input type="hidden" name="client_id" value="" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    </div><!-- end .add-client-admin-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	
	
	private function _adminNewsOptionsJS() {

		if ( isset($_SESSION['user']) )
		{
		
		return <<<ADMIN_OPTIONS

		<script type="text/javascript">
		$(function() {
		
			tinymce.init({
				selector: ".thumbnail_url",
				inline: true,
				plugins: [
				"image",
				"responsivefilemanager"
				],
				toolbar: "image",
				menubar: false,
				external_filemanager_path:"/filemanager/",
				filemanager_title:"CL Filemanager" ,
				external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
			});
	
			tinymce.init({
				selector: ".source",
				inline: true,
				plugins: "charmap",
				toolbar: "undo redo | charmap",
				menubar: false
			});
			tinymce.init({
				selector: [
				".title",
				".copy"
				],
				inline: true,
				plugins: [
				"autolink lists link charmap anchor",
				],
				menubar: false,
				toolbar: "undo redo | bold italic | charmap | link"
			});
	
				tinymce.init({
					selector: ".cta",
					inline: true,
					plugins: "autolink link",
					toolbar: "link",
					menubar: false
				});
						
						
			tinymce.init({
				selector: ".pdf",
				inline: true,
				plugins: [
				"autolink link",
				"responsivefilemanager"
				],
				menubar: false,
				toolbar: "link unlink anchor",
				image_advtab: true ,
				external_filemanager_path:"/filemanager/",
				filemanager_title:"CL Filemanager" ,
				external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
			});
								
		});
		</script>
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
		
		
	}
	
	
	

	/**
	 * Generates edit and delete options for a given news ID
	 *
	 * @param int $id the news ID to generate options for
	 * @return string the markup for the edit/delete options
	 */
	private function _adminNewsOptions($id, $checked, $copy)
	{
		if ( isset($_SESSION['user']) )
		{
			$highlightBox = '<input type="checkbox" name="news_featured" id="news_featured" value="1" ' . $checked . ' />';
			
			return <<<ADMIN_OPTIONS
						
    <div class="news-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
    	<div class="copy">$copy</div><br/>
    	<label for="news_featured">Article Featured on Main Page:</label>
            $highlightBox
            <br/>
		<a class="admin" href="#">Save Edits</a>
		<input type="hidden" name="news_id" value="$id" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    <form action="confirmNewsdelete.php" method="post">
		<input type="submit" name="delete_news" value="Delete This News Article" id="cancel_news_delete"/>
		<input type="hidden" name="news_id" value="$id" />
    </form>
    </div><!-- end .client-news-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	

	/**
	 * Generates Add News options
	 *
	 * @return string the markup for the add options
	 */
	private function _adminAddNewsOptions()
	{
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
	
	<div class='horizontalRule'></div>
		
    <div class="add-news-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<input type="submit" name="edit_news" value="&#43; Add a News Article" />
    	<input type="hidden" name="news_id" value="" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    </div><!-- end .add-news-admin-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	private function _adminThoughtOptionsJS() {
		if ( isset($_SESSION['user']) )
		{				
			return <<<ADMIN_OPTIONS
		
    	<script type="text/javascript">
	    	$(function() {
		
				tinymce.init({
				    selector: ".source",
				    inline: true,
				    plugins: "charmap",
				    toolbar: "undo redo | charmap",
				    menubar: false
				});
			
				tinymce.init({
					selector: ".title",
					inline: true,
					plugins: "autolink link charmap",
					toolbar: "undo redo | link | charmap",
					menubar: false
				});
		
			});
		</script>
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
		
	}
			
	
	
	private function _adminThoughtOptions($id, $person_id, $checked)
	{
		if ( isset($_SESSION['user']) )
		{
			$highlightBox = '<input type="checkbox" name="article_featured" id="article_featured" value="1" ' . $checked . ' />';
				
			$clientDropMenu = $this->_buildPersonsDrop($person_id);
							
			return <<<ADMIN_OPTIONS
		
    <div class="article-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
    <label for="persons">Article Author:</label>
    	$clientDropMenu<br />
    	<label for="news_featured">Article Featured on Main Page:</label>
            $highlightBox
            <br/>
		<a class="admin" href="#">Save Edits</a>
		<input type="hidden" name="article_id" value="$id" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    <form action="confirmArticledelete.php" method="post">
		<input type="submit" name="delete_thought" value="Delete This Article" id="cancel_thought_delete"/>
		<input type="hidden" name="article_id" value="$id" />
    </form>
    </div><!-- end .article-news-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	


	/**
	 * Generates Add Thought options
	 *
	 * @return string the markup for the add options
	 */
	private function _adminAddThoughtOptions()
	{
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
	
	<div class='horizontalRule'></div>
	
    <div class="add-thought-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<input type="submit" name="edit_thought" value="&#43; Add a Another Article" />
    	<input type="hidden" name="article_id" value="" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    </div><!-- end .add-thought-admin-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	
	
	/**
	 * Builds Persons dropdown menu
	 *
	 * @param int $id the person ID
	 * @return string the html markup for a people dropdown menu
	 */
	private function _buildPersonsDrop ($id = NULL)
	{

		$sql = "SELECT
                    *
                FROM `person`";
	
		$persons = $this->_runSQL($sql);
	
		// error_log(var_dump($positions));
	
	
		$html = '<select id="persons" name="persons[]">';  // Posts as an enumeratable array
	
		foreach ( $persons as $person )
		{
			//error_log($id);
			 
			$html .= '<option value="'
					. $person['person_id']
					. '" ';
			 
			if ($id != NULL)
			{
				if ($id == $person['person_id'])
				{
					$html .= 'selected="selected"';
				}
			}
			 
			 
			$html .= '>'
					. $person['name']
					. '</option>';
			 
		}
	
		$html .= '</select>';
	
		return $html;
	
	}
	
	
	
	private function _adminPersonOptionsJS() {
		if ( isset($_SESSION['user']) )
		{
			
			$dir = SUB_DIRECTORY_NAME;
	
			return <<<ADMIN_OPTIONS
	
    	<script type="text/javascript">
	    	$(function() {
	
				tinymce.init({
					selector: ".image",
					inline: true,
					plugins: [
					"image",
					"responsivefilemanager"
					],
					toolbar: "image",
					menubar: false,
					external_filemanager_path:"/filemanager/",
					filemanager_title:"CL Filemanager" ,
					external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
				});
		
				tinymce.init({
					selector: ".name",
					inline: true,
					plugins: "charmap",
					toolbar: "undo redo | charmap",
					menubar: false
				});
	
			});
		</script>
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	
	}
	
	
	
	private function _adminPersonOptions($id)
	{
		if ( isset($_SESSION['user']) )
		{
				
			return <<<ADMIN_OPTIONS
	
    <div class="person-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<a class="admin" href="#">Save Edits</a>
		<input type="hidden" name="person_id" value="$id" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    <form action="confirmPersondelete.php" method="post">
		<input type="submit" name="delete_person" value="Delete This Person" id="cancel_person_delete"/>
		<input type="hidden" name="person_id" value="$id" />
    </form>
    </div><!-- end .person-news-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	

	/**
	 * Generates Add Person options
	 *
	 * @return string the markup for the add options
	 */
	private function _adminAddPersonOptions()
	{
		if ( isset($_SESSION['user']) )
		{
			return <<<ADMIN_OPTIONS
	
	<div class='horizontalRule'></div>
	
    <div class="add-person-admin-options">
    <form action="assets/inc/process.inc.php" method="post">
		<input type="submit" name="edit_person" value="&#43; Add a Another Person" />
    	<input type="hidden" name="person_id" value="" />
		<input type="hidden" name="token" value="$_SESSION[token]" />
    </form>
    </div><!-- end .add-person-admin-options -->
ADMIN_OPTIONS;
		}
		else
		{
			return NULL;
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
