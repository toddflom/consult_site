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
    	
    	
        /*
         * Fails if the proper action was not submitted
         */
        if ( $_POST['action']!='user_login' )
        {
            return "Invalid action supplied for processLoginForm.";
        }

        /*
         * Escapes the user input for security
         */
        $uname = htmlentities($_POST['uname'], ENT_QUOTES);
        $pword = htmlentities($_POST['pword'], ENT_QUOTES);
		
        
        
        
        error_log($uname);
        
        
        if ($uname == 'admin') {
        	
        	// we have an admin
 
        	/*
        	 * Retrieves the matching info from the DB if it exists
        	*/
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
        	
        	/*
        	 * Fails if username doesn't match a DB entry
        	*/
        	if ( !isset($user) )
        	{
        		return "No user found with that ID.";
        	}
        	
        	/*
        	 * Get the hash of the user-supplied password
        	*/
        	$hash = $this->_getSaltedHash($pword, $user['user_pass']);
        	
        	error_log($hash);
        	
        	error_log($this->testSaltedHash($pword, $user['user_pass']));
        	
        	/*
        	 * Checks if the hashed password matches the stored hash
        	*/
        	if ( $user['user_pass']==$hash )
        	{
        		/*
        		 * Stores user info in the session as an array
        		*/
        		$_SESSION['user'] = array(
        				'id' => $user['user_id'],
        				'name' => $user['user_name'],
        		);
        	
        		return TRUE;
        	}
        	
        	/*
        	 * Fails if the passwords don't match
        	*/
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
    

}

?>
        