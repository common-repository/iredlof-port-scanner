<?php
/*
Plugin Name: Port Scanner Widget
Plugin URI: http://iredlof.com
Description: Port Scanner is used to scan open/closed ports of visitors. 
Author: Rohit LalChandani
Version: 1.0
Author URI: http://iredlof.com
*/
load_plugin_textdomain('pscanner','wp-content/plugins/sidebar-login/');
function validip($ip) {
    if (!empty($ip) && ip2long($ip)!=-1) {
        $reserved_ips = array (
        array('0.0.0.0','2.255.255.255'),
        array('10.0.0.0','10.255.255.255'),
        array('127.0.0.0','127.255.255.255'),
        array('169.254.0.0','169.254.255.255'),
        array('172.16.0.0','172.31.255.255'),
        array('192.0.2.0','192.0.2.255'),
        array('192.168.0.0','192.168.255.255'),
        array('255.255.255.0','255.255.255.255')
        );
 
        foreach ($reserved_ips as $r) {
            $min = ip2long($r[0]);
            $max = ip2long($r[1]);
            if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
        }
        return true;
    } else {
        return false;
    }
 }
 
function getip() {
    if (validip($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
        if (validip(trim($ip))) {
            return $ip;
        }
    }
    if (validip($_SERVER["HTTP_X_FORWARDED"])) {
        return $_SERVER["HTTP_X_FORWARDED"];
    } elseif (validip($_SERVER["HTTP_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    } elseif (validip($_SERVER["HTTP_FORWARDED"])) {
        return $_SERVER["HTTP_FORWARDED"];
    } elseif (validip($_SERVER["HTTP_X_FORWARDED"])) {
        return $_SERVER["HTTP_X_FORWARDED"];
    } else {
        return $_SERVER["REMOTE_ADDR"];
    }
 }

function port_scanner_widget($args) {
	extract($args);
	echo $before_widget . $before_title . __("iRedlof Port Scanner",'pscanner'). $after_title;
	?>
    <p><label for="psHost"><?php _e('Host:'); ?><br/><input name="psHost" value="<?php _e(getip())?>" class="mid" id="psHost" type="text" /></label></p>
			<p><label for="psPort"><?php _e('Port:'); ?><br/><input name="psPort" class="mid" id="psPort" type="text" value="80"/></label></p>
            <p class="submit"><label for="wp-submit"><input type="submit" name="wp-submit" id="wp-submit" value="<?php _e("Check Status",'pscanner'); ?>" onclick="javascript:portScannerupdate();"/></label></p>
<input type="hidden" name="wp-address" id="wp-address" value="<?php _e(get_bloginfo('wpurl')); ?>"/>
            <div><table><tr><td><label><?php _e("Status:",'pscanner');?></label></td><td id="port_scanner_status">Empty fields !</td></tr></table></div>
    <?php
	echo $after_widget;
	
}
function init_port_scanner_widget(){
	register_sidebar_widget(array('Port Scanner', 'widgets'), "port_scanner_widget");
}
add_action("plugins_loaded", "init_port_scanner_widget");
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-form');
wp_enqueue_script('port_scanner_handle', '/wp-content/plugins/port_scanner/js/port_scanner_script.js', array('jquery', 'jquery-form'));
//wp_enqueue_script('port_scanner_handle', '/wp-content/plugins/port_scanner/js/port_scanner_script.js', array('prototype'), '1.6'); 
?>