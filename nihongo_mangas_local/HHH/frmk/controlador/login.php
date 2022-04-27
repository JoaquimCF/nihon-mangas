<?php
    require_once("./model/Usuari.php");
    require_once("./model/login_m.php");
    class Login{
        public function __construct($params, $body){
            $method = array_shift($params);
            $api_key = array_shift($params);
            switch ($method){
                case "POST":
                    $this->postLogin($params, $body);
                    break;
                case "OPTIONS":
                    // Necessari per CORS preflight.
                    break;
                default:
                    http_response_code(405); // Mètode no permès!
            }
        }

        private function postLogin($params, $body){
            $model = new Login_model();
            $usuari = null;
            $nick = strtolower($params[0]);
            $password = $params[1];
            // No calcular el hash perquè hem de cridar a password_verify()
            // $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $candidate = new Usuari($nick, $password);
            $stored_user = $model->comprovar_password($candidate);
            $login_ok = ($stored_user != NULL);
            if ($login_ok){
                $api_key = App::guidv4();
                $stored_user->append_x_api_key($api_key);
                $stored_user->store_me();
                http_response_code(201);
                require_once("./vista/login_v.php");
            }else{
                http_response_code(401);
            }
            
        }
    }
?>