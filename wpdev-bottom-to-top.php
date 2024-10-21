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
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_footer', [$this, 'scroll_script']);
        add_action('wp_head', [$this, 'customize_theme_color']);
        register_activation_hook(__FILE__, [$this, 'plugin_activation']);
        add_action('admin_init', [$this, 'plugin_redirect']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_admin_menu() {
        add_menu_page(
            'WPDev Bottom To Top Option for Admin',
            'Bottom To Top',
            'manage_options',
            'wpdbtt-plugin-option',
            [$this, 'create_admin_page'],
            'dashicons-arrow-up-alt',
            101
        );
    }

    public function enqueue_admin_styles() {
        wp_enqueue_style('wpdbtt-admin-style', plugins_url('css/wpdbtt-admin-style.css', __FILE__), false, '1.0.0');
    }

    public function create_admin_page() {
        ?>
        <div class="wpdbtt_main_area">
            <div class="wpdbtt_body_area wpdbtt_common">
                <h3 id="title"><?php esc_attr_e('🎨 WPDev Bottom to Top Customizer', 'wpdbtt'); ?></h3>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('wpdbtt-settings-group');
                    do_settings_sections('wpdbtt-settings-group');
                    ?>
                    <label for="wpdbtt-primary-color"><?php esc_attr_e('Primary Color', 'wpdbtt'); ?></label>
                    <input type="color" name="wpdbtt-primary-color" value="<?php echo esc_attr(get_option('wpdbtt-primary-color', '#000000')); ?>">

                    <label for="wpdbtt-image-position"><?php esc_attr_e('Button Position', 'wpdbtt'); ?></label>
                    <select name="wpdbtt-image-position" id="wpdbtt-image-position">
                        <option value="right" <?php selected(get_option('wpdbtt-image-position', 'right'), 'right'); ?>><?php esc_attr_e('Right', 'wpdbtt'); ?></option>
                        <option value="left" <?php selected(get_option('wpdbtt-image-position', 'right'), 'left'); ?>><?php esc_attr_e('Left', 'wpdbtt'); ?></option>
                        <option value="center" <?php selected(get_option('wpdbtt-image-position', 'right'), 'center'); ?>><?php esc_attr_e('Center', 'wpdbtt'); ?></option>
                    </select>

                    <label><?php esc_attr_e('Icon Corner', 'wpdbtt'); ?></label>
                    <label class="radios">
                        <input type="radio" name="wpdbtt-round-corner" value="rectangle" <?php checked(get_option('wpdbtt-round-corner', 'rectangle'), 'rectangle'); ?>> <?php esc_attr_e('Rectangle', 'wpdbtt'); ?>
                    </label>
                    <label class="radios">
                        <input type="radio" name="wpdbtt-round-corner" value="r-rectangle" <?php checked(get_option('wpdbtt-round-corner', 'rectangle'), 'r-rectangle'); ?>> <?php esc_attr_e('Rounded Rectangle', 'wpdbtt'); ?>
                    </label>
                    <label class="radios">
                        <input type="radio" name="wpdbtt-round-corner" value="circle" <?php checked(get_option('wpdbtt-round-corner', 'rectangle'), 'circle'); ?>> <?php esc_attr_e('Circle', 'wpdbtt'); ?>
                    </label>

                    <input type="submit" name="submit" value="<?php esc_html_e('Save Changes', 'wpdbtt') ?>">
                </form>
            </div>
            <div class="wpdbtt_sidebar_area wpdbtt_common">
                <h3 id="title"><?php esc_attr_e('✍ About Author', 'wpdbtt'); ?></h3>
                <p id="author-img"><img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'img/buyme-a-coffee.jpg'); ?>" alt="" width="180px"></p>
                <p><?php esc_attr_e("I'm", 'wpdbtt'); ?> <strong><a href="https://www.fiverr.com/shahiduldesigne" target="_blank">Shahidul</a></strong>, <?php esc_attr_e('a Front End Web developer who is passionate about making error-free websites with 100% client satisfaction.', 'wpdbtt'); ?></p>
                <p><a href="https://www.buymeacoffee.com/devshahidulsheikh" target="_blank"><img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'img/buyme.png'); ?>" alt=""></a></p>
                <h5 id="title"><?php esc_attr_e('Watch Help Video', 'wpdbtt'); ?></h5>
                <p><a href="" target="_blank" class="btn"><?php esc_attr_e('Watch On YouTube', 'wpdbtt'); ?></a></p>
            </div>
        </div>
        <?php
    }

    public function enqueue_scripts() {
        wp_enqueue_style('wpdbtt-style', plugins_url('css/wpdbtt-style.css', __FILE__));
        wp_enqueue_script('jquery');
        wp_enqueue_script('wpdbtt-plugin-script', plugins_url('js/wpdbtt-plugin.js', __FILE__), array(), '1.0.0', true);
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
                background-color: <?php echo esc_attr(get_option('wpdbtt-primary-color', '#000000')); ?> !important;
                <?php if (get_option('wpdbtt-image-position', 'right') == 'left') { echo 'left: 5px; right: auto;'; } ?>
                <?php if (get_option('wpdbtt-image-position', 'right') == 'center') { echo 'left: 50%; right: 50%;'; } ?>
                <?php if (get_option('wpdbtt-round-corner', 'rectangle') == 'r-rectangle') { echo 'border-radius: 15% !important;'; } ?>
                <?php if (get_option('wpdbtt-round-corner', 'rectangle') == 'circle') { echo 'border-radius: 50% !important;'; } ?>
            }
        </style>
        <?php
    }

    public function plugin_activation() {
        add_option('wpdbtt-primary-color', '#000000');
        add_option('wpdbtt-image-position', 'right');
        add_option('wpdbtt-round-corner', 'rectangle');
        add_option('wpdbtt_plugin_do_activation_redirect', true);
        $this->register_settings();
    }

    public function register_settings() {
        register_setting('wpdbtt-settings-group', 'wpdbtt-primary-color');
        register_setting('wpdbtt-settings-group', 'wpdbtt-image-position');
        register_setting('wpdbtt-settings-group', 'wpdbtt-round-corner');
    }

    public function plugin_redirect() {
        if (get_option('wpdbtt_plugin_do_activation_redirect', false)) {
            delete_option('wpdbtt_plugin_do_activation_redirect');
            if (!isset($_GET['active-multi'])) {
                wp_safe_redirect(admin_url('admin.php?page=wpdbtt-plugin-option'));
                exit;
            }
        }
    }
}

new WPDev_Bottom_To_Top();
