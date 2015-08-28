<?php
    
    require_once '../lib/db.php';
    
    class uimodel extends db {
        
        /**
         * Initiates the migration flow
         * Invokes the validate functionality
         * Invokes the  
         */
        public function __construct() {
            parent::__construct();
        }
        public static function migrate( $tableDef = array() ) {
            $validate = uimodel::validate_table($tableDef);
            if( $validate ) {
                uimodel::$tableDef['type']($tableDef);
            }
        }
        
        /**
         * validate the table declaration
         */
        private static function validate_table( $tableDef = array() ) {
            $valid = true;
            if( $tableDef ) {
                if( !in_array( $tableDef['type'], array('create', 'alter') ) ) {
                    $valid = false;
                    throw new Exception("Invalid Migration Type");    
                }
                
                if( !array_key_exists("table", $tableDef ) ) { 
                    $valid = false;
                    throw new Exception("Table defination Missing.");
                } else {
                    if( !array_key_exists("name", $tableDef['table'] ) ){
                        $valid = false;
                        throw new Exception("Table name missing.");
                    }
                }
                
                if( !array_key_exists("columns", $tableDef ) ) { 
                    $valid = false;
                    throw new Exception("Column defination Missing.");
                } else {
                    $valid = uimodel::validate_cols( $tableDef['columns'] );
                }
            } else {
                $valid = false;
                throw new Exception("Table defination missing.");
            }
            return $valid;
        }
        
        /**
         * function to validate the cols
         */
        private static function validate_cols( $cols = array() ) {
            if( ! is_array( $cols ) || empty( $cols ) ) {
                throw new Exception("Column defination Missing.");
                return false;
            }
            foreach( $cols as $name => $attr ) {
                if( !array_key_exists('type', $attr) ||  !$attr['type'] ) {
                    throw new Exception("Column type defination missing.");
                    return false;
                }
            }
            return true;
        }
        
        /**
         * build the create table query
         */
        private static function create($tableDef = array()) {
            try{
                $table = $tableDef['table'];
                $cols  = $tableDef['columns'];
                $query = "create table ".$table['name']." (";
                foreach( $cols as $col => $def ) {
                    $query .= $col ." ". $def['type']." (".$def['length'].") ,";
                }
                $query = rtrim($query, ",");
                $query .= ")";
                if( $table['charset'] && $table['collate'] )
                    $query .= "CHARACTER SET ".$table['charset']." COLLATE ".$table['collate'];
                $db = new db();
                echo ($db->execute($query)) ? "DB table ".$tableDef['table']['name']." migrated" : "Some error occured while migrating";
            } catch ( Exception $e ) {
                echo $e->getMessage();
            }
        }
        
    }