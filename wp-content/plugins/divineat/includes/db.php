<?php
// Create table (activate plugin)
function dve_activation(){
    global $wpdb;

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_menus(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        nom VARCHAR(255) NOT NULL UNIQUE, 
        entree VARCHAR(255) NOT NULL, 
        plat VARCHAR(255), 
        dessert VARCHAR(255),
        prix DOUBLE);"
    );
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_horaires(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        horaires VARCHAR(255));"
    );
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_orders(
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_nom VARCHAR(100) NOT NULL,
        user_prenom VARCHAR(100) NOT NULL,
        user_mail VARCHAR(100),
        horaire_id INT NOT NULL,
        FOREIGN KEY (horaire_id) REFERENCES {$wpdb->prefix}dve_horaires(id));"
    );

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_menu_order(
        id INT AUTO_INCREMENT PRIMARY KEY,
        menu_id INT NOT NULL,
        order_id INT NOT NULL,
        FOREIGN KEY (order_id) REFERENCES {$wpdb->prefix}dve_orders(id),
        FOREIGN KEY (menu_id) REFERENCES {$wpdb->prefix}dve_menus(id));"
    );
}

// Drop table (deactivate plugin)
function dve_deactivation(){
    global $wpdb;
    
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_menu_order;");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_orders;");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_horaires;");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_menus;");
}