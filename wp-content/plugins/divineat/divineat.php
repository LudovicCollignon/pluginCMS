<?php
/*
 * Plugin name: DivinEat
 * Description: First plugin by divineat 
 * Author: divineat
 * Author URI: https://github.com/LudovicCollignon/pluginCMS
 * Version: 0.1
*/

class DivinEat_Setup {
    public $_NAME,$_VERSION,$_FOLDER,$_DIR,$_INC,$_URL,$_INC_URL,$_DOMAIN;

    public function __construct() {
      $this->_define_constants();
      $this->include_files();
    }

    private function _define_constants() {
        $this->_VERSION='0.1';
        $this->_NAME='DivinEat';
        $this->_FOLDER = basename(dirname(__FILE__));
        $this->_DIR = plugin_dir_path(__FILE__);
        $this->_INC = $this->_DIR.'includes'.'/';
        $this->_URL= plugin_dir_url($this->_FOLDER).$this->_FOLDER .'/';
        $this->_INC_URL= $this->_URL.'includes'.'/';
        $this->_IMAGES= $this->_URL.'images'.'/';
        $this->_DOMAIN = $_SERVER['SERVER_NAME'];
        $this->_JS = $this->_URL.'javascript'.'/';
        $this->_STYLE = $this->_URL.'styles'.'/';
        $this->_VIEW = $this->_DIR.'views'.'/';
    }

    private function include_files() {
        include_once($this->_INC."functions.php");
        include_once($this->_INC."loadUserOrder.php");
    }
}

$DIVINEAT = null;
add_action('init','DivinEat_init');
function DivinEat_init(){
    global $DIVINEAT;
    $DIVINEAT = new DivinEat_Setup();
}

// DB generate tables
include_once plugin_dir_path(__FILE__)."includes/db.php";
register_activation_hook(__FILE__, "dve_activation");
register_deactivation_hook(__FILE__, "dve_deactivation");