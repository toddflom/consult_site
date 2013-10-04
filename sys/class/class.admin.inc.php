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
    	$cta_url = htmlentities($_POST['cta_url'], ENT_QUOTES);
    	
    	$id = (int) $_POST['client_id'];
    
    
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
    
    
    
    


}

?>
        
