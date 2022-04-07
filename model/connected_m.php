<?php
    Class Connected_model {
        private $db;
        public function __construct(){
            require_once("./model/connexio.php");
            $this->db=Connexio::connectar();
        }

        public function getConnectedUser($api_key){
            $return_value = NULL;
            $persistencia = new Usuari_persistencia();
            $stored_user = $persistencia->get_usuari_by_UUID($api_key);
            if ($stored_user){
                $return_value = $stored_user;
            }
            return $return_value;
        }
    }
?>