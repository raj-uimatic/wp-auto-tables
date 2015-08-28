<?php

    require_once '../lib/uimodel.php';
    
    class users extends uimodel {
        
        /**
         * class var @migration_type
         * default create, accepts alter, create
         */
        private $migration_type = "create";
        /**
         * constructor functions invokes the 
         * migrate function from parent class
         */
        public function __construct() {
            $this->run();
        }
        
        /**
         *  defining the table description
         *  @name mandatory
         *  @engine  (default MyISAM)
         *  @charset (default utf8)
         *  @collate (default utf8_spanish_ci)
         *  @comment (default null)
         **/
        private function table() {
            return array(
                'name'   => 'test',
                'engine' => 'MyISAM',
                'charset'=> 'utf8',
                'collate'=> 'utf8_spanish_ci',
                'comment'=> ''
            );
        }
        
        /**
         *  defining the table columns
         *  @name => array of @type, @length, @default 
         *  returns @array
         **/
        private function columns() {
            return array(
                "id"   => array( 'type'=>"int", 'length'=>"10", 'default'=> '' ),
                "name"   => array( 'type'=>"varchar", 'length'=>"200", 'default'=> '' ),
            );
        }
        
        /**
         * Invokes the method to migrate the file to DB
         **/
        private function run() {
            $tableDefination = array(
                "type" => $this->migration_type,
                "table" => $this->table(), 
                "columns" => $this->columns(),   
            );
            try{
                uimodel::migrate( $tableDefination );
            } catch ( Exception $e ) {
                echo $e->getMessage();
            }
        }
        
    }
    
    $users = new users();
    