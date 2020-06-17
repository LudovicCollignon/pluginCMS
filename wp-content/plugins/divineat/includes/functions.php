<?php
add_action('admin_menu', 'dve_addAdminMenu');

function dve_addAdminMenu(){
    add_menu_page('DivinEat Panel', 'DivinEat', 'manage_options', 'divinEat-page', 'dve_menu_divineat');
    add_submenu_page('divinEat-page', 'Orders page', 'Commandes', 'manage_options', 'orders-page', 'dve_submenu_order');
    add_submenu_page('divinEat-page', 'Menus page', 'Menus', 'manage_options', 'menus-page', 'dve_submenu_menu');
}

function dve_menu_divineat(){
    global $DIVINEAT;
    loadView($DIVINEAT->_VIEW."home.php");
}
function dve_submenu_order(){
    global $DIVINEAT;
    loadView($DIVINEAT->_VIEW."order.php");
}
function dve_submenu_menu(){
    global $DIVINEAT;
    loadView($DIVINEAT->_VIEW."menu.php");
}

function loadView($url){
    include $url;
}