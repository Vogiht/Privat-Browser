<?php

/**
 * Plugin Name:       Incotect 
 * Plugin URI:        https://
 * Description:       This plugin is used to check if the browser is opened in Privat Modus. Use the Shortcode to enable incognito detection : [rls_incotect]
 * Version:           1.2
 * Author:            Voight
 * Author URI:        https://www.google.de
 */

    function incognito_detect(){
        include 'algo.php';
    }

    add_shortcode('rls_incotect', 'incognito_detect');


 ?>
