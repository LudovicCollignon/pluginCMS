<?php
function loadViewUserOrder()
{
    global $DIVINEAT;

    if(is_page('order')){
        include($DIVINEAT->_VIEW."userOrder.php");
        die();
    }
}

add_action('wp', 'loadViewUserOrder');