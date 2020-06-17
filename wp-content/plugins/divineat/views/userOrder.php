<!DOCTYPE html>
<html>
    <head>
        <?php 
            global $DIVINEAT;
            echo "<link rel='stylesheet' href='".$DIVINEAT->_STYLE."style.css' type='text/css' media='all'>";
        ?>
        <script type="text/javascript" src="<?= $DIVINEAT->_JS."orders.js" ?>"></script>
    </head>
    <body>
        <?php
            get_header();
        ?>

        <div class="order">
            <?php
                include_once($DIVINEAT->_INC."class.order.php");
                $alerts = Order::actionOrder();
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
            
            <h1>Reservez une table</h1>

            <form action='' method='post' class='admin-form' onsubmit="return confirm('Etes-vous sûr ?');">
                <p><label for='user_prenom'>Prénom</label><input id='user_prenom' name='user_prenom' type='text' class='form-control'></p>
                <p><label for='user_nom'>Nom</label><input id='user_nom' name='user_nom' type='text' class='form-control'></p>
                <p><label for='user_mail'>Adresse mail (facultatif)</label><input id='user_mail' name='user_mail' type='text' class='form-control'></p>
                <p>
                    <label for='horaire_id'>Horaire</label>
                    <select name='horaire_id' id='horaire_id' class='form-control'>
                        <?php 
                            $horaires = DB_Manager::getItemsByTableName('horaires');
                            foreach ($horaires as $horaire):
                        ?>
                        <option value='<?= $horaire->id ?>'><?= $horaire->horaires ?></option>
                        <?php endforeach ?>
                    </select>
                </p>

                <?php 
                    $menus = DB_Manager::getItemsByTableName('menus'); 
                    $inc = 0;
                ?>
                <div id='add_menu_area'>
                    <p><label for='order_menu1'>Menu 1 :</label>
                        <select name='order_menu1' id='order_menu1' class='form-control'>
                            <?php foreach ($menus as $menu): ?>
                                <option value='<?= $menu->id ?>'><?= $menu->nom ?></option>
                            <?php endforeach; ?>
                        </select></p></div>
                <br>
                <div id='add_menu_btn' class='btn btn-default'>Ajouter un menu</div>
                <div id='remove_menu_btn' class='btn btn-remove' style='display: none'>Supprimer le dernier menu</div>
                <br>
                <br>
                <input name='add' type='submit' class='' value='Ajouter'>
            </form>
        </div>   

        <?php
        get_template_part( 'template-parts/footer-menus-widgets' );

        if(is_home()){
            get_footer("home");
        } else {
            get_footer();
        }
        ?>
    </body>
</html>

<script> orders(); </script>
