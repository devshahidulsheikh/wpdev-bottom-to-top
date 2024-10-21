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

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WPDev_Bottom_To_Top {
    public function __construct() {
        add_action("admin_menu", [$this, "add_admin_menu"]);
        add_action("admin_enqueue_scripts", [$this, "enqueue_admin_styles"]);
        add_action("wp_enqueue_scripts", [$this, "enqueue_scripts"]);
        add_action("wp_footer", [$this, "scroll_script"]);
        add_action("wp_head", [$this, "customize_theme_color"]);
        register_activation_hook(__FILE__, [$this, "plugin_activation"]);
        add_action("admin_init", [$this, "plugin_redirect"]);
    }

    public function add_admin_menu() {
        add_menu_page(
            "WPDev Bottom To Top Option for Admin",
            "Bottom To Top",
            "manage_options",
            "wpdbtt-plugin-option",
            [$this, "create_admin_page"],
            "dashicons-arrow-up-alt",
            101
        );
    }

    public function enqueue_admin_styles() {
        wp_enqueue_style("wpdbtt-admin-style", plugins_url("css/wpdbtt-admin-style.css", __FILE__), false, "1.0.0");
    }

    public function create_admin_page() {
        ?>
        <div class="wpdbtt_main_area">
            <div class="wpdbtt_body_area wpdbtt_common">
                <h3 id="title"><?php esc_attr_e("🎨 WPDev Bottom to Top Customizer"); ?></h3>
                <form action="options.php" method="post">
                    <?php wp_nonce_field("update-options"); ?>

                    <label for="wpdbtt-primary-color"><?php esc_attr_e("Primary Color"); ?></label>
                    <small>Add your Primary Color</small>
                    <input type="color" name="wpdbtt-primary-color" value="<?php echo get_option("wpdbtt-primary-color"); ?>">

                    <label for="wpdbtt-image-position"><?php esc_attr_e(__("Button Position")); ?></label>
                    <small>Where do you want to show your button position?</small>
                    <select name="wpdbtt-image-position" id="wpdbtt-image-position">
                        <option value="right" <?php selected(get_option("wpdbtt-image-position"), "right"); ?>>Right</option>
                        <option value="left" <?php selected(get_option("wpdbtt-image-position"), "left"); ?>>Left</option>
                        <option value="center" <?php selected(get_option("wpdbtt-image-position"), "center"); ?>>Center</option>
                    </select>

                    <label><?php esc_attr_e(__("Icon Corner")); ?></label>
                    <small>Do you need a customize icon corner button?</small>
                    <label class="radios">
                        <input type="radio" name="wpdbtt-round-corner" value="rectangle" <?php checked(get_option("wpdbtt-round-corner"), "rectangle"); ?>> Rectangle
                    </label>
                    <label class="radios">
                        <input type="radio" name="wpdbtt-round-corner" value="r-rectangle" <?php checked(get_option("wpdbtt-round-corner"), "r-rectangle"); ?>> Rounded Rectangle
                    </label>
                    <label class="radios">
                        <input type="radio" name="wpdbtt-round-corner" value="circle" <?php checked(get_option("wpdbtt-round-corner"), "circle"); ?>> Circle
                    </label>

                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="page_options" value="wpdbtt-primary-color, wpdbtt-image-position, wpdbtt-round-corner">
                    <input type="submit" name="submit" value="<?php esc_html_e("Save Changes", "wpdbtt") ?>">
                </form>
            </div>
            <div class="wpdbtt_sidebar_area wpdbtt_common">
                <h3 id="title"><?php esc_attr_e("✍ About Author"); ?></h3>
                <p id="author-img"><img src="<?php echo plugin_dir_url(__FILE__) . "img/buyme-a-coffee.jpg"; ?>" alt="" width="180px"></p>
                <p>I&apos;m <strong><a href="https://www.fiverr.com/shahiduldesigne" target="_blank">Shahidul</a></strong>, a Front End Web developer who is passionate about making error-free websites with 100% client satisfaction.</p>
                <p><a href="https://www.buymeacoffee.com/devshahidulsheikh" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__) . "img/buyme.png"; ?>" alt=""></a></p>
                <h5 id="title"><?php esc_attr_e("Watch Help Video"); ?></h5>
                <p><a href="" target="_blank" class="btn">Watch On YouTube</a></p>
            </div>
        </div>
        <?php
    }

    public function enqueue_scripts() {
        wp_enqueue_style("wpdbtt-style", plugins_url("css/wpdbtt-style.css", __FILE__));
        wp_enqueue_script("jquery");
        wp_enqueue_script("wpdbtt-plugin-script", plugins_url("js/wpdbtt-plugin.js", __FILE__), array(), "1.0.0", true);
    }

    public function scroll_script() {
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery.scrollUp();
            });
        </script>
        <?php
    }

    public function customize_theme_color() {
        ?>
        <style>
            #scrollUp {
                background-color: <?php echo get_option("wpdbtt-primary-color"); ?> !important;
                <?php if(get_option("wpdbtt-image-position") == "left") { echo "left: 5px; right: auto;"; } ?>
                <?php if(get_option("wpdbtt-image-position") == "center") { echo "left: 50%; right: 50%;"; } ?>
                <?php if(get_option("wpdbtt-round-corner") == "r-rectangle") { echo "border-radius: 15% !important;"; } ?>
                <?php if(get_option("wpdbtt-round-corner") == "circle") { echo "border-radius: 50% !important;"; } ?>
            }
        </style>
        <?php
    }

    public function plugin_activation() {
        add_option("wpdbtt_plugin_do_activation_redirect", true);
    }

    public function plugin_redirect() {
        if(get_option("wpdbtt_plugin_do_activation_redirect", false)){
            delete_option("wpdbtt_plugin_do_activation_redirect");
            if(!isset($_GET["active-multi"])){
                wp_safe_redirect(admin_url("admin.php?page=wpdbtt-plugin-option"));
                exit;
            }
        }
    }
}

new WPDev_Bottom_To_Top();
