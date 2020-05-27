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
            <h1>DivinEat : Home<h1>
            <?php
                $alerts = actionHoraire();
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

            <p>Merci d'avoir choisi le plugin DivinEat !</p>
            <p>Il ne vous reste plus qu'à configurer votre page de réservation et vos horaires de réservations.</p>
            <p><i>Pour configurer votre page de réservation : Allez dans l'onglet page et ajouter une page nommée</i> <b>order</b>.</p>

            <h2>Horaire pour réservation<h2>
            <form action="" method="post" class="admin-form">
                <p><label for="horaire">Horaire</label><input id="horaire" name="horaire" type="text" placeholder="Ex : 11h - 12h"class="form-control"></p>
                <input name="add" type="submit" class="btn btn-primary" value="Ajouter">
            </form>
            
            <br><br>

            <?php $horaires = getHoraires(); ?>
            <h2>Liste des horaires<h2>
            <div class="table-wrapper">
                <table class="admin-table">
                    <tr>
                        <th>ID</th>
                        <th>Horaire</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    if(!empty($horaires)){
                        foreach ($horaires as $key => $horaire):?>
                            <form action="" method="post">
                            <tr>
                                <td><input type="text" name="id" readonly="true" value="<?= $horaire->id ?>"></td>
                                <td><input type="text" name="horaire" value="<?= $horaire->horaires ?>"></td>
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
function actionHoraire(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        global $wpdb;
        $alerts = [];

        if(isset($_POST["add"]) || isset($_POST["edit"])){
            if(isset($_POST["horaire"]) && !empty($_POST["horaire"])){
                $horaire = $_POST["horaire"];
            } else {
                $alerts["horaire"] = "Merci de renseigner l'horaire !";
            }

            if(empty($alerts)){
                if(isset($_POST["add"])){
                    $wpdb->insert("{$wpdb->prefix}dve_horaires", array(
                        "horaires" => $horaire
                    ));
                    $alerts["success"] = "L'horaire a été ajoutée !";
                } else {
                    $wpdb->update($wpdb->prefix."dve_horaires", array(
                        "horaires" => $horaire
                    ), array('id' => $_POST["id"]));
                    $alerts["success"] = "L'horaire a été modifiée !";
                }
            }
        } else if(isset($_POST["destroy"])){
            $wpdb->delete($wpdb->prefix."dve_horaires", array('id' => $_POST["id"]));
            $alerts["success"] = "L'horaire a été supprimée !";
        }
        
        return $alerts;
    }
}

function getHoraires(){
    global $wpdb;
    $select = "select * from {$wpdb->prefix}dve_horaires";
    $resultats = $wpdb->get_results($select);

    return $resultats;
}