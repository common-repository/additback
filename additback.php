<?php

/* 
Plugin Name: Additback, Facebook, Twitter Social Share
Plugin URI: http://www.additback.com
Description: For sharing and displaying reccomended articles
Author: Additback Team
Version: 2.5 
*/ 

$style = get_option( 'aib_widget_style' );
$counters = get_option( 'aib_widget_counters' );
$badges = get_option( 'aib_widget_badges' );

// First time defaults when user activates plugin
register_activation_hook( __FILE__, 'aib_activate' );
function aib_activate(){
	update_option( 'aib_widget_style', 'fixed' );
	update_option( 'aib_widget_counters', '1' );
	update_option( 'aib_widget_badges', '3' );
}

function aib_footer($content) {
	global $style, $counters, $badges;
	
	echo $content;
  echo '<script src="http://www.additback.com/code/additback-min.js"></script>';

	
	if ( $style == 'float' )
  {
 		echo '<div class="recommendy-badge" data-max_badges="'.$badges.'" data-counter="'.$counters.'" data-style="float"></div>';
  }
}


function aib_per_post($content) {
	global $style, $counters, $badges;
	echo $content;
	echo '<div class="recommendy-badge" data-max_badges="'.$badges.'" data-counter="'.$counters.'" data-url="'.get_permalink().'"></div>';
}


add_action('wp_footer', 'aib_footer');

if ( $style != 'float' )
	add_action('the_content', 'aib_per_post');








/*****************************************/
/************ ADMIN MENU *****************/
/*****************************************/

add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
	add_options_page( 'Additback Options', 'Additback', 'manage_options', 'aib-settings', 'my_plugin_options' );
}

/** Step 3. */
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	//var_dump($_POST);
	
	if ( isset($_POST['style']) ){
		update_option( 'aib_widget_style', $_POST['style'] );
	}
	if ( isset($_POST['counters']) ){
		update_option( 'aib_widget_counters', '1' );
	}else{
		update_option( 'aib_widget_counters', '0' );
	}
	if ( isset($_POST['badges']) ){
		update_option( 'aib_widget_badges', $_POST['badges'] );
	}
	
	$style = get_option( 'aib_widget_style' );
	$counters = get_option( 'aib_widget_counters' );
	$badges = get_option( 'aib_widget_badges' );
	
	echo '<div class="wrap">';
	echo '<div id="icon-edit-pages" class="icon32"></div>';
	echo '<h2>Additback Options</h2>';
	echo '<form method="POST" action="'.$_SERVER["REQUEST_URI"].'">';
	echo '<table class="form-table"><tbody>';
	
	echo '<tr><th>Widget style.</th>';
	echo '<td>';
	echo '<input id ="style_fixed" type="radio" value="fixed" '.($style=='fixed'? 'checked="checked"' : '').' name="style"> <label for="style_fixed">Fixed</label> ';
	echo '<input id ="style_float" type="radio" value="float" '.($style=='float'? 'checked="checked"' : '').' name="style"> <label for="style_float">Floating</label>';
	echo '</td></tr>';
	
	echo '<tr><th>Include Share count?</th>';
	echo '<td>';
	echo '<input id="aib_counters" type="checkbox" value="1" '.($counters=='1'? 'checked="checked"' : '').' name="counters"> <label for="aib_counters">Counters</label>';
	echo '</td></tr>';
		
	echo '<tr><th>No of Badges</th>';
	echo '<td>';
	echo '<select name="badges" id="badges">';
	echo '	<option value="1" '.($badges=='1'? 'selected="selected"' : '').'>1</option>';
	echo '	<option value="2" '.($badges=='2'? 'selected="selected"' : '').'>2</option>';
	echo '	<option value="3" '.($badges=='3'? 'selected="selected"' : '').'>3</option>';
	echo '	<option value="4" '.($badges=='4'? 'selected="selected"' : '').'>4</option>';
	echo '	<option value="5" '.($badges=='5'? 'selected="selected"' : '').'>5</option>';
	echo '</select>';
	echo '</td></tr>';

	echo '</tbody></table>';
	

	echo '<p class="submit"><input class="button-primary" type="submit" value="Save Options"></p>';
	echo '</form>';
	echo '</div>';
	
	echo '<script src="http://www.additback.com/code/additback-min.js"></script>';
	echo '<div class="recommendy-badge" data-max_badges="'.$badges.'" data-counter="'.$counters.'" data-style="'.$style.'"></div>';

	if ( isset($_POST['style']) ){
		echo '<div class="updated settings-error" id="setting-error-settings_updated"><p><strong>Settings saved.</strong></p></div>';
	}
}
  
?>
