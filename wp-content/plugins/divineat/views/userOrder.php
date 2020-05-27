<?php 
get_header();

global $wpdb;
global $DIVINEAT;

$horaires = $wpdb->get_results("SELECT horaires FROM {$wpdb->prefix}dve_horaires");
$menus = $wpdb->get_results("SELECT id, nom, prix FROM {$wpdb->prefix}dve_menus");

$alerts = actionOrderUser();
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

<h1>Reservez une table</h1>

<form action="" method="post" class="comment-form" onsubmit="return confirm('Etes-vous sûr ?');">
    <p><label for="email_order">Email</label><input id="email_order" name="email_order" type="email" class=""></p>

    <p><label for="personnes_order">Nombre de personnes</label>
        <select name="personnes_order" id="personnes_order" onchange="addInputMenu(this.value)">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
    </p>

    <!-- Menus -->
    <p><label for="menu1_order">Choix du premier menu</label>
        <select name="menu1_order" id="menu1_order">
            <?php
            foreach($menus as $menu): ?>
                <option value="<?= $menu->id ?>"><?= $menu->nom." - ".$menu->prix."€" ?></option>
            <?php 
            endforeach; ?>
        </select>
    </p>

    <p id="menu2"><label for="menu2_order">Choix du deuxième menu</label>
        <select name="menu2_order" id="menu2_order">
            <?php
            foreach($menus as $menu): ?>
                <option value="<?= $menu->id ?>"><?= $menu->nom." - ".$menu->prix."€" ?></option>
            <?php 
            endforeach; ?>
        </select>
    </p>

    <p id="menu3"><label for="menu3_order">Choix du troisième menu</label>
        <select name="menu3_order" id="menu3_order">
            <?php
            foreach($menus as $menu): ?>
                <option value="<?= $menu->id ?>"><?= $menu->nom." - ".$menu->prix."€" ?></option>
            <?php 
            endforeach; ?>
        </select>
    </p>

    <p id="menu4"><label for="menu4_order">Choix du quatrième menu</label>
        <select name="menu4_order" id="menu4_order">
            <?php
            foreach($menus as $menu): ?>
                <option value="<?= $menu->id ?>"><?= $menu->nom." - ".$menu->prix."€" ?></option>
            <?php 
            endforeach; ?>
        </select>
    </p>

    <p><label for="horaires_order">Horaire</label>
        <select name="horaires_order" id="horaires_order">
            <?php
            $i = 1;
            foreach($horaires as $horaire): ?>
                <option value="<?= $horaire->horaires ?>"><?= $horaire->horaires ?></option>
            <?php 
            $i++;
            endforeach; ?>
        </select>
    </p> 

    <input name="add" type="submit" class="btn btn-primary" value="Valider">
</form>

<?php
get_template_part( 'template-parts/footer-menus-widgets' );

if(is_home()){
    get_footer("home");
} else {
    get_footer();
}
?>

<script type="text/javascript" src="<?= $DIVINEAT->_JS."user_order.js" ?>"></script>

<?php
function actionOrderUser(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        global $wpdb;
        $alerts = [];

        if(isset($_POST["email_order"]) && !empty($_POST["email_order"])){
            $email_order = $_POST["email_order"];
        } else {
            $alerts["email_order"] = "Merci de renseigner une adresse email !";
        }

        $personnes_order = $_POST["personnes_order"];

        $menus = [];
        for($i = 1; $i <= $personnes_order; $i++){
            $menus["id_menu".$i] = $_POST["menu".$i."_order"];
        }

        $horaires_order = $_POST["horaires_order"];

        $insert = [
            "email_user" => $email_order,
            "horaire" => $horaires_order
        ];
        foreach($menus as $key => $id_menu){
            $insert[$key] = $id_menu;
        }

        if(empty($alerts)){
            $wpdb->insert("{$wpdb->prefix}dve_orders", $insert);

            $alerts["success"] = "Le menu a été ajouté !";
        }
        
        return $alerts;
    }
}