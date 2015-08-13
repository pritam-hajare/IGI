<?php

/**
 * Handles the user groups
 */
class Groups
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection            = null;
    /**
     * @var bool success state of registration
     */
    public  $addgroup_successful  = false;
    
    /**
     * @var bool success state of registration
     */
    public  $editgroup_successful  = false;

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
        if (isset($_POST["addgroup"])) {
            $this->addGroup($_POST['groupname'], $_POST['description']);
        }else if (isset($_POST["editgroup"])) {
            $this->editGroup($_POST);
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
    
    public function getGroups()
    {
    	// if database connection opened
    	if ($this->databaseConnection()) {
    		// database query, getting all the info of the selected user
    		$query_groups = $this->db_connection->prepare('SELECT * FROM igi_groups');
    		$query_groups->execute();
    		// get result row (as an object)
    		return $query_groups->fetchAll(PDO::FETCH_ASSOC);
    	} else {
    		return false;
    	}
    }
    
    public function getGroupData($groupid)
    {
    	// if database connection opened
    	if ($this->databaseConnection()) {
    		$query_group = $this->db_connection->prepare('SELECT * FROM igi_groups WHERE groupid = :groupid');
    		$query_group->bindValue(':groupid', $groupid, PDO::PARAM_STR);
    		$query_group->execute();
    		// get result row (as an object)
    		return $query_group->fetchObject();
    	} else {
    		return false;
    	}
    }

    /**
     * handles the entire add group process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function addGroup($groupname, $description)
    {
        // we just remove extra space on username and email
        $groupname  = trim($groupname);
        $description = trim($description);

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
    if (empty($groupname)) {
            $this->errors[] = 'Group Namw Empty.';
        } elseif (empty($description)) {
            $this->errors[] = 'Description is empty.';
        // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            // check if group  already exists
            $query_check_groupname = $this->db_connection->prepare('SELECT groupname FROM igi_groups WHERE groupname=:groupname');
            $query_check_groupname->bindValue(':groupname', $groupname, PDO::PARAM_STR);
            $query_check_groupname->execute();
            $result = $query_check_groupname->fetchAll();

            // if username or/and email find in the database
            // TODO: this is really awful!
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->errors[] = ($result[$i]['groupname'] == $groupname) ? 'Group already exists' : '';
                }
            } else {

                // write new users data into database
                $query_new_group_insert = $this->db_connection->prepare('INSERT INTO igi_groups (groupname, description, createdate) VALUES(:groupname, :description,now())');
                $query_new_group_insert->bindValue(':groupname', $groupname, PDO::PARAM_STR);
                $query_new_group_insert->bindValue(':description', $description, PDO::PARAM_STR);
                $query_new_group_insert->execute();

                // id of group user
                $group_id = $this->db_connection->lastInsertId();

                if ($group_id) {
                        $this->messages[] = 'Group Added successfully';
                        $this->addgroup_successful = true;
                } else {
                    $this->errors[] = 'Failed to add group';
                }
            }
        }
    }
    
    private function editGroup($data)
    {
    		//var_dump($data);die();
    	// we just remove extra space on username and email
    	$groupname  = trim($data['groupname']);
    	$groupid = $data['groupid'];
    	$original_groupname  = trim($data['original_groupname']);
    	$description = trim($data['description']);
    
    	// check provided data validity
    	// TODO: check for "return true" case early, so put this first
    	if (empty($groupname)) {
    		$this->errors[] = 'Group Namw Empty.';
    	} elseif (empty($description)) {
    		$this->errors[] = 'Description is empty.';
    		// finally if all the above checks are ok
    	} else if ($this->databaseConnection()) {
    		// check if group  already exists
    		if($groupname !== $original_groupname){
    		$query_check_groupname = $this->db_connection->prepare('SELECT groupname FROM igi_groups WHERE groupname=:groupname');
    		$query_check_groupname->bindValue(':groupname', $groupname, PDO::PARAM_STR);
    		$query_check_groupname->execute();
    		$result = $query_check_groupname->fetchAll();
    		}else{
    			$result = array();
    		}
    		// TODO: this is really awful!
    		if (count($result) > 0) {
    			for ($i = 0; $i < count($result); $i++) {
    				$this->errors[] = ($result[$i]['groupname'] == $groupname) ? 'Group already exists' : '';
    			}
    		} else {
    
    			// write new users data into database
    			$query_update = $this->db_connection->prepare('UPDATE igi_groups 
    																SET	groupname = :groupname,
    																	description = :description
    															WHERE groupid = :groupid');
    			$query_update->bindValue(':groupname', $groupname, PDO::PARAM_STR);
    			$query_update->bindValue(':description', $description, PDO::PARAM_STR);
    			$query_update->bindValue(':groupid', $groupid, PDO::PARAM_STR);
	    		try {
	    			$result = $query_update->execute();
	    			if($result){
	    				$this->messages[] = "Group successfuly updated";
	    				$this->editgroup_successful = true;
	    			}else{
	    				$this->errors[] = "Something went wrong, please try again!";
	    			}
	    		} catch (Exception $e) {
	    			$this->errors[] = "Something went wrong, please try again!";
	    		}
    		}
    	}
    }

}
