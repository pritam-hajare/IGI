<?php
require_once('classes/Users.php');
/**
 * Handles the user operations
 */
class Files
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
    
    public function getFiles()
    {
    	// if database connection opened
    	if ($this->databaseConnection()) {
    		// database query, getting all the info of the selected user
    		$query_user = $this->db_connection->prepare('SELECT * FROM igi_files WHERE user_id = :user_id');
    		$query_user->bindValue(':user_id', $_SESSION['user_id']);
    		$query_user->execute();
    		// get result row (as an object)
    		return $query_user->fetchAll(PDO::FETCH_ASSOC);
    	} else {
    		return false;
    	}
    }
    
    public function getFileData($fileid)
    {
    	// if database connection opened
    	if ($this->databaseConnection()) {
    		// database query, getting all the info of the selected user
    		$query_file = $this->db_connection->prepare('SELECT * FROM igi_files WHERE fileid = :fileid');
    		$query_file->bindValue(':fileid', $fileid);
    		$query_file->execute();
    		// get result row (as an object)
    		return $query_file->fetchObject();
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
        $year = trim($data['year']);
        $month = trim($data['month']);
        $day = trim($data['day']);
        $user_id = $_SESSION['user_id'];
        $groupid = $_SESSION['groupid'];
        $moderator =  $_SESSION['is_moderator'];
        $filename = $file['name'];
        $filepath = getcwd().'/upload/'.$_SESSION['user_name'].'_'.$_SESSION['user_id'];

		if ($this->databaseConnection()) {
                // write new users data into database
                $query_insert = $this->db_connection->prepare('INSERT INTO igi_files (filename, filepath, user_id, groupid, keywords, tags, caption, year, month, day, active, moderator, createdate) VALUES (:filename, :filepath, :userid, :groupid, :keywords,  :tags, :caption, :year, :month, :day, :active, :moderator,  now())');
                $query_insert->bindValue(':filename', $filename);
                $query_insert->bindValue(':filepath', 'upload/'.$_SESSION['user_name'].'_'.$_SESSION['user_id']);
                $query_insert->bindValue(':userid', $user_id);
                $query_insert->bindValue(':groupid', $groupid);
                $query_insert->bindValue(':keywords', rtrim($keywords, ','));
                $query_insert->bindValue(':tags', $tags);
                $query_insert->bindValue(':caption', $caption);
                $query_insert->bindValue(':year', $year);
                $query_insert->bindValue(':month', $month);
                $query_insert->bindValue(':day', $day);
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
                	//$path = getcwd()."/upload/".$_SESSION['user_name']."_".$user_id."/".date("d-m-Y")."/".date("h", time());
                	$path = getcwd()."/upload/".$_SESSION['user_name']."_".$user_id."/".date("d-m-Y");
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
    
    public function uploadFileRecord($data)
    {
    	//echo '<pre>';
    	//print_r($data);die();
    	// we just remove extra space on username and email
    	$keywords  = trim($data['keywords']);
    	$caption = trim($data['caption']);
    	$tags = trim($data['tags']);
    	$year = trim($data['year']);
    	$month = trim($data['month']);
    	$day = trim($data['day']);
    	$user_id = $_SESSION['user_id'];
    	$groupid = $_SESSION['groupid'];
    	$moderator =  $_SESSION['is_moderator'];
    	$fileid = $data['fileid'];
    	$active = trim($data['active']) == 'Yes' ? '1' : '0';
    	if ($this->databaseConnection()) {
    		// write new users data into database
    		$query_update = $this->db_connection->prepare('UPDATE igi_files 
    														SET 
    															user_id = :user_id,
    															groupid = :groupid,
    															keywords = :keywords,
    															tags = :tags,
    															caption = :caption,
    															year = :year,
    															month = :month,
    															day = :day,
    															moderator = :moderator, 
    															active = :active,
    															updatedate = now()
    														WHERE fileid = :fileid');
    		$query_update->bindValue(':user_id', $user_id);
    		$query_update->bindValue(':groupid', $groupid);
    		$query_update->bindValue(':keywords', rtrim($keywords, ','));
    		$query_update->bindValue(':tags', $tags);
    		$query_update->bindValue(':caption', $caption);
    		$query_update->bindValue(':year', $year);
    		$query_update->bindValue(':month', $month);
    		$query_update->bindValue(':day', $day);
    		$query_update->bindValue(':active', $active);
    		$query_update->bindValue(':moderator', $moderator);
    		$query_update->bindValue(':fileid', $fileid);
    			
    			try {
	    			$result = $query_update->execute();
	    			if($result){
	    				return true;
	    			}else{
	    				return false;
	    			}
	    		} catch (Exception $e) {
	    			return false;
	    		}
    	}
    }
    
    public function uploadBulkFiles($data)
    {
    	//echo '<pre>';
    	//print_r($data);die();
    	// we just remove extra space on username and email
    	$user_id = $data['user_id'];
    	$user_name = $data['user_name'];
    	$filename = $data['filename'];
    	$filepath = $data['filepath'];
    	$users = new Users();
    	$groupid = $users->getGroupid($user_id);
    	
    	if ($this->databaseConnection()) {
    		// write new users data into database
    		$query_insert = $this->db_connection->prepare('INSERT INTO igi_files (filename, filepath, user_id, groupid, active, createdate) VALUES (:filename, :filepath, :userid, :groupid, :active,  now())');
    		$query_insert->bindValue(':filename', $filename);
    		$query_insert->bindValue(':filepath', 'upload/'.$_SESSION['user_name'].'_'.$_SESSION['user_id']);
    		$query_insert->bindValue(':userid', $user_id);
    		$query_insert->bindValue(':groupid', $groupid);
    		$query_insert->bindValue(':active', '1');
    		try{
    			$query_insert->execute();
    		}catch (Exception $e){
    			echo $e->getMessage();
    		}
    
    
    		// id of new user
    		$fileid = $this->db_connection->lastInsertId();
    
    		if ($fileid) {
    			//$path = getcwd()."/upload/".$_SESSION['user_name']."_".$user_id."/".date("d-m-Y")."/".date("h", time());
    			$path = $filepath."/".date("d-m-Y");
    			try {
    				if(!file_exists($path)){
    					if (mkdir($path, 0777, true)) {
    						if ( copy( $filepath."/".$filename, $path."/".$fileid."_".$filename ) )
    						{
    							unlink($filepath."/".$filename);
    							$this->messages[] = "File successfully uploaded";
    						}else{
    							$this->errors[] = 'Failed to upload file...';
    						}
    
    					}else{
    						$this->errors[] = 'Failed to create folders...';
    					}
    				}else{
    					if ( copy( $filepath."/".$filename, $path."/".$fileid."_".$filename ))
    					{
    						unlink($filepath."/".$filename);
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
