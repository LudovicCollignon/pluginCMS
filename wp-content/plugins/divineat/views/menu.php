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
                <input type="submit" class="btn btn-primary" value="Ajouter">
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

        if(empty($alerts)){
            $wpdb->insert("{$wpdb->prefix}dve_menus", array(
                "nom" => $nom,
                "entree" => $entree,
                "plat" => $plat,
                "dessert" => $dessert
            ));

            $alerts["success"] = "Le menu a été ajouté !";
        }

        return $alerts;
    }
}