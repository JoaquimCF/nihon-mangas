<?php
    require_once("./model/Usuari.php");
    require_once("./model/connected_m.php");
    class Connected{
        public function __construct($params, $body){
            $method = array_shift($params);
            $api_key = array_shift($params);
            switch ($method){
                case "GET":
                    $this->getConnected($params, $body, $api_key);
                    break;
                case "OPTIONS":
                    // Necessari per CORS preflight.
                    break;
                default:
                    http_response_code(405); // Mètode no permès!
            }
        }

        private function getConnected($params, $body, $api_key){
            $model = new Connected_model();
            $usuari = null;
            $stored_user = $model->getConnectedUser($api_key);
            if ($stored_user){
                require_once("./vista/connected_v.php");
            }else{
                http_response_code(401);
            }
            
        }
    }
?>