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
                include_once($DIVINEAT->_INC."class.menu.php");
                $alerts = Menu::actionMenu();
                if(!empty($alerts)) {
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
            <h2>Ajouter un menu<h2>
            <form action="" method="post" class="admin-form">
                <p><label for="nom_menu">Nom</label><input id="nom_menu" name="nom_menu" type="text" class="form-control"></p>
                <p><label for="entree_menu">Entrée</label><input id="entree_menu" name="entree_menu" type="text" class="form-control"></p>
                <p><label for="plat_menu">Plat</label><input id="plat_menu" name="plat_menu" type="text" class="form-control"></p>
                <p><label for="dessert_menu">Dessert</label><input id="dessert_menu" name="dessert_menu" type="text" class="form-control"></p>
                <p><label for="prix_menu">Prix</label><input id="prix_menu" name="prix_menu" type="number" class="form-control"></p>
                <input name="add" type="submit" class="btn btn-primary" value="Ajouter">
            </form>
            
            <br><br>

            <?php $menus = DB_Manager::getItemsByTableName('menus'); ?>
            <h2>Liste des menus<h2>
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