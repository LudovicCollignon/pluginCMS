<!DOCTYPE html>
<html>
    <head>
        <?php 
            global $DIVINEAT;
            echo "<link rel='stylesheet' href='".$DIVINEAT->_STYLE."style.css' type='text/css' media='all'>";
        ?>
    </head>
    <body>
        <div class="wrap">
            <h1>DivinEat : Gestion des menus<h1>
            <?php
                $alerts = actionMenu();
                if(!empty($alerts)){
                    foreach($alerts as $key => $alert){
                        $class = ($key == "success")?"alert-success":"alert-warning";
                        ?>
                        <div class="alert <?php echo $class; ?>">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <?php echo $alert; ?>
                        </div>
                    <?php
                    }
                }
            ?>
            <form action="" method="post" class="admin-form">
                <p><label for="nom_menu">Nom</label><input id="nom_menu" name="nom_menu" type="text" class="form-control"></p>
                <p><label for="entree_menu">Entrée</label><input id="entree_menu" name="entree_menu" type="text" class="form-control"></p>
                <p><label for="plat_menu">Plat</label><input id="plat_menu" name="plat_menu" type="text" class="form-control"></p>
                <p><label for="dessert_menu">Dessert</label><input id="dessert_menu" name="dessert_menu" type="text" class="form-control"></p>
                <p><label for="prix_menu">Prix</label><input id="prix_menu" name="prix_menu" type="number" class="form-control"></p>
                <input name="add" type="submit" class="btn btn-primary" value="Ajouter">
            </form>
            
            <br><br>

            <?php $menus = getMenu(); ?>
            <div class="table-wrapper">
                <table class="admin-table">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Entrée</th>
                        <th>Plat</th>
                        <th>Dessert</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    if(!empty($menus)){
                        foreach ($menus as $key => $menu):?>
                            <form action="" method="post">
                            <tr>
                                <td><input type="text" name="id_menu" readonly="true" value="<?= $menu->id ?>"></td>
                                <td><input type="text" name="nom_menu" value="<?= $menu->nom ?>"></td>
                                <td><input type="text" name="entree_menu" value="<?= $menu->entree ?>"></td>
                                <td><input type="text" name="plat_menu" value="<?= $menu->plat ?>"></td>
                                <td><input type="text" name="dessert_menu" value="<?= $menu->dessert ?>"></td>
                                <td><input type="number" name="prix_menu" value="<?= $menu->prix ?>"></td>
                                <td>
                                    <input name="edit" type="submit" class="btn btn-edit" value="Modifier">
                                    <input name="destroy" type="submit" class="btn btn-remove" value="Supprimer">
                                </td>
                            </tr>
                            </form>
                        <?php 
                        endforeach;
                    } ?>
                </table>    
            </div>
        </div>
    </body>
</html>

<?php
function actionMenu(){
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

function getMenu(){
    global $wpdb;
    $select = "select * from {$wpdb->prefix}dve_menus";
    $resultats = $wpdb->get_results($select);

    return $resultats;
}