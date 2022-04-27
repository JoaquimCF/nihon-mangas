<?php
    require_once("./model/Usuari.php");
    class Registre{    
        public function __construct($params, $body){
            $method = array_shift($params);
            switch ($method){
                case "POST":
                    $this->postRegistre($params, $body);
                    break;
            }
        }

        private function postRegistre($params, $body){
            $usuari = null;
            $nick = $body->nick;
            $password = $body->password;
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $usuari = new Usuari($nick, $password_hash);
            $usuari->store_me();
            http_response_code(204);
        }
    }
?>