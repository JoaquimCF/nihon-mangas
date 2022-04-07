<?php
    require_once("./model/Usuari.php");
    class Registre{    
        public function __construct($params, $body){
            $method = array_shift($params);
            $api_key = array_shift($params);
            switch ($method){
                case "POST":
                    $this->postRegistre($params, $body);
                    break;
                case "OPTIONS":
                    break;
                default:
                    http_response_code(405);
            }
        }

        private function postRegistre($params, $body){
            if (!$body){
                http_response_code(400);
                return;
            }
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