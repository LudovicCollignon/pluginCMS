<?php

class DB_Manager
{
    public static function getMenusByOrderId($order_id) {
        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "select menu_order.id as menu_order_id, menus.* from {$wpdb->prefix}dve_orders as orders
                inner join {$wpdb->prefix}dve_menu_order as menu_order on orders.id = menu_order.order_id
                inner join {$wpdb->prefix}dve_menus as menus on menu_order.menu_id = menus.id
                where orders.id =  %d",
                $order_id
            )
        );

        return $result;
    }

    public static function getHoraireByOrderId($order_id) {
        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "select horaires.* from {$wpdb->prefix}dve_horaires as horaires
                inner join {$wpdb->prefix}dve_orders as orders on horaires.id = orders.horaire_id
                where orders.id = %d",
                $order_id
            )
        );
        
        return $result;
    }

    public static function getItemsByTableName($table) {
        global $wpdb;
        $query = "select * from {$wpdb->prefix}dve_{$table};";
        $result = $wpdb->get_results($query);
        
        return $result;
    }

    public static function getItemById($table, $id) {
        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "select * from {$wpdb->prefix}dve_{$table} where id = %d",
                $id
            )
        );

        return $result;
    }
}