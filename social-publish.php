<?php
/*
Plugin Name: Social Publish
Plugin URI: http://blog.glue-labs.com/1035/wordpress-plugin-social-publish-2/
Description: this plugin helps you publish on yours social network applications like facebook and twitter
Version: 1.1
Author: Glue Labs
Author URI: http://www.glue-labs.com/
*/
/*  Copyright 2011  Glue Labs http://www.glue-labs.com  mailto:info@glue-labs.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * retrieve db option
 * @return array saved options
 */
function retrieve_option() {
    $options = array();
    $options['social_publish'] = get_option('gluelabs_social_publish');
    return $options;
}
function get_from_name() {
    $name = 'Glue Labs Blog'; 
    return $name;
}
function get_from_mail() {
    $mail = 'blog@glue-labs.com'; 
    return $mail;
}
function send_to_wall2($post_ID)  {
    $options = retrieve_option();
    $to= $options['social_publish']['secret_fb_mail'];
    $permalink = get_permalink();
    $title = get_post_field('post_title', $post_ID);
    if(isset ($_POST['publish']))$subject = 'Abbiamo pubblicato un nuovo post dal titolo "';
    else $subject= 'Abbiamo aggiornato il post "';
    $message = " $title \". Leggilo al seguente link $permalink ";
    $subject.=$message;
    //facebook
    $message= " ";
    wp_mail($to, $subject, $message);
    return $post_ID;
}
/**
 * Send to Wall
 * error code = (101 => facebook secret mail missing, 102 => phrase on publish missing, 103 => phrase on update missing))
 * @param <type> $post_ID
 * @return <type>
 */
function send_to_wall($post_ID)  {
    $options = retrieve_option();
    $error_sp=array();
    if($options['social_publish']['secret_fb_mail']==TRUE){
        $to= $options['social_publish']['secret_fb_mail'];
    }else $error_sp['facebook'][]='101';//set facebook error
    //Retrive post link
    $permalink = get_permalink();
    //Retrieve post title
    $title = get_post_field('post_title', $post_ID);
 
    if(isset ($_POST['publish'])){//the action is publishing new post
    if($options['social_publish']['f_on_publishing']==TRUE){ //if checked on publish
        //retrieve message
        if($options['social_publish']['f_on_publishing_phrase']==TRUE){
            $subject = $options['social_publish']['f_on_publishing_phrase'];
            $subject = str_replace(array('%t%','%l%'), array($title,$permalink), $subject);
        }else $error_sp['facebook'][]='102';//set facebook error
        //$subject = "New Post : $title . Read it on $permalink ";
    }
    
    }else{//the action is updating
         if($options['social_publish']['f_on_update']==TRUE){
             //retrieve message
         if($options['social_publish']['f_on_update_phrase']==TRUE){
            $subject = $options['social_publish']['f_on_update_phrase'];
            $subject = str_replace(array('%t%','%l%'), array($title,$permalink), $subject);
        }else $error_sp['facebook'][]='103';//set facebook error
        //$subject = "New Post : $title . Read it on $permalink ";
        
        }
    }
   $message = " ";//facebook trick
   if(!array_key_exists('facebook', $error_sp))wp_mail($to, $subject, $message);
    return $post_ID;
}
/**
 * Build menu under settings for Plugin
 */
function build_sp_menu() {
  if (function_exists('add_options_page')) {
    add_options_page(__('Social Publish'), __('Social Publish'), 'manage_options', __FILE__, 'sp_page');
  }
}
/**
 * create plugin options page
 */
function sp_page() {

  //check form submit
  if (isset($_POST['social_publish']) && is_array($_POST['social_publish'])) {//if data were submitted
    $options = array('social_publish' => $_POST['social_publish']);//retrieve options for ROLE
    update_option('gluelabs_social_publish', $options['social_publish']);
    echo '<div class="updated"><p>' . __('Options saved') . '</p></div>';
  } else {//else retrieve data
    $options = array('social_publish' => get_option('gluelabs_social_publish'));
  }

  include 'misc/opt_page.php';
}

//hooks
add_action('publish_post', 'send_to_wall');
add_action('admin_menu', 'build_sp_menu');
add_filter ('wp_mail_from', 'get_from_mail' );
add_filter('wp_mail_from_name', 'get_from_name');




?>
