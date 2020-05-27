<?php 
get_header();

global $wpdb;
global $DIVINEAT;

$horaires = $wpdb->get_results("SELECT horaires FROM {$wpdb->prefix}dve_horaires");
$menus = $wpdb->get_results("SELECT id, nom, prix FROM {$wpdb->prefix}dve_menus");
?>
<h1>Reservez une table</h1>

<form action="" method="post" class="">
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
            $i = 0;
            foreach($horaires as $horaire): ?>
                <option value="<?= $i ?>"><?= $horaire->horaires ?></option>
            <?php 
            $i++;
            endforeach; ?>
        </select>
    </p> 

    <input name="add" type="submit" class="btn btn-primary" value="Valider">
</form>

<?php
if(is_home()){
    get_footer("home");
} else {
    get_footer();
}
?>

<script type="text/javascript" src="<?= $DIVINEAT->_JS."user_order.js" ?>"></script>