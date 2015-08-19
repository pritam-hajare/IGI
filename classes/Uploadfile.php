<?php

/**
 * Handles the user operations
 */
class Uploadfile
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection            = null;
    /**
     * @var bool success state of registration
     */
    public  $uploadfile_successful  = false;
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
        session_start();
        // if we have such a POST request, call the registerNewUser() method
     	if (isset($_POST["uploadfile"])) {
     		$file = $_FILES['igifile'];
     		$data = $_POST;
     		//echo '<pre>'; print_r($_SESSION); print_r($file); print_r($data);var_dump(date("d-m-Y"), date("h", time()),  strtotime("now")); die();
            $this->uploadFile($data, $file);
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
    
    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function uploadFile($data, $file)
    {
    	//echo '<pre>';
    	//print_r($data);die();
        // we just remove extra space on username and email
        $keywords  = trim($data['keywords']);
        $caption = trim($data['caption']);
        $tags = trim($data['tags']);
        $user_id = $_SESSION['user_id'];
        $groupid = $_SESSION['groupid'];
        $moderator =  $_SESSION['is_moderator'];
        $filename = $file['name'];
        $filepath = getcwd().'/upload/'.$_SESSION['user_name'].'_'.$_SESSION['user_id'];

		if ($this->databaseConnection()) {
                // write new users data into database
                $query_insert = $this->db_connection->prepare('INSERT INTO igi_files (filename, filepath, user_id, groupid, keywords, tags, caption, active, moderator, createdate) VALUES (:filename, :filepath, :userid, :groupid, :keywords,  :tags, :caption, :active, :moderator,  now())');
                $query_insert->bindValue(':filename', $filename);
                $query_insert->bindValue(':filepath', mysql_real_escape_string($filepath));
                $query_insert->bindValue(':userid', $user_id);
                $query_insert->bindValue(':groupid', $groupid);
                $query_insert->bindValue(':keywords', $keywords);
                $query_insert->bindValue(':tags', $tags);
                $query_insert->bindValue(':caption', $caption);
                $query_insert->bindValue(':active', '1');
                $query_insert->bindValue(':moderator', $moderator);
                try{
					$query_insert->execute();
                }catch (Exception $e){
                	echo $e->getMessage();
                }
                

                // id of new user
                $fileid = $this->db_connection->lastInsertId();

                if ($fileid) {
                	$path = getcwd()."/upload/".$_SESSION['user_name']."_".$user_id."/".date("d-m-Y")."/".date("h", time());
                	try {
                		if(!file_exists($path)){
	                		if (mkdir($path, 0777, true)) {
	                			if ( move_uploaded_file( $file['tmp_name'], $path."/".$fileid."_".basename($file['name'] ) ) )
	                			{
	                				$this->messages[] = "File successfully uploaded";
	                			}else{
	                				$this->errors[] = 'Failed to upload file...';
	                			}
	                			
	                		}else{
	                			$this->errors[] = 'Failed to create folders...';
	                		}
                		}else{
                			if ( move_uploaded_file( $file['tmp_name'], $path."/".$fileid."_". basename($file['name'] ) ) )
                			{
                				$this->messages[] = "File successfully uploaded";
                			}else{
                				$this->errors[] = 'Failed to upload file...';
                			}
                		}
                	} catch (Exception $e) {
                		echo $e->getMessage();
                	}
                	
                } else {
                    $this->errors[] = 'Something went wrong, Please try again';
                }
        }
    }
}
