<?php
register_activation_hook(__FILE__, "dve_activation");
register_deactivation_hook(__FILE__, "dve_deactivation");
// Create table (activate plugin)
function dve_activation(){
    global $wpdb;

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_menus(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        nom VARCHAR(255) NOT NULL UNIQUE, 
        entree VARCHAR(255) NOT NULL, 
        plat VARCHAR(255), 
        dessert VARCHAR(255),
        prix INT);"
    );
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_orders(
        id INT AUTO_INCREMENT PRIMARY KEY,
        email_user VARCHAR(55),
        horaire VARCHAR(55),
        id_menu1 INT,
        id_menu2 INT,
        id_menu3 INT,
        id_menu4 INT,
        disponible VARCHAR(55),
        FOREIGN KEY (id_menu1) REFERENCES {$wpdb->prefix}dve_menus(id),
        FOREIGN KEY (id_menu2) REFERENCES {$wpdb->prefix}dve_menus(id),
        FOREIGN KEY (id_menu3) REFERENCES {$wpdb->prefix}dve_menus(id),
        FOREIGN KEY (id_menu4) REFERENCES {$wpdb->prefix}dve_menus(id));"
    );

    insertHoraires();

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dve_logsorders(
        id INT AUTO_INCREMENT PRIMARY KEY,
        email_user VARCHAR(55),
        horaire VARCHAR(55),
        id_menu1 INT,
        id_menu2 INT,
        id_menu3 INT,
        id_menu4 INT,
        disponible VARCHAR(55),
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
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_logsorders;");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dve_menus;");
}

function insertHoraires(){
    global $wpdb;

    $wpdb->query("INSERT INTO {$wpdb->prefix}dve_orders (horaire, disponible) VALUES 
        ('11h - 12h', 'true'), 
        ('12h - 13h', 'true'), 
        ('13h - 14h', 'true'), 
        ('14h - 15h', 'true'), 
        ('18h - 19h', 'true'), 
        ('19h - 20h', 'true'), 
        ('21h - 22h', 'true'), 
        ('22h - 23h', 'true'), 
        ('23h - 00h', 'true');"
    );
}