<?php

/**
 * Manages administrative actions
 *
 * PHP version 5
 *
 * @author     Todd Flom
 * @copyright  2013 Carmichael Lynch
 */
class Admin extends DB_Connect
{

    /**
     * Determines the length of the salt to use in hashed passwords
     *
     * @var int the length of the password salt to use
     */
    private $_saltLength = 7;

    /**
     * Stores or creates a DB object and sets the salt length
     *
     * @param object $db a database object
     * @param int $saltLength length for the password hash
     */
    public function __construct($db=NULL, $saltLength=NULL)
    {
        parent::__construct($db);

		/*
         * If an int was passed, set the length of the salt
         */
        if ( is_int($saltLength) )
        {
            $this->_saltLength = $saltLength;
        }
    }
    
    
    /**
	 * Checks login credentials for a valid user
     *
     * @return mixed TRUE on success, message on error
     */
    public function processLoginForm()
    {
    	
    	
    	return true;
    	
    	
    	/*TODO reenable login authorization
        //  Fails if the proper action was not submitted

        if ( $_POST['action']!='user_login' )
        {
            return "Invalid action supplied for processLoginForm.";
        }

         // Escapes the user input for security

         $uname = htmlentities($_POST['uname'], ENT_QUOTES);
        $pword = htmlentities($_POST['pword'], ENT_QUOTES);
		
       
        // error_log($uname);
        
        
        if ($uname == 'admin') {
        	
        	// we have an admin
 
        	// Retrieves the matching info from the DB if it exists

          	$sql = "SELECT
        	`user_id`, `user_name`, `user_pass`
       		 FROM `users`
        	WHERE `user_name` = :uname LIMIT 1";
        	
        	try
        	{
        		$stmt = $this->db->prepare($sql);
        		$stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
        		$stmt->execute();
        		$user = array_shift($stmt->fetchAll());
        		$stmt->closeCursor();
        	}
        	catch ( Exception $e )
        	{
        		die ( $e->getMessage() );
        	}
        	
        	
        	// Fails if username doesn't match a DB entry
        	
        	if ( !isset($user) )
        	{
        		return "No user found with that ID.";
        	}
        	
        	
        	// Get the hash of the user-supplied password
        	
        	$hash = $this->_getSaltedHash($pword, $user['user_pass']);
        	
        	error_log($hash);
        	
        	error_log($this->testSaltedHash($pword, $user['user_pass']));
        	
        	
        	// Checks if the hashed password matches the stored hash
        	
        	if ( $user['user_pass']==$hash )
        	{
        		// Stores user info in the session as an array
        		
        		$_SESSION['user'] = array(
        				'id' => $user['user_id'],
        				'name' => $user['user_name'],
        		);
        	
        		return TRUE;
        	}
        	
        	
        	// Fails if the passwords don't match
        	
        	else
        	{
        		return "Your username or password is invalid.";
        	}
        	 
        	
        	
        } else {
        	
        	// just a visitor
      	
        	// session_start(); // we already have a session going
        	$_SESSION['username'] = $uname; // store session data
        	
        	//	error_log("username = " . $username . "   password = " . $password);
        	
        	$pass = $this->getUserPass($uname);
        	
        	error_log($pass);
        	
        	if($pword == $pass){
        		return true;
        	} else {
        		return "Your username or password is invalid.";
        	}
       	
        	
        }     
        */  

    }
    
    
    
    
    
    /**
     * Logs out the user
     *
     * @return mixed TRUE on success or messsage on failure
     */
    public function processLogout()
    {
    	// echo "processs logout called";
    	/*
    	 * Fails if the proper action was not submitted
    	*/
    	if ( $_POST['action']!='user_logout' )
    	{
    		return "Invalid action supplied for processLogout.";
    	}
    
    	/*
    	 * Removes the user array from the current session
    	*/
    	session_destroy();
    	return TRUE;
    }
    
    
    
    /**
     * Generates a salted hash of a supplied string
     *
     * @param string $string to be hashed
     * @param string $salt extract the hash from here
     * @return string the salted hash
     */
    private function _getSaltedHash($string, $salt=NULL)
    {
    	/*
    	 * Generate a salt if no salt is passed
    	*/
    	if ( $salt==NULL )
    	{
    		$salt = substr(md5(time()), 0, $this->_saltLength);
    	}
    
    	/*
    	 * Extract the salt from the string if one is passed
    	*/
    	else
    	{
    		$salt = substr($salt, 0, $this->_saltLength);
    	}
    
    	/*
    	 * Add the salt to the hash and return it
         */
        return $salt . sha1($salt . $string);
    }
    
	 
	public function testSaltedHash($string, $salt=NULL)
    {
    	return $this->_getSaltedHash($string, $salt);
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
    	$copy = $_POST['text'];

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
    			
    		//  error_log($greeting_id, 0);
    			
    		return $greeting_id;
    			
    	}
    	catch ( Exception $e )
    	{
    		return $e->getMessage();
    	}
    }

    

    /**
     * Validates the form and saves the greeting
     *
     * @return mixed TRUE on success, an error message on failure
     */
    public function saveClient()
    {
    	/*
    	 * Exit if the action isn't set properly
    	*/
    	if ( $_POST['action']!='edit_client' )
    	{
    		return "The method saveClient was accessed incorrectly";
    	}
    
    	/*
    	 * Escape data from the form
    	*/
    	
    	$logo_url = htmlentities($_POST['logo_url'], ENT_QUOTES);
    	$client = $_POST['client'];
    	$tagline = $_POST['tagline'];
    	$copy = $_POST['copy']; // htmlentities($_POST['copy'], ENT_QUOTES);
    	/* $cta_url = htmlentities($_POST['cta_url'], ENT_QUOTES); */
    	$cta_url = $_POST['cta_url'];
    	 
    	$id = (int) $_POST['client_id'];
    
    	error_log("client_id = " . $id);
    
    	/*
    	 * If no greeting ID passed, create a new greeting
    	*/
    	if ( empty($_POST['client_id']) )
    	{
    		$sql = "INSERT INTO `client_project`
    				(`logo_url`, `client`, tagline`, `copy`, `cta_url`)
    				VALUES
    				(:logo_url, :client, :tagline, :copy, :cta_url)";
    	}
    
    	/*
    	 * Update the greeting if it's being edited
    	*/
    	else
    	{
    		/*
    		 * Cast the greeting ID as an integer for security
    		*/
    		$sql = "UPDATE `client_project`
    		SET
    		`logo_url`=:logo_url, `client`=:client, `tagline`=:tagline, `copy`=:copy, `cta_url`=:cta_url
    		WHERE `clientproj_id`=$id";
    	}
    
    	/*
    	 * Execute the create or edit query after binding the data
    	*/
    	try
    	{
    		 
    		error_log($sql);
    		 
    		$stmt = $this->db->prepare($sql);
    		$stmt->bindParam(":logo_url", $logo_url, PDO::PARAM_STR);
    		$stmt->bindParam(":client", $client, PDO::PARAM_STR);
    		$stmt->bindParam(":tagline", $tagline, PDO::PARAM_STR);
    		$stmt->bindParam(":copy", $copy, PDO::PARAM_STR);
    		$stmt->bindParam(":cta_url", $cta_url, PDO::PARAM_STR);
    		$stmt->execute();
    		$stmt->closeCursor();
    		/*
    		 * Returns the ID of the client
    		*/
    		// return $this->db->lastInsertId();
    		 
    		if ($id > 0) {
    			$client_id = $id;
    		} else {
    			$client_id = $this->db->lastInsertId();
    		}
    		 
    		//  error_log($client_id, 0);
    		 
    		return $client_id;
    		 
    	}
    	catch ( Exception $e )
    	{
    		return $e->getMessage();
    	}
    }
    
    
    

    /**
     * Confirms that a client should be deleted and does so
     *
     * Upon clicking the button to delete a client, this
     * generates a confirmation box. If the user confirms,
     * this deletes the client from the database and reloads
     * the projects view. If the user
     * decides not to delete the client, they're sent back to
     * the prjects view without deleting anything.
     *
     * @param int $id the client ID
     * @return mixed the form if confirming, void or error if deleting
     */
    public function confirmClientDelete($id)
    {
    	/*
    	 * Make sure an ID was passed
    	*/
    	if ( empty($id) ) { return NULL; }
    
    	/*
    	 * Make sure the ID is an integer
    	*/
    	$id = preg_replace('/[^0-9]/', '', $id);
    
    	/*
    	 * If the confirmation form was submitted and the form
    	* has a valid token, check the form submission
    	*/
    	if ( isset($_POST['confirm_client_delete'])
    			&& $_POST['token']==$_SESSION['token'] )
    	{
    		/*
    		 * If the deletion is confirmed, remove the client
    		* from the database
    		*/
    		if ( $_POST['confirm_client_delete']=="Confirm Delete" )
    		{
    			$sql = "DELETE FROM `client_project`
    			WHERE `clientproj_id`=:id
                            LIMIT 1";
    			try
    			{
    				$stmt = $this->db->prepare($sql);
    				$stmt->bindParam(
    						":id",
    						$id,
    						PDO::PARAM_INT
    				);
    				$stmt->execute();
    				$stmt->closeCursor();
    			//	header("Location: ./");
    				return;
    			}
    			catch ( Exception $e )
    			{
    				return $e->getMessage();
    			}
    		}
    
    		/*
    		 * If not confirmed, sends the user to the main view
    		*/
    		else
    		{
    			echo "didn't work";
    		//	header("Location: ./");
    			return;
    		}
    	}
    
    	/*
    	 * If the confirmation form hasn't been submitted, display it
    	*/
    	$client = $this->_loadClientById($id);
    
 
    	$clientName = strip_tags($client[0]['client']);
    	$client_id = $client[0]['clientproj_id'];
    	
    	
    //	error_log("client = " . implode(",", $client));

    	return <<<CONFIRM_DELETE
    
    <form class="client_delete" action="confirmdelete.php" method="post">
        <h2>
            Are you sure you want to delete "$clientName"?
        </h2>
        <p>There is <strong>no undo</strong> if you continue.</p>
        <p>
            <input type="submit" name="confirm_client_delete"
                  value="Confirm Delete" />
            <input type="submit" name="confirm_client_delete"
                  value="Cancel" />
            <input type="hidden" name="client_id"
                  value="$client_id" />
            <input type="hidden" name="token"
                  value="$_SESSION[token]" />
        </p>
    </form>
CONFIRM_DELETE;
    }
    
    
    
    private function _loadClientById($id) {
    
    	$sql = "SELECT `clientproj_id`,
		 `client`,
		 `logo_url`,
		 `tagline`,
		 `copy`,
		 `cta_url`
		 FROM
		 `client_project`
		 WHERE
		 `clientproj_id`=:id
    	LIMIT 1;";
    
    	try
    	{
    		$stmt = $this->db->prepare($sql);
    		$stmt->bindParam(
    				":id",
    				$id,
    				PDO::PARAM_INT
    		);
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
     * Generates a form to edit or create projects
     *
     * @return string the HTML markup for the editing form
     */
    public function editProject()
    {
    	
    	/*
    	 * Check if an ID was passed
    	*/
    	if ( isset($_POST['project_id']) )
    	{
    		$id = (int) $_POST['project_id']; // Force integer type to sanitize data
    	}
    	else
    	{
    		$id = NULL;
    	}
    	 
    	$tasks = "";
    
    	/*
    	 * Instantiate the headline/submit button text
    	*/
    	$submit = "Create a New Project";
    
    	/*
    	 * If an ID is passed, loads the associated step
    	*/
    	if ( !empty($id) )
    	{
    		$project = $this->_loadProjectById($id);
    		$submit = "Edit This Project";
    	}
    	else
    	{
    		// $project = new Step(NULL, $this->db);
    	}
 
    	$project_id = $project[0]['project_id'];
    	$clientproj_id = $project[0]['clientproj_id'];
    	$title = strip_tags($project[0]['title']);
    	$thumbnail_url = $project[0]['thumbnail_url'];
    	$video_url = $project[0]['video_url'];
    	$image_url = $project[0]['image_url'];
    	 
    	$checked = $project[0]['is_featured'] == 1 ? 'checked' : '';
    	$highlightBox = '<input type="checkbox" name="project_featured" value="1" ' . $checked . ' />';
    	 
    	$clientDropMenu = $this->buildClientsDrop($project[0]['clientproj_id']);
    	
    	$vimeoDropMenu = $this->_buildVimeosDrop($project[0]['video_url']);
    
    	/*
    	 * Build the markup
    	*/
    	return <<<FORM_MARKUP
         
    <form action="assets/inc/process.inc.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>$submit</legend>
            <div><label for="project_client_id">Client:</label>
            $clientDropMenu</div>
            <div><label for="step_name">Project Title:</label>
            <input type="text" name="project_title"
                  id="project_title" value="$title" /></div>
            <div><label for="project_featured">Project Featured on Main Page:</label>
            $highlightBox
            </div>
            <div><label for="thumbnail_url">Project Thumbnail:</label>
            <textarea name="thumbnail_url"
                  id="thumbnail_url">$thumbnail_url</textarea></div>
            <div><label for="video_url">Vimeo Video:</label>
            $vimeoDropMenu</div>
            <div><label for="image_url">URL for image:</label>
            <textarea name="image_url"
                  id="image_url">$image_url</textarea></div>
            <input type="hidden" name="step_id" value="$project_id" />
            <input type="hidden" name="token" value="$_SESSION[token]" />
            <input type="hidden" name="action" value="project_edit" />
            <input type="submit" name="project_submit" value="$submit" />
            or <a href="./">cancel</a>
        </fieldset>
    </form>
FORM_MARKUP;
    }
    
    
    

    /**
     * Builds Clients dropdown menu
     *
     * @param int $id the client ID
     * @return string the html markup for a clients dropdown menu
     */
    public function buildClientsDrop ($id = NULL)
    {
    
    	//$positions = $this->_loadPositions();
    	 
    	$sql = "SELECT
                    *
                FROM `client_project`";
    	 
    	$clients = $this->_runSQL($sql);
    	 
    	// error_log(var_dump($positions));
    
    
    	$html = '<select id="clients" name="clients[]">';  // Posts as an enumeratable array
    
    	foreach ( $clients as $client )
    	{
    		// error_log($id);
    		 
    		$html .= '<option value="'
    				. $client['clientproj_id']
    				. '" ';
    		 
    		if ($id != NULL)
    		{
    			if ($id == $client['clientproj_id'])
    			{
    				$html .= 'selected="selected"';
    			}
    		}
    		 
    		 
    		$html .= '>'
    				. $client['client']
    				. '</option>';
    		 
    	}
    
    	$html .= '</select>';
    
    	return $html;
    
    }
    
    
    


    private function _loadProjectById($id) {
    
    	$sql = "SELECT `project_id`,
    	 `clientproj_id`,
		 `title`,
		 `thumbnail_url`,
		 `video_url`,
		 `image_url`,
		 `is_featured`
		 FROM
		 `project`
		 WHERE
		 `project_id`=:id
    	LIMIT 1;";
    
    	try
    	{
    		$stmt = $this->db->prepare($sql);
    		$stmt->bindParam(
    				":id",
    				$id,
    				PDO::PARAM_INT
    		);
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
     * Builds Vimeo dropdown menu
     *
     * @param int $id the vimeo video ID
     * @return string the html markup for a vimeo dropdown menu
     */
    private function _buildVimeosDrop ($id = NULL)
    {
    
    	require_once('/Users/toddflom/Desktop/MAMP root/Consultant Site/consult_site/vimeo/vimeo.php');
    	$vimeo = new phpVimeo('3623b66c5e557a850636cc6f9c3c1c57c473236e', 'de839c39d834cce43ccf606869beda547d78bfad');
    	$vimeo->setToken('207d88049f149371d72135d3acae4af1','ca82591c8fdcaedc5008eee783840c83b0bc1b67');    
    
    	$html = '<select id="videos" name="videos[]">';  // Posts as an enumeratable array
    
    	$output = '<div class="albumGallery">';
    	$result = $vimeo->call('vimeo.videos.getAll', array('page' => '1',  'perpage' => '50'));
    	$videos = $result->videos->video;
    	foreach ($videos as $video) {
    		// error_log($id);
    		 
    		$html .= '<option value="'
    				. $video->id
    				. '" ';
    		 
    		if ($id != NULL)
    		{
    			if ($id == $video->id)
    			{
    				$html .= 'selected="selected"';
    			}
    		}
    		 
    		 
    		$html .= '>'
    				. $video->title
    				. '</option>';
    		 
    	}
    
    	$html .= '</select>';
    
    	return $html;
    
    }
    



    /**
     * Load Vimeo gallery
     */
    
    private function _loadVimeoLibrary() {
    	// Any time you want to call the Advanced API, your PHP will start with these 3 lines:
    	require_once('/Users/toddflom/Desktop/MAMP root/Consultant Site/consult_site/vimeo/vimeo.php');
    	$vimeo = new phpVimeo('3623b66c5e557a850636cc6f9c3c1c57c473236e', 'de839c39d834cce43ccf606869beda547d78bfad');
    	$vimeo->setToken('207d88049f149371d72135d3acae4af1','ca82591c8fdcaedc5008eee783840c83b0bc1b67');
    
    	// Here is a sample snippet for generating an gallery from a vimeo album (which is not limited to 20 videos like the basic API), and should get you started taking advantage of the Advanced API. In modx, you would call this snippet with the album ID for which you want a gallery
    
    	$output = '<div class="albumGallery">';
    	$result = $vimeo->call('vimeo.videos.getAll', array('page' => '1',  'perpage' => '50'));
    	$videos = $result->videos->video;
    	foreach ($videos as $video) {
    			
    		$output .= ' <a href="'.$video->urls->url[0]->_content.'" title="'.$video->title.'" rel="zoombox[group]">';
    		$output .= '  <div class="albumGalleryItem">';
    		$output .= '   <div class="ImgContainer">'.$video->id.'</div>';
    		$output .= '   <div class="albumGalleryCaption">'.$video->title.'</div>';
    		$output .= '  </div>';
    		$output .= ' </a>';
    	}
    
    	$output .= '</div>';
    
    	return $output;
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
        
