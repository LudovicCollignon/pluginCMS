<?php

class Menu
{
    public static function actionMenu(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            global $wpdb;
            $alerts = [];

            if(isset($_POST["add"]) || isset($_POST["edit"])){
                if(isset($_POST["nom_menu"]) && !empty($_POST["nom_menu"])){
                    $nom = $_POST["nom_menu"];
                } else {
                    $alerts["nom"] = "Merci de renseigner le nom du menu !";
                }
        
                if(isset($_POST["entree_menu"]) && !empty($_POST["entree_menu"])){
                    $entree = $_POST["entree_menu"];
                } else {
                    $alerts["entree"] = "Merci de renseigner l'entrée du menu !";
                }
        
                if(isset($_POST["plat_menu"]) && !empty($_POST["plat_menu"])){
                    $plat = $_POST["plat_menu"];
                } else {
                    $alerts["plat"] = "Merci de renseigner le plat du menu !";
                }
        
                if(isset($_POST["dessert_menu"]) && !empty($_POST["dessert_menu"])){
                    $dessert = $_POST["dessert_menu"];
                } else {
                    $alerts["dessert"] = "Merci de renseigner le dessert du menu !";
                }
        
                if(isset($_POST["prix_menu"]) && !empty($_POST["prix_menu"])){
                    $prix = $_POST["prix_menu"];
                } else {
                    $alerts["prix"] = "Merci de renseigner un prix au menu !";
                }

                if(empty($alerts)){
                    if(isset($_POST["add"])){
                        $wpdb->insert("{$wpdb->prefix}dve_menus", array(
                            "nom" => $nom,
                            "entree" => $entree,
                            "plat" => $plat,
                            "dessert" => $dessert,
                            "prix" => $prix
                        ));
                        $alerts["success"] = "Le menu a été ajouté !";
                    } else {
                        $wpdb->update($wpdb->prefix."dve_menus", array(
                            "nom" => $nom,
                            "entree" => $entree,
                            "plat" => $plat,
                            "dessert" => $dessert,
                            "prix" => $prix
                        ), array('id' => $_POST["id_menu"]));
                        $alerts["success"] = "Le menu a été modifié !";
                    }
                }
            } else if(isset($_POST["destroy"])){
                $wpdb->delete($wpdb->prefix."dve_menus", array('id' => $_POST["id_menu"]));
                $alerts["success"] = "Le menu a été supprimé !";
            }
            
            return $alerts;
        }
    }
}