<?php
// Add admin menu for settings
add_action("admin_menu", "dve_addAdminMenu");

function dve_addAdminMenu(){
    add_menu_page("Plugin DivinEat Home", "DivinEat", "manage_options", 
        "divineat/views/divineat-acp.php");
}