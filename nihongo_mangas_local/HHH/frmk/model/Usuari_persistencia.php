<?php
    Class Usuari_persistencia {
        public function __construct(){
            require_once("./model/connexio.php");
            $this->db=Connexio::connectar();
        }

        public function get_usuari($nick){
            $nick = strtolower($nick);
            $usuari = null;
            $id = null;
            $hash_password = null;
            $api_keys = Array();
            $sentencia = $this->db->prepare("SELECT * FROM usuaris left join api_keys on usuaris.id = api_keys.usuari where nick = ?");
            if ($sentencia->execute(array($nick))) {
                while ($fila = $sentencia->fetch()) {
                    $id = $fila["id"];
                    $hash_password = $fila["hash_password"];
                    array_push($api_keys, $fila["api_key"]);
                }
            }
            if (!!$id){
                $usuari = new Usuari($nick, $hash_password, $api_keys);
                $usuari->set_id($id);
                return $usuari;
            }
            return null;
        }

        public function get_usuari_by_UUID($uuid){
            $usuari = null;
            $nick = null;
            $sentencia = $this->db->prepare("SELECT nick FROM usuaris right join api_keys on usuaris.id = api_keys.usuari where api_keys.api_key = ?;");
            if ($sentencia->execute(array($uuid))) {
                
                if ($fila = $sentencia->fetch()) {
                    $nick = $fila["nick"];
                    $usuari = $this->get_usuari($nick);
                }
            }
            return $usuari;
        }

        public function store_usuari($usuari){
            $usuari_desat = $this->get_usuari($usuari->get_nick());
            if ($usuari_desat == null){
                return $this->store_new_usuari($usuari);
            }
            return $this->update_usuari($usuari_desat->get_id(), $usuari);
        }

        private function store_new_usuari($usuari){
            $api_keys = $usuari->get_x_api_keys();
            $sentencia = $this->db->prepare("INSERT INTO usuaris (nick, hash_password) VALUES (:nick, :hash_password);");
            $nick = $usuari->get_nick();
            $hash_password = $usuari->get_hash_password();
            $sentencia->bindParam(':nick', $nick);
            $sentencia->bindParam(':hash_password', $hash_password);
            $sentencia->execute();
            $usuari_desat = $this->get_usuari($nick);
            $user_id = $usuari_desat->get_id();
            $this->update_keys_for_user_id($user_id, $api_keys);
            return $user_id;
        }

        private function update_usuari($id, $usuari){
            $sentencia = $this->db->prepare("UPDATE usuaris SET hash_password = :hash_password WHERE id =". $id . ";");
            $hash_password = $usuari->get_hash_password();
            $sentencia->bindParam(':hash_password', $hash_password);
            $sentencia->execute();
            $this->update_keys_for_user_id($id, $usuari->get_x_api_keys());
            return $id;
        }

        private function update_keys_for_user_id($user_id, $keys){
            if ($keys == null) return;
            if (count($keys) == 0) return;
            $sentencia = $this->db->prepare("DELETE FROM api_keys where usuari =" . $user_id . ";");
            $sentencia->execute();
            for($i=0; $i< count($keys); $i++){
                $sentencia = $this->db->prepare("INSERT INTO api_keys (usuari, api_key) VALUES (:usuari, :api_key);");
                $sentencia->bindParam(':usuari', $user_id);
                $sentencia->bindParam(':api_key', $keys[$i]);
                $sentencia->execute();
            }
        }
    }
?>