<?php

/**
 * Handles the user groups
 */
class Keywords
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection            = null;
    /**
     * @var bool success state of registration
     */
    public  $addkeywords_successful  = false;

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
        if (isset($_POST["keyword"])) {
            $this->addKeyword($_POST['keyword']);
        } /*else if (isset($_GET["id"]) && isset($_GET["verification_code"])) {
            $this->verifyNewUser($_GET["id"], $_GET["verification_code"]);
        }*/
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

    /**
     * handles the entire add group process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function addKeyword($keyword)
    {
        // we just remove extra space on username and email
        $keyword  = trim($keyword);

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
    if (empty($keyword)) {
            $this->errors[] = 'Keyword Empty.';
        // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            // check if group  already exists
            $query_check_keyword = $this->db_connection->prepare('SELECT keywords FROM igi_keywords WHERE keywords=:keyword');
            $query_check_keyword->bindValue(':keyword', $keyword, PDO::PARAM_STR);
            $query_check_keyword->execute();
            $result = $query_check_keyword->fetchAll();

            // if username or/and email find in the database
            // TODO: this is really awful!
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->errors[] = ($result[$i]['keyword'] == $keyword) ? 'Keyword already exists' : '';
                }
            } else {

                // write new users data into database
                $query_new_group_insert = $this->db_connection->prepare('INSERT INTO igi_keywords (keywords, createdate) VALUES(:keyword,now())');
                $query_new_group_insert->bindValue(':keyword', $keyword, PDO::PARAM_STR);
                $query_new_group_insert->execute();

                // id of group user
                $keyid = $this->db_connection->lastInsertId();

                if ($keyid) {
                        $this->messages[] = 'Keyword Added successfully';
                        $this->addkeywords_successful = true;
                } else {
                    $this->errors[] = 'Failed to add Keyword';
                }
            }
        }
    }

}
