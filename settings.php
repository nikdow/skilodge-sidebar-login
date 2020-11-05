<?php
class login_settings {

	private $default_style = '
	.login_wid{
		list-style-type:none;
		border: 1px dashed #999999;
		width:98%;
		float:left;
		padding:2%;
	}
	.login_wid li{
		width:45%;
		float:left;
		margin:2px;
	}
	.afo_social_login{
		padding:5px 0px 0px 0px;
		clear:both;
		width:100% !important;
	}';
	
	function __construct() {
		$this->load_settings();
	}
	
        /* not needed, and no need to have it called for every admin init
	function login_widget_afo_save_settings(){   
	} */
	
	function  login_widget_afo_options () {
	global $wpdb;
  
        // marketing first so the "saved" notification can come below
        $this->donate_form_login();
	$this->fb_comment_addon_add();
	$this->fb_login_pro_add();
	$this->help_support();
        
        // moved the option saving here, options can be saved when the form submit is processed here
        if(isset($_POST['option']) and $_POST['option'] == "login_widget_afo_save_settings"){

                if ( ! isset( $_POST['login_widget_afo_field'] )  || ! wp_verify_nonce( $_POST['login_widget_afo_field'], 'login_widget_afo_action' ) ) {
                   wp_die( 'Sorry, your nonce did not verify.' );
                   exit;
                } 

                update_option( 'redirect_page',  sanitize_text_field($_POST['redirect_page']) );
                update_option( 'logout_redirect_page',  sanitize_text_field($_POST['logout_redirect_page']) );
                update_option( 'link_in_username',  sanitize_text_field($_POST['link_in_username']) );
                update_option( 'login_afo_rem',  sanitize_text_field(isset ( $_POST['login_afo_rem'] ) ? $_POST['login_afo_rem'] : "No") );
                update_option( 'login_afo_forgot_pass_link',  sanitize_text_field($_POST['login_afo_forgot_pass_link']) );
                update_option( 'login_afo_register_link',  sanitize_text_field($_POST['login_afo_register_link']) );
                update_option( 'login_afo_username_text',  sanitize_text_field($_POST['login_afo_username_text']) );
                update_option( 'login_afo_password_text',  sanitize_text_field($_POST['login_afo_password_text']) );
                update_option( 'login_afo_placeholder_username_text',  sanitize_text_field($_POST['login_afo_placeholder_username_text']) );
                update_option( 'login_afo_placeholder_password_text',  sanitize_text_field($_POST['login_afo_placeholder_password_text']) );
                update_option( 'login_afo_login_page', sanitize_text_field($_POST['login_afo_login_page']) );
                update_option( 'login_afo_password_hidden', sanitize_text_field($_POST['login_afo_password_hidden']));

                if(isset($_POST['load_default_style']) and $_POST['load_default_style'] == "Yes"){
                        update_option( 'custom_style_afo', sanitize_text_field($this->default_style) );
                } else {
                        update_option( 'custom_style_afo',  sanitize_text_field($_POST['custom_style_afo']) );
                }
                // Add an update notification so the user knows it's been saved
                ?>
                <div class="updated"><p><strong><?php _e('settings saved.' ); ?></strong></p></div>
                <?php
            }
	
	$redirect_page = get_option('redirect_page');
	$logout_redirect_page = get_option('logout_redirect_page');
	$link_in_username = get_option('link_in_username');
	$login_afo_rem = get_option('login_afo_rem');
	$login_afo_forgot_pass_link = get_option('login_afo_forgot_pass_link');
	$login_afo_register_link = get_option('login_afo_register_link');
        $login_afo_username_text = get_option('login_afo_username_text');
        $login_afo_password_text = get_option('login_afo_password_text');
        $login_afo_placeholder_username_text = get_option('login_afo_placeholder_username_text');
        $login_afo_placeholder_password_text = get_option('login_afo_placeholder_password_text');
        $login_afo_login_page = get_option('login_afo_login_page');
        $login_afo_password_hidden = get_option('login_afo_password_hidden');
	
	$custom_style_afo = stripslashes(get_option('custom_style_afo'));
	
	?>
	<form name="f" method="post" action="">
	<?php wp_nonce_field('login_widget_afo_action','login_widget_afo_field'); ?>
	<input type="hidden" name="option" value="login_widget_afo_save_settings" />
	<table width="98%" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px;">
	  <tr>
		<td width="45%"><h1>Login Widget AFO Settings</h1></td>
		<td width="55%">&nbsp;</td>
	  </tr>
	  <tr>
		<td><strong>Login Redirect Page:</strong></td>
		<td><?php
				$args = array(
				'depth'            => 0,
				'selected'         => $redirect_page,
				'echo'             => 1,
				'show_option_none' => '-',
				'id' 			   => 'redirect_page',
				'name'             => 'redirect_page',
                'post_status'       => ['publish','private']
				);
				wp_dropdown_pages( $args ); 
			?></td>
	  </tr>
	  
	   <tr>
		<td><strong>Logout Redirect Page:</strong></td>
		 <td><?php
				$args1 = array(
				'depth'            => 0,
				'selected'         => $logout_redirect_page,
				'echo'             => 1,
				'show_option_none' => '-',
				'id' 			   => 'logout_redirect_page',
				'name'             => 'logout_redirect_page'
				);
				wp_dropdown_pages( $args1 ); 
			?></td>
	  </tr>
	   
	  <tr>
		<td><strong>Link in Username</strong></td>
		<td><?php
				$args2 = array(
				'depth'            => 0,
				'selected'         => $link_in_username,
				'echo'             => 1,
				'show_option_none' => '-',
				'id' 			   => 'link_in_username',
				'name'             => 'link_in_username'
				);
				wp_dropdown_pages( $args2 ); 
			?></td>
	  </tr>
	  <tr>
		<td><strong>Add Remember Me</strong></td>
		<td><input type="checkbox" name="login_afo_rem" value="Yes" <?php echo $login_afo_rem == 'Yes'?'checked="checked"':'';?> /></td>
	  </tr>
	  <tr>
		<td><strong>Forgot Password Link</strong></td>
		<td>
			<?php
				$args3 = array(
				'depth'            => 0,
				'selected'         => $login_afo_forgot_pass_link,
				'echo'             => 1,
				'show_option_none' => '-',
				'id' 			   => 'login_afo_forgot_pass_link',
				'name'             => 'login_afo_forgot_pass_link'
				);
				wp_dropdown_pages( $args3 ); 
			?>
			<i>Leave blank to not include the link</i>
			</td>
	  </tr>
       <tr>
		<td><strong>Register Link</strong></td>
		<td>
			<?php
				$args4 = array(
				'depth'            => 0,
				'selected'         => $login_afo_register_link,
				'echo'             => 1,
				'show_option_none' => '-',
				'id' 			   => 'login_afo_register_link',
				'name'             => 'login_afo_register_link'
				);
				wp_dropdown_pages( $args4 ); 
			?>
			<i>Leave blank to not include the link</i>
			</td>
	  </tr>
        <tr>
            <td><strong>Password Field Hidden</strong></td>
            <td><input type="checkbox" name="login_afo_password_hidden" value="Yes" <?php echo $login_afo_password_hidden == 'Yes'?'checked="checked"':'';?> />
                <i>Using passwords? </i><a href="https://help.cbdweb.net/wordpress/booking-service-login-widget/" target="_blank">help page</a>
            </td>
        </tr>
          <tr>
		<td><strong>Username Text</strong></td>
		<td>
                    <input name="login_afo_username_text" value="<?=$login_afo_username_text?>" />	
                    <i>Replace label of username field in login form</i>
                </td>
	  </tr>
          <tr>
		<td><strong>Password Text</strong></td>
		<td>
                    <input name="login_afo_password_text" value="<?=$login_afo_password_text?>" />	
                    <i>Replace label of password field in login form</i>
                </td>
	  </tr>
           <tr>
		<td><strong>Username Placeholder Text</strong></td>
		<td>
                    <input name="login_afo_placeholder_username_text" value="<?=$login_afo_placeholder_username_text?>" />	
                    <i>placeholder for username field in login form</i>
                </td>
	  </tr>
          <tr>
		<td><strong>Password Placeholder Text</strong></td>
		<td>
                    <input name="login_afo_placeholder_password_text" value="<?=$login_afo_placeholder_password_text?>" />	
                    <i>placeholder for password field in login form</i>
                </td>
	  </tr>
          <tr>
		<td><strong>Login Page</strong></td>
		<td>
                    <input name="login_afo_login_page" value="<?=$login_afo_login_page?>" />	
                    <i>page containing login form, overrides normal WP login page</i>
                </td>
	  </tr>
	   <tr>
			<td width="45%"><h1>Styling</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
	   <tr>
			<td valign="top"><input type="checkbox" name="load_default_style" value="Yes" /><strong> Load Default Styles</strong><br />
			Check this and hit the save button to go back to default styling.
			</td>
			<td><textarea name="custom_style_afo" style="width:80%; height:200px;"><?php echo $custom_style_afo;?></textarea></td>
		  </tr>
		  
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">Use <span style="color:#000066;">[login_widget]</span> shortcode to display login form in post or page.<br />
		 Example: <span style="color:#000066;">[login_widget title="Login Here"]</span></td>
	  </tr>
	  <tr>
		<td colspan="2">Use <span style="color:#000066;">[forgot_password]</span> shortcode to display forgot password form in post or page.<br />
		 Example: <span style="color:#000066;">[forgot_password title="Forgot Password?"]</span></td>
	  </tr>
	</table>
	</form>
	<?php }
	
	
	function fb_comment_plugin_addon_options(){
	global $wpdb;
	$fb_comment_addon = new afo_fb_comment_settings;
	$fb_comments_color_scheme = get_option('fb_comments_color_scheme');
	$fb_comments_width = get_option('fb_comments_width');
	$fb_comments_no = get_option('fb_comments_no');
	$fb_comments_language = get_option('fb_comments_language');
	?>
	<form name="f" method="post" action="">
	<input type="hidden" name="option" value="save_afo_fb_comment_settings" />
	<table width="100%" border="0" style="background-color:#FFFFFF; margin-top:20px; width:98%; padding:5px; border:1px solid #999999; ">
	  <tr>
		<td colspan="2"><h1>Social Comments Settings</h1></td>
	  </tr>
	  <?php do_action('fb_comments_settings_top');?>
	   <tr>
		<td><h3>Facebook Comments</h3></td>
		<td></td>
	  </tr>
	   <tr>
		<td><strong>Language</strong></td>
		<td><select name="fb_comments_language">
			<option value=""> -- </option>
			<?php echo $fb_comment_addon->language_selected($fb_comments_language);?>
		</select>
		</td>
	  </tr>
	 <tr>
		<td><strong>Color Scheme</strong></td>
		<td><select name="fb_comments_color_scheme">
			<?php echo $fb_comment_addon->get_color_scheme_selected($fb_comments_color_scheme);?>
		</select>
		</td>
	  </tr>
	   <tr>
		<td><strong>Width</strong></td>
		<td><input type="text" name="fb_comments_width" value="<?php echo $fb_comments_width;?>"/> In Percent (%)</td>
	  </tr>
	   <tr>
		<td><strong>No of Comments</strong></td>
		<td><input type="text" name="fb_comments_no" value="<?php echo $fb_comments_no;?>"/> Default is 10</td>
	  </tr>
	  <?php do_action('fb_comments_settings_bottom');?>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">Use <span style="color:#000066;">[social_comments]</span> shortcode to display Facebook / Disqus Comments in post or page.<br />
		 Example: <span style="color:#000066;">[social_comments title="Comments"]</span>
		 <br /> <br />
		 Or else<br /> <br />
		 You can use this function <span style="color:#000066;">social_comments()</span> in your template to display the Facebook Comments. <br />
		 Example: <span style="color:#000066;">&lt;?php social_comments("Comments");?&gt;</span>
		 </td>
	  </tr>
	</table>
	</form>
	<?php 
	}
	
	function login_widget_afo_text_domain(){
		load_plugin_textdomain('lwa', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
	}
	
	function plug_install_afo_fb_login(){
		update_option( 'custom_style_afo', $this->default_style );
                // provide defaults for these options
                add_option('login_afo_username_text', 'Username' ); 
                add_option('login_afo_password_text', 'Password' );
                add_option('login_afo_placeholder_username_text', 'Username' ); 
                add_option('login_afo_placeholder_password_text', 'Password' );
	}
	
	function login_widget_afo_menu () {
		add_options_page( 'Login Widget', 'Login Widget Settings', 'activate_plugins', 'login_widget_afo', array( $this,'login_widget_afo_options' ));
	}
	
	function load_settings(){
		add_action( 'admin_menu' , array( $this, 'login_widget_afo_menu' ) );
	//	add_action( 'admin_init', array( $this, 'login_widget_afo_save_settings' ) );
		add_action( 'plugins_loaded',  array( $this, 'login_widget_afo_text_domain' ) );
		register_activation_hook(__FILE__, array( $this, 'plug_install_afo_fb_login' ) );
//                add_filter( 'login_url', array( $this, 'login_page' ), 10, 2 );
	}
/*        function login_page( $login_url, $redirect ) {
            return get_option('login_afo_login_page') . '?redirect_to=' . $redirect;
        } */

	function help_support(){ ?>

	<?php
	}
	
	function fb_comment_addon_add(){ 
		if ( !is_plugin_active( 'fb-comments-afo-addon/fb_comment.php' ) ) {
	?>
	<?php
		}
	}
	
	function fb_login_pro_add(){ ?>

	<?php }
	
	function donate_form_login(){
	if ( !is_plugin_active( 'fb-comments-afo-addon/fb_comment.php' ) ) {
	?>

	<?php }
	}
}
new login_settings;
