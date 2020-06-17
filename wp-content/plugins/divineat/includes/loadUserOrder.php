<?php
function loadViewUserOrder()
{
    global $DIVINEAT;

    if(is_page('order') || is_page('orders') || is_page('commandes')){
        include($DIVINEAT->_VIEW."userOrder.php");
        die();
    }
}

add_action('wp', 'loadViewUserOrder');