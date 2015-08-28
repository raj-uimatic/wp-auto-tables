<?php
    require_once '../config/config.php';
    
    class db {
        
        protected $con;
        
        public function __construct() {
            $this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Please check the DB config');
        }
        /**
         * Method to execute a query
         * param @sql for the sql query
         */
        public function execute( $sql = '' ) {
            if( $sql ) {
                try{
                    $query = mysqli_query($this->con, $sql) or die('Some error in the query');
                    return ($query) ? true : false;
                } catch ( Exception $e ) {
                    return "Error while migrating: ". $e->getMessage();
                }
            } else {
                throw new Exception("SQL Query Missing");
            }
        }
    }
    
    $df = new db();