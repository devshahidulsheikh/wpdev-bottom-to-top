<?php
/**
 * Plugin Name:       WPDev Bottom To Top
 * Plugin URI:        https://wordpress.org/plugins/wpdev-bottom-to-top/
 * Description:       WPDev Bottom to Top plugin will help you to enable Back to Top button to your WordPress website.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shahidul
 * Author URI:        https://fiverr.com/shahiduldesigne/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpdbtt
 */

/*
* Plugin Option Page Function
*/
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

add_action( "admin_menu", "wpdbtt_add_theme_page" );
function wpdbtt_add_theme_page() {
  add_menu_page( "WPDev Bottom To Top Option for Admin", "Bottom To Top", "manage_options", "wpdbtt-plugin-option", "wpdbtt_create_page", "dashicons-arrow-up-alt", 101 );
}

/*
* Plugin Option Page Style
*/
add_action("admin_enqueue_scripts", "wpdbtt_add_theme_css");
function wpdbtt_add_theme_css() {
wp_enqueue_style( "wpdbtt-admin-style", plugins_url( "css/wpdbtt-admin-style.css", __FILE__ ), false, "1.0.0");

}


/**
 * Plugin Callback
 */
function wpdbtt_create_page() {
  ?>
    <div class="wpdbtt_main_area">
      <div class="wpdbtt_body_area wpdbtt_common">
        <h3 id="title"><?php esc_attr_e( "🎨 WPDev Bottom to Top Customizer" ); ?></h3>
        <form action="options.php" method="post">
          <?php wp_nonce_field("update-options"); ?>

          <!-- Primary Color -->
          <label for="wpdbtt-primary-color" name="wpdbtt-primary-color"><?php esc_attr_e( "Primary Color" ); ?></label>
          <small>Add your Primary Color</small>
          <input type="color" name="wpdbtt-primary-color" value="<?php echo get_option("wpdbtt-primary-color"); ?>">

          <!-- Button Position -->
          <label for="wpdbtt-image-position"><?php esc_attr_e(__("Button Position")); ?></label>
          <small>Where do you want to show your button position?</small>
          <select name="wpdbtt-image-position" id="wpdbtt-image-position">
            <option value="right" <?php if( get_option("wpdbtt-image-position") == "right"){ echo "selected='selected'"; } ?>>Right</option>
            <option value="left" <?php if( get_option("wpdbtt-image-position") == "left"){ echo "selected='selected'"; } ?>>Left</option>
            <option value="center" <?php if( get_option("wpdbtt-image-position") == "center"){ echo "selected='selected'"; } ?>>Center</option>
          </select>

          <!-- Icon Corner -->
          <label for=""><?php esc_attr_e(__("Icon Corner")); ?></label>
          <small>Do you need a customize icon corner button?</small>
          <label for="wpdbtt-round-corner-r" class="radios">
            <input type="radio" name="wpdbtt-round-corner" id="wpdbtt-round-corner-r" value="rectangle" <?php if(get_option("wpdbtt-round-corner") == "rectangle") {echo "checked='checked'";} ?> checked><span>Rectangle</span>
          </label>
          <label for="wpdbtt-round-corner-r-r" class="radios">
            <input type="radio" name="wpdbtt-round-corner" id="wpdbtt-round-corner-r-r" value="r-rectangle" <?php if(get_option("wpdbtt-round-corner") == "r-rectangle") {echo "checked='checked'";} ?>><span>Rounded Rectangle</span>
          </label>
          <label for="wpdbtt-round-corner-c" class="radios">
            <input type="radio" name="wpdbtt-round-corner" id="wpdbtt-round-corner-c" value="circle" <?php if(get_option("wpdbtt-round-corner") == "circle") {echo "checked='checked'";} ?>><span>Circle</span>
          </label>



          <!-- Round Corner -->


          <input type="hidden" name="action" value="update">
          <input type="hidden" name="page_options" value="wpdbtt-primary-color, wpdbtt-image-position, wpdbtt-round-corner">
          <input type="submit" name="submit" value="<?php esc_html_e("Save Changes", "wpdbtt") ?>">
        </form>
      </div>
      <div class="wpdbtt_sidebar_area wpdbtt_common">
        <h3 id="title"><?php esc_attr_e( "✍ About Author" ); ?></h3>
        <p id="author-img"><img src=<?php echo plugin_dir_url(__FILE__) . "img/buyme-a-coffee.jpg" ?> alt="" width="180px"></p>
        <p>I&apos;m <strong><a href="https://www.fiverr.com/shahiduldesigne" target="_blank">Shahidul</a></strong> a Front End Web developer who is passionate about making error-free websites with 100% client satisfaction. I have a passion for learning and sharing my knowledge with others as publicly as possible. I love to solve real-world problems.</p>
        <p><a href="https://www.buymeacoffee.com/devshahidulsheikh" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__) . "img/buyme.png" ?>" alt=""></a></p>
        <h5 id="title"><?php esc_attr_e( "Watch Help Video" ); ?></h5>
        <p><a href="" target="_blank" class="btn">Watch On YouTube</a></p>
      </div>
    </div>
  <?php
}





// Including CSS
add_action( "wp_enqueue_scripts", "wpdbtt_enqueue_scripts" );
function wpdbtt_enqueue_style() {
  wp_enqueue_style("wpdbtt-style", plugins_url("css/wpdbtt-style.css", __FILE__));
}
add_action( "wp_enqueue_scripts", "wpdbtt_enqueue_style" );

// Including JavaScript
function wpdbtt_enqueue_scripts() {
  wp_enqueue_script("jquery");
  wp_enqueue_script("wpdbtt-plugin-script", plugins_url("js/wpdbtt-plugin.js", __FILE__), array(), "1.0.0", "true");
}

// jQuery Plugin Setting Activation
add_action( "wp_footer", "wpdbtt_scroll_script" );
function wpdbtt_scroll_script() {
  ?>
    <script>
      jQuery(document).ready(function () {
        jQuery.scrollUp();
      });
    </script>
  <?php
}



// Theme CSS Customization
add_action("wp_head", "wpdbtt_theme_color_cus");
function wpdbtt_theme_color_cus() {
?>
<style>
  #scrollUp {
  background-color: <?php echo get_option("wpdbtt-primary-color"); ?> !important;

  <?php if(get_option("wpdbtt-image-position") == "left") { echo "left: 5px; right: auto;"; } ?>
  <?php if(get_option("wpdbtt-image-position") == "center") { echo "left: 50%; right: 50%;"; } ?>

  <?php if(get_option("wpdbtt-round-corner") == "r-rectangle") { echo "border-radius: 15% !important;"; } ?>
  <?php if(get_option("wpdbtt-round-corner") == "circle") { echo "border-radius: 50% !important;";} ?>
}
</style>
<?php
}





/*
* Plugin Redirect Feature
*/
register_activation_hook( __FILE__, "wpdbtt_plugin_activation" );
function wpdbtt_plugin_activation() {
  add_option("wpdbtt_plugin_do_activation_redirect", true);
}

add_action( "admin_init", "wpdbtt_plugin_redirect");
function wpdbtt_plugin_redirect() {
  if(get_option("wpdbtt_plugin_do_activation_redirect", false)){
    delete_option("wpdbtt_plugin_do_activation_redirect");
    if(!isset($_GET["active-multi"])){
      wp_safe_redirect(admin_url( "admin.php?page=wpdbtt-plugin-option" ));
      exit;
    }
  }
}
