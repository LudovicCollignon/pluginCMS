<?php

class Order 
{
    public static function actionOrder(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            global $wpdb;
            $alerts = [];

            if(isset($_POST["add"]) || isset($_POST["edit"])){
                if(!isset($_POST["user_nom"]) || empty($_POST["user_nom"])){
                    $alerts["nom"] = "Merci de renseigner le nom de l'utilisateur !";
                }
                if(!isset($_POST["user_prenom"]) || empty($_POST["user_prenom"])){
                    $alerts["prenom"] = "Merci de renseigner le prenom de l'utilisateur !";
                }

                if(empty($alerts)){
                    if(isset($_POST["add"])){
                        $wpdb->insert("{$wpdb->prefix}dve_orders", array(
                            "user_nom" => $_POST['user_nom'],
                            "user_prenom" => $_POST['user_prenom'],
                            "user_mail" => $_POST['user_mail'],
                            "horaire_id" => $_POST['horaire_id']
                        ));
                        
                        $order_id = $wpdb->insert_id; 
                        $inc = 0;
                        while (isset($_POST['order_menu'.++$inc])) {
                            $wpdb->insert("{$wpdb->prefix}dve_menu_order", array(
                                "menu_id" => $_POST['order_menu'.$inc],
                                "order_id" => $order_id
                            ));
                        }

                        $alerts["success"] = "La commande a été ajoutée !";
                    } else if(isset($_POST["edit"])){
                        
                        $wpdb->update($wpdb->prefix."dve_orders", array(
                            "horaire_id" => $_POST['horaire_id'],
                            "user_nom" => $_POST['user_nom'],
                            "user_prenom" => $_POST['user_prenom'],
                            "user_mail" => $_POST['user_mail']
                        ), array('id' => $_POST["order_id"]));

                        // $inc = 0;
                        while (isset($_POST['order_menu'.++$inc])) {
                            $ids = explode('-', $_POST['order_menu'.$inc]);
                            $menu_id = $ids[0];
                            $menu_order_id = $ids[1];

                            if ($menu_id != DB_Manager::getItemById('menu_order', $menu_order_id)[0]->menu_id) {
                                $wpdb->update($wpdb->prefix."dve_menu_order", array(
                                    "menu_id" => $menu_id
                                ), array('id' => $menu_order_id));
                            }

                        }
                    
                        $alerts["success"] = "La commande a été modifiée !";
                    }
                }
            } else if(isset($_POST["destroy"])){
                $wpdb->delete($wpdb->prefix."dve_menu_order", array('order_id' => $_POST["order_id"]));
                $wpdb->delete($wpdb->prefix."dve_orders", array('id' => $_POST["order_id"]));
                $alerts["success"] = "La commande a été supprimée !";
            }
            
            return $alerts;
        }
    }
}