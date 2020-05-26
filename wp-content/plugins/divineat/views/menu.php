<!DOCTYPE html>
<html>
    <head>
        <?php 
            global $DIVINEAT;
            echo "<link rel='stylesheet' href='".$DIVINEAT->_STYLE."style.css?version=0.1' type='text/css' media='all'>";
        ?>
    </head>
    <body>
        <div class="wrap">
            <h1>DivinEat : Gestion des menus<h1>
            <?php
                $alerts = saveMenu();
                if(!empty($alerts)){
                    foreach($alerts as $key => $alert){
                        $class = ($key == "success")?"alert-success":"alert-warning";
                        echo "<div class='alert $class'>
                            <span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>"
                            .$alert.
                        "</div>";
                    }
                }
            ?>
            <form action="" method="post" class="admin-form">
                <p><label for="nom_menu">Nom</label><input id="nom_menu" name="nom_menu" type="text" class="form-control"></p>
                <p><label for="entree_menu">Entrée</label><input id="entree_menu" name="entree_menu" type="text" class="form-control"></p>
                <p><label for="plat_menu">Plat</label><input id="plat_menu" name="plat_menu" type="text" class="form-control"></p>
                <p><label for="dessert_menu">Dessert</label><input id="dessert_menu" name="dessert_menu" type="text" class="form-control"></p>
                <p><label for="prix_menu">Prix</label><input id="prix_menu" name="prix_menu" type="number" class="form-control"></p>
                <input type="submit" class="btn btn-primary" value="Ajouter">
            </form>
            
            <br><br>

            <?php $menus = getMenu(); ?>
            <form action="" method="post">
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
                            <tr>
                                <td><?= $menu->id ?></td>
                                <td><?= $menu->nom ?></td>
                                <td><?= $menu->entree ?></td>
                                <td><?= $menu->plat ?></td>
                                <td><?= $menu->dessert ?></td>
                                <td><?= $menu->prix ?></td>
                                <td>
                                    <a href="" class="btn btn-edit">Modifier</a>
                                    <a href="" class="btn btn-remove">Supprimer</a>
                                </td>
                            </tr>
                        <?php 
                        endforeach;
                    } ?>
                </table> 
            </form>
            
        </div>
    </body>
</html>

<?php
function saveMenu(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        global $wpdb;
        $alerts = [];

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
            $wpdb->insert("{$wpdb->prefix}dve_menus", array(
                "nom" => $nom,
                "entree" => $entree,
                "plat" => $plat,
                "dessert" => $dessert,
                "prix" => $prix
            ));
            $alerts["success"] = "Le menu a été ajouté !";
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