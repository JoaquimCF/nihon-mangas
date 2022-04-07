<?php
    Class Mangas_model {
        private $db;
        private $mangas;
        private $nom_manga;
        private $price;
        private $fecha;
        public function __construct(){
            require_once("./model/connexio.php");
            $this->db=Connexio::connectar();
            $this->mangas=array();
        }

        public function getmangas(){
            $consulta = "SELECT * FROM mangas";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                $this->mangas[]=$fila;
            }
            return $this->mangas;
        }

        public function getmangasByName($nom_manga){
            $consulta = "SELECT * FROM mangas WHERE nom_manga =". $nom_manga .";";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                return $fila;
            }
            return null;
        }

        public function getmangasByPrice($price){
            $consulta = "SELECT * FROM mangas WHERE preu =". $price .";";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                $this->mangas[]=$fila;
            }
            return $this->mangas;
        }

        public function getmangasByDate($fecha){
            $consulta = "SELECT * FROM mangas WHERE fecha =". $fecha .";";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                $this->mangas[]=$fila;
            }
            return $this->mangas;
        }

        public function appendMangas($mangas){
            //$new_id = -1;
            if ($mangas){
                $consulta = "SELECT nom_manga FROM mangas ORDER BY nom_manga DESC LIMIT 1;";
                $result = $this->db->query($consulta);
                $last_name_manga = $result->fetch(PDO::FETCH_ASSOC)["nom_manga"];
                //$new_id = $last_id + 1;
                $consulta = "INSERT INTO mangas (nom_manga, img, preu, fecha) VALUES(:nom_manga, :img, :preu, :fecha);";
                $dades = [
                    'nom_manga'=>$mangas->nom_manga,
                    'img'=>$mangas->img,
                    'preu'=>$mangas->preu,
                    'fecha'=>$mangas->fecha
                ];
                $this->db->prepare($consulta)->execute($dades);
            }
            //return $new_id;
        }

        public function deletePeliByName($nom_manga){
            $consulta = "DELETE FROM Mangas WHERE nom_mangas=?;";
                
            $res_delete = $this->db->prepare($consulta)->execute(array($nom_manga));
        }
    }
?>