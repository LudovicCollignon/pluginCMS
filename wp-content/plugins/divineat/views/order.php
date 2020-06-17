
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
        <div class="wrap">

            <h1>DivinEat Plugin</h1>
            <br>

            <?php
                include_once($DIVINEAT->_INC."class.order.php");
                $alerts = Order::actionOrder();
                if(!empty($alerts)){
                    foreach($alerts as $key => $alert){
                        $class = ($key == "success")?"notice-success":"notice-warning";
                        ?>
                        <div class="notice <?php echo $class; ?> is-dismissible">
                            <p><?php echo $alert; ?></p>
                        </div>
                    <?php
                    }
                }
            ?>

            <?php if (!isset($_GET["order_id"])) { ?>

            <h2>Créer une commande<h2>
                
            <form action='' method='post' class='admin-form'>
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
                <input name='add' type='submit' class='btn btn-primary' value='Ajouter'>
            </form>   

            <br><br>

            <div id='dve-order-list' class='table-wrapper'>
                
                <h2>Liste des commandes<h2>
                
                <table class='admin-table'>
                    <tr>
                        <th>Prénom client</th>
                        <th>Nom client</th>
                        <th>Horaire</th>
                        <th>Liste des menus</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                        $orders = DB_Manager::getItemsByTableName('orders');
                        if(!empty($orders)){
                            foreach ($orders as $key => $order): ?>
                                
                                <form action="" method="post">
                                    <tr>
                                        <td><?= $order->user_prenom; ?></td>
                                        <td><?= $order->user_nom; ?></td>
                                        <td><?= DB_Manager::getHoraireByOrderId($order->id)[0]->horaires; ?></td>
                                        <td>
                                            <?php 
                                            $menus = DB_Manager::getMenusByOrderId($order->id);
                                            $menu_names = '';
                                            foreach ($menus as $menu): 
                                                $menu_names .= $menu->nom . ', ';
                                            endforeach; 
                                            echo trim($menu_names, ', ');
                                            ?>
                                        </td>
                                        <td>
                                            <input name="order_id" type="text" value="<?= $order->id; ?>" style="display: none;">
                                            <a class="btn btn-edit" href="<?= get_admin_url() . "admin.php?page=orders-page&order_id=" . $order->id; ?>">Modifier</a>
                                            <input name="destroy" type="submit" class="btn btn-remove" value="Supprimer">
                                        </td>
                                    </tr>
                                </form>
                    <?php 
                            endforeach;
                        } ?>
                </table>
            </div>

            <?php } else { ?>
                
            <h2>Modification d'une commande<h2>

            <div id="dve-update-area" class="table-wrapper">


                <form action="<?= get_admin_url() . "admin.php?page=orders-page"; ?>" method="post">
                    <?php
                    $order_id = $_GET['order_id'];
                    $order = DB_Manager::getItemById('orders', $order_id)[0];
                    $order_menus = DB_Manager::getMenusByOrderId($order_id);
                    $all_menus = DB_Manager::getItemsByTableName('menus');
                    $all_horaires = DB_Manager::getItemsByTableName('horaires');
                    $order_horaire = DB_Manager::getHoraireByOrderId($order_id)[0];
                    $inc = 0; 
                    ?>   
                    <p><label for='user_prenom'>Prénom</label><input id='user_prenom' name='user_prenom' type='text' class='form-control' value='<?= $order->user_prenom; ?>'></p>
                    <p><label for='user_nom'>Nom</label><input id='user_nom' name='user_nom' type='text' class='form-control' value='<?= $order->user_nom; ?>'></p>
                    <p><label for='user_mail'>Adresse Mail</label><input id='user_mail' name='user_mail' type='text' class='form-control' value='<?= $order->user_mail; ?>'></p>
                    
                    <p>
                        <label for='horaire_id'>Horaire</label>
                        <select name='horaire_id' id='horaire_id' class='form-control'>
                            <option value='<?= $order_horaire->id ?>' selected><?= $order_horaire->horaires ?></option>
                            <?php 
                            foreach ($all_horaires as $horaire): 
                                if ($horaire->id != $order_horaire->id): ?>
                                    <option value='<?= $horaire->id ?>'><?= $horaire->horaires ?></option>
                                <?php endif;
                            endforeach; ?>
                        </select>
                    </p>
                    <br>
                    <?php foreach ($order_menus as $menu):  ?>
                    <p>
                        <label for='order_menu<?= ++$inc ?>'>Menu <?= $inc; ?> : </label>
                        <select name='order_menu<?= $inc ?>' id='order_menu<?= $inc ?>' class='form-control'>
                            <option value='<?= $menu->id.'-'.$menu->menu_order_id ?>' selected><?= $menu->nom ?></option>
                            <?php 
                            foreach ($all_menus as $one_menu):
                                if ($one_menu->id != $menu->id): ?>
                                    <option value='<?= $one_menu->id.'-'.$menu->menu_order_id ?>'><?= $one_menu->nom ?></option>
                                <?php endif;
                            endforeach ?>
                        </select>
                    </p>
                    <?php endforeach ?>
                    <br>
                    <input name="order_id" type="text" value="<?= $order_id; ?>" style="display: none;">
                    <input id="dve-update-order-btn" name="edit" type="submit" class="btn btn-primary" value="Valider">
                    <a class="btn btn-cancel" href="<?= get_admin_url() . "admin.php?page=orders-page"; ?>">Annuler</a>
                    <input name="destroy" type="submit" class="btn btn-remove" value="Supprimer">
                </form>
            
            </div>

            <?php } ?>
        </div>
    </body>

    <script>
        orders();
    </script>


