<?php

/**
 * Handles the user operations
 */
class Users
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection            = null;
    /**
     * @var bool success state of registration
     */
    public  $adduser_successful  = false;
    /**
     * @var bool success state of registration
     */
    public  $edituser_successful  = false;
    /**
     * @var array collection of groups
     */
    public  $groups                   = array();
    /**
     * @var array collection of error messages
     */
    public  $errors                   = array();
    /**
     * @var array collection of success / neutral messages
     */
    public  $messages                 = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
    	if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
        // if we have such a POST request, call the registerNewUser() method
     	if (isset($_POST["addusers"])) {
            $this->addNewUser($_POST);
        }elseif(isset($_POST["edituser"])){
        	//var_dump($_POST);die('in');
        	$this->editUser($_POST);
        } 
    }

    /**
     * Checks if database connection is opened and open it if not
     */
    private function databaseConnection()
    {
        // connection already opened
        if ($this->db_connection != null) {
            return true;
        } else {
            // create a database connection, using the constants from config/config.php
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
            // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    public function getUsers()
    {
    	// if database connection opened
    	if ($this->databaseConnection()) {
    		// database query, getting all the info of the selected user
    		$query_user = $this->db_connection->prepare('SELECT * FROM users WHERE user_name != :user_name');
    		$query_user->bindValue(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
    		$query_user->execute();
    		// get result row (as an object)
    		return $query_user->fetchAll(PDO::FETCH_ASSOC);
    	} else {
    		return false;
    	}
    }
    
    public function getUserData($user_id)
    {
    	// if database connection opened
    	if ($this->databaseConnection()) {
    		// database query, getting all the info of the selected user
    		$query_user = $this->db_connection->prepare('SELECT * FROM users WHERE user_id = :user_id');
    		$query_user->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    		$query_user->execute();
    		// get result row (as an object)
    		return $query_user->fetchObject();
    	} else {
    		return false;
    	}
    }
    
    public function getGroupid($user_id)
    {
    	// if database connection opened
    	if ($this->databaseConnection()) {
    		// database query, getting all the info of the selected user
    		$query_user = $this->db_connection->prepare('SELECT groupid FROM users WHERE user_id = :user_id');
    		$query_user->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    		$query_user->execute();
    		// get result row (as an object)
    		$result = $query_user->fetchObject();
    		return $result->groupid;
    	} 
    }
    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function addNewUser($data)
    {
    	//echo '<pre>';
    	//print_r($data);die();
        // we just remove extra space on username and email
        $user_name  = trim($data['user_name']);
        $user_email = trim($data['user_email']);
        $user_password = trim($data['user_password_new']);
        $user_password_repeat = trim($data['user_password_repeat']);

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
        if (empty($user_name)) {
            $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } elseif (empty($user_password) || empty($user_password_repeat)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        } elseif ($user_password !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        } elseif (strlen($user_password) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
        } elseif (strlen($user_name) > 64 || strlen($user_name) < 2) {
            $this->errors[] = MESSAGE_USERNAME_BAD_LENGTH;
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $user_name)) {
            $this->errors[] = MESSAGE_USERNAME_INVALID;
        } elseif (empty($user_email)) {
            $this->errors[] = MESSAGE_EMAIL_EMPTY;
        } elseif (strlen($user_email) > 64) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;

        // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            // check if username or email already exists
            $query_check_user_name = $this->db_connection->prepare('SELECT user_name, user_email FROM users WHERE user_name=:user_name OR user_email=:user_email');
            $query_check_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $query_check_user_name->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_check_user_name->execute();
            $result = $query_check_user_name->fetchAll();

            // if username or/and email find in the database
            // TODO: this is really awful!
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->errors[] = ($result[$i]['user_name'] == $user_name) ? MESSAGE_USERNAME_EXISTS : MESSAGE_EMAIL_ALREADY_EXISTS;
                }
            } else {
                // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                // want the parameter: as an array with, currently only used with 'cost' => XX.
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
                // generate random hash for email verification (40 char string)
                $user_activation_hash = sha1(uniqid(mt_rand(), true));
				$is_moderator = isset($data['is_moderator']) ? $data['is_moderator'] : 0;
                // write new users data into database
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO users (user_name, user_password_hash, user_email, user_firstname, user_lastname, user_mobile, groupid, is_moderator, user_activation_hash, user_registration_ip, user_registration_datetime) VALUES(:user_name, :user_password_hash, :user_email, :user_firstname, :user_lastname, :user_mobile, :groupid, :is_moderator, :user_activation_hash, :user_registration_ip, now())');
                $query_new_user_insert->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_firstname', trim($data['user_firstname']), PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_lastname', trim($data['user_lastname']), PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_mobile', trim($data['user_mobile']), PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':groupid', trim($data['groupid']), PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':is_moderator', $is_moderator, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();

                // id of new user
                $user_id = $this->db_connection->lastInsertId();

                if ($user_id) {
                	$path = getcwd()."/upload/".$user_name."_".$user_id;
                	try {
                		if (mkdir($path, 0777, true)) {
                			$this->messages[] = "User successfuly added";
                		}else{
                			die('Failed to create folders...');
                		}
                	} catch (Exception $e) {
                		echo $e->getMessage();
                	}
                	
                } else {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED;
                }
            }
        }
    }
    
    public function editUser($data){
    	$user_email = trim($data['user_email']);
    	$user_id = $data['user_id'];
    	if (empty($user_email)) {
    		$this->errors[] = MESSAGE_EMAIL_EMPTY;
    	} elseif (strlen($user_email) > 64) {
    		$this->errors[] = MESSAGE_EMAIL_TOO_LONG;
    	} elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    		$this->errors[] = MESSAGE_EMAIL_INVALID;
    		// finally if all the above checks are ok
    	} else if ($this->databaseConnection()) {
    		$is_moderator = isset($data['is_moderator']) ? $data['is_moderator'] : 0;
    		$query_user_update = $this->db_connection->prepare('UPDATE users
																			set user_email = :user_email,
																				user_firstname = :user_firstname,
																				user_lastname = :user_lastname,
																				user_mobile = :user_mobile,
																				groupid = :groupid,
																				is_moderator = :is_moderator
																			WHERE user_id = :user_id');
    		
    		$query_user_update->bindValue(':user_email', $user_email, PDO::PARAM_STR);
    		$query_user_update->bindValue(':user_firstname', trim($data['user_firstname']), PDO::PARAM_STR);
    		$query_user_update->bindValue(':user_lastname', trim($data['user_lastname']), PDO::PARAM_STR);
    		$query_user_update->bindValue(':user_mobile', trim($data['user_mobile']), PDO::PARAM_STR);
    		$query_user_update->bindValue(':groupid', trim($data['groupid']), PDO::PARAM_STR);
    		$query_user_update->bindValue(':is_moderator', $is_moderator, PDO::PARAM_STR);
    		$query_user_update->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    		try {
    			$result = $query_user_update->execute();
    			if($result){
    				$this->messages[] = "User successfuly updated";
    				$this->edituser_successful = true;
    			}else{
    				$this->errors[] = "Something went wrong, please try again!";
    			}
    		} catch (Exception $e) {
    			$this->errors[] = "Something went wrong, please try again!";
    		}
    		
    		
    	}
    }

    /*
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */
    public function sendVerificationEmail($user_id, $user_email, $user_activation_hash)
    {
        $mail = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }

        $mail->From = EMAIL_VERIFICATION_FROM;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;

        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);

        // the link to your register.php, please set this value in config/email_verification.php
        $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link;

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    /**
     * checks the id/verification code combination and set the user's activation status to true (=1) in the database
     */
    public function verifyNewUser($user_id, $user_activation_hash)
    {
        // if database connection opened
        if ($this->databaseConnection()) {
            // try to update user with specified information
            $query_update_user = $this->db_connection->prepare('UPDATE users SET user_active = 1, user_activation_hash = NULL WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $query_update_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
            $query_update_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $query_update_user->execute();

            if ($query_update_user->rowCount() > 0) {
                $this->verification_successful = true;
                $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
            } else {
                $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
    }
    
    public function getGroups(){
    	if ($this->databaseConnection()) {
    		// check if username or email already exists
    		$query_check_user_name = $this->db_connection->prepare('SELECT groupid, groupname FROM igi_groups');
    		$query_check_user_name->execute();
    		$result = $query_check_user_name->fetchAll();
    	
    		// if username or/and email find in the database
    		// TODO: this is really awful!
    		if (count($result) > 0) {
    			for ($i = 0; $i < count($result); $i++) {
    				$groupid = $result[$i]['groupid'];
    				$groupname = $result[$i]['groupname'];
    				$this->groups[] = "<option value='".$groupid."'>".$groupname."</option>"; 
    			}
    		}
    	}
    	return $this->groups;
    }
}
