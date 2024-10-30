<?php
/*
Plugin Name: IGIT Follow Me After Post Button
Plugin URI: http://www.hackingethics.com/blog/wordpress-plugins/igit-follow-me-after-post-button-new/
Description: Enable follow me on twitter button on every post.
Version: 1.7
Author: Ankur Gandhi
Author URI: http://www.hackingethics.com/

License: GNU General Public License (GPL), v3 (or newer)

License URI: http://www.gnu.org/licenses/gpl-3.0.html

Tags:Related posts, related post with images

Copyright (c) 2010 - 2012 Ankur Gandhi. All rights reserved.

 

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");
define('IGIT_IMAGE_DATA','igit_image_data');
// contains all twitter images data.
require_once 'includes/twitter-images-data.php';
// helper functions for html output.
require_once 'includes/html-helpers.php';
//add defaults to an array
$igit_plug_opts = array(
	'igit_twt_images' => array_keys($twt_img_data),
);
//add to database
add_option(IGIT_IMAGE_DATA, $igit_plug_opts);
update_option(IGIT_IMAGE_DATA, $igit_plug_opts);
//reload
$igit_plug_opts = get_option(IGIT_IMAGE_DATA);
add_action('admin_menu', 'my_plugin_menu');
add_filter('the_content', 'show_twitter_fllw_btn');
$plgin_dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
function my_plugin_menu() {
 // add_options_page('My Plugin Options', 'My Plugin', 'capability_required', 'your-unique-identifier', 'my_plugin_options');
	add_options_page('Show Follow Me Button on Every Page', 'Follow Me After Post', 'administrator', 'follow_me_aft_post', 'my_follow_btn_af_post_function');
}
/****************** Function to Show buttons **********************/
function show_twitter_fllw_btn($content) {
 global $igit_plug_opts, $twt_img_data,$plgin_dir;
        if(!is_home() && get_option('twtr_usr_nam') && (get_option('folow_me_bt_evry_post') == "1")) {
		$igit_img_var = get_option('igit_twtr_img');
		$twit_img_val = get_option('igit_sel_img');
		$twit_img_name = $twt_img_data[$twit_img_val]['baseUrl'];
		$twt_uname = get_option('twtr_usr_nam');
		
		if(strpos($twit_img_val,'http://') !== false)
	    {
			
			$twitter_usr_url = '<div align="center"><a href="http://twitter.com/'.$twt_uname.'" target="_blank"><img src="'.$twit_img_val.'" /></a></div>';
		}
		else{
			$plgin_dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
			$twitter_usr_url = '<div align="center"><a href="http://twitter.com/'.$twt_uname.'" target="_blank"><img src="'.$plgin_dir.$twit_img_name.'" /></a></div>';
		}
		
		
                $content.= $twitter_usr_url;
        }
        return $content;
}
/****************** End of Function to Show buttons **********************/
/****************** Function Save data and show admin page **********************/
function my_follow_btn_af_post_function() {
 global $igit_plug_opts, $twt_img_data,$plgin_dir;
  if($_POST['sb_submit'])
  {	
  	update_option('folow_me_bt_evry_post',$_POST['folow_me_bt_evry_post']);
	update_option('twtr_usr_nam',$_POST['twtr_usr_nam']);
	update_option('igit_twtr_img',$_POST['igit_twtr_img']);
	if($_POST['igit_tw_upload_image'])
	{
		update_option('igit_sel_img',$_POST['igit_tw_upload_image']);
	}
	else
	{
		update_option('igit_sel_img',$_POST['twt_image'][0]);
	}
	
	$message_succ = '<div id="message" class="updated fade"><p>Option Saved!</p></div>';
 }
 else
 {
 	$message_succ = "";
 }
  if (get_option('folow_me_bt_evry_post')) {
	$folow_me_bt_evry_post = ' checked="checked"';
    } else {
        $folow_me_bt_evry_post = '';
    }
	if (get_option('twtr_usr_nam')) {
		$twt_user_name = get_option('twtr_usr_nam');
	$twtr_usr_nam = $twt_user_name;
    } else {
        $twtr_usr_nam = '';
    }
	$tw_img_val = get_option('igit_sel_img');
	if(strpos($tw_img_val,'http://') !== false)
	{
		
		$tw_usr_url = $tw_img_val;
	}
	else
	{
		$tw_usr_url = "";
	}
  echo $message_succ.'<div class="wrap"><div id="icon-options-general" class="icon32"><br/></div>
 	<form id="options_form_igit_follow_me" method="post" action="">
		<h2>IGIT Follow Me button after every post</h2> 
		<div style="padding-left: 10px;height: 22px;padding-top: 7px;"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FHackingEthics&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35&amp;appId=422733157774758" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe></div>
		<table class="form-table">
			<tbody>
				<tr valign="top">
				<th scope="row"><label for="blogname">Twitter Username :</label></th>
					<td><input type="text" class="regular-text code" value="'.$twtr_usr_nam.'" id="twtr_usr_nam" name="twtr_usr_nam" gtbfieldid="86"/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Display after Post?</label></th>
					<td><input type="checkbox" id="folow_me_bt_evry_post" name="folow_me_bt_evry_post" value="1" '.$folow_me_bt_evry_post.'/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Images</label></th>
					<td><div><div style="float: left; padding-top: 1px; padding-right: 37px;">Upload Image(Enter an URL or upload an image for Twitter.) : (<a href="javascript:;" id="igit_tw_remove_image">Remove Image</a>)</div><br style="clear:both;"><div>&nbsp;	&nbsp;	<label for="upload_image">
<div style="float:left;padding-top: 18px;"><input id="igit_tw_upload_image" type="text" size="36" name="igit_tw_upload_image" value="'.$tw_usr_url.'" />
<input id="igit_tw_upload_image_button" type="button" value="Upload Image" /></div><div style="margin-left: 22px;float: left;display: inline-block;margin-top: 0px;padding-top: 0px;" id="igit_tw_preview_fb"><img src="'.$tw_usr_url.'" /></div>
<br />
</label></div></div><br style="clear:both;"><hr>';
		foreach ($igit_plug_opts['igit_twt_images'] as $name) 
		{
			print igit_network_input_select($name, $twt_img_data[$name]['check'],get_option('igit_sel_img'));
			//echo @in_array(get_option('igit_sel_img'), $igit_plug_opts['igit_twt_images']);
		}						
echo '</td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"><input type="submit" name="sb_submit" id="sb_submit" value="Update Options" /></td>
				</tr>
			</tbody>
		</table>
		
	</form>
</div>';
}
/****************** End of Function Save data and show admin page **********************/
function igit_tw_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload-igit-tw', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'js/my-script.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload-igit-tw');
}

function igit_tw_admin_styles() {
wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'follow_me_aft_post') {
add_action('admin_print_scripts', 'igit_tw_admin_scripts');
add_action('admin_print_styles', 'igit_tw_admin_styles');
}
?>
