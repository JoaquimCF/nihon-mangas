<?php
    Class Login_model {
        private $db;
        public function __construct(){
            require_once("./model/connexio.php");
            $this->db=Connexio::connectar();
        }

        public function comprovar_password($candidate){
            $return_value = NULL;
            $persistencia = new Usuari_persistencia();
            $stored_user = $persistencia->get_usuari($candidate->get_nick());
            $is_ok = password_verify($candidate->get_hash_password(), $stored_user->get_hash_password());
            if ($is_ok){
                $return_value = $stored_user;
            }
            return $return_value;
        }

    }
?>