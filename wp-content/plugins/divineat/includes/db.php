<?php

// Create table (activate plugin)
function dve_activation(){
    global $wpdb;

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_menus(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        nom VARCHAR(255) NOT NULL UNIQUE, 
        entree VARCHAR(255) NOT NULL, 
        plat VARCHAR(255), 
        dessert VARCHAR(255));"
    );
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_orders(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        id_user INT NOT NULL UNIQUE, 
        id_menu1 INT, 
        id_menu2 INT, 
        id_menu3 INT, 
        id_menu4 INT,
        FOREIGN KEY (id_menu1) REFERENCES {$wpdb->prefix}dve_menus(id),
        FOREIGN KEY (id_menu2) REFERENCES {$wpdb->prefix}dve_menus(id),
        FOREIGN KEY (id_menu3) REFERENCES {$wpdb->prefix}dve_menus(id),
        FOREIGN KEY (id_menu4) REFERENCES {$wpdb->prefix}dve_menus(id));"
    );
}

// Drop table (Deactivate plugin)
function dve_deactivation(){
    global $wpdb;
    
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_orders;");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_menus;");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}tdargent_table;");
}