<?php
require_once 'Usuari_persistencia.php';
    Class Usuari {
        private $id = null;
        private $nick = null;
        private $hash_password = null;
        private $x_api_keys = null;
        private $persistencia = null;
        public function __construct($nick, $hash_password, $x_api_keys = null){
            $this->nick = strtolower($nick);
            $this->hash_password = $hash_password;
            $this->x_api_keys = $x_api_keys;
            $this->persistencia = new Usuari_persistencia();
        }
    
        public function get_hash_password(){
            return $this->hash_password;
        }

        public function set_hash_password($hash){
            $this->hash_password = $hash;
        }

        public function get_nick(){
            return $this->nick;
        }

        public function get_x_api_keys(){
            return $this->x_api_keys;
        }

        private function set_x_api_keys($x_api_keys){
            $this->x_api_keys = $x_api_keys;
        }

        public function append_x_api_key($x_api_key){
            $current_keys = $this->get_x_api_keys();
            if ($current_keys==null){
                $current_keys = Array();
            }
            array_push($current_keys, $x_api_key);
            $this->set_x_api_keys($current_keys);
        }
        
        public function get_id(){
            return $this->id;
        }

        public function set_id($id){
            $this->id = $id;
        }
        
        public function store_me(){
            $this->id = $this->persistencia->store_usuari($this);
        }
        
    }
?>