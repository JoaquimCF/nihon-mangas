<?php
    require_once("./model/mangas_m.php");
    class Manga{
        public function __construct($params, $body){
            $method = array_shift($params);
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

        private function getManga($params){
            $model = new Mangas_model();
            if (count($params) == 0){
                $mangas = $model->getMangas();
            }else{
                switch (strtolower($params[0])){
                    case "nom":
                        $mangas = $model->getmangasByName($params[1]);
                        break;
                    case "preu":
                        $mangas = $model->getmangasByPrice($params[1]);
                        break;
                    case "data":
                        $mangas = $model->getmangasByDate($params[1]);
                        break;
                    default:
                        echo "bad request";
                }
            }
            require_once("./vista/manga_v.php");
        }

        private function postMangas($params, $body){
            //$model = new Manga_model();
            $nom_manga = $params[0];
            $img = $params[1];
            $preu = $params[2];
            $fecha = $params[3];

            $manga = new Mangas_model($nom_manga, $img, $preu, $fecha);
            //var_dump($stored_user);
            $manga_ok = ($nom_manga != NULL && $img != NULL && $preu != NULL && $fecha != NULL);
            if ($manga_ok){
                $manga->appendMangas();
                http_response_code(201);
                require_once("./vista/mangas_v.php");
            }else{
                http_response_code(401);
            }
            
        }

        private function deleteMangas($params){
            $model = new Mangas_model();
            if (count($params) == 0){
                echo "bad request";
            }else{
                switch (strtolower($params[0])){
                    case "name":
                        $mangas = $model->deleteMangaByName($params[1]);
                        break;
                    default:
                        echo "bad request";
                }
            }
            http_response_code(204);
        }
    }
?>