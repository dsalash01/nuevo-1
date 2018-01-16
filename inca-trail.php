<?php
/**
 * Plugin Name: Inka trail calendar
 * Plugin URI: http://llika.com
 * Description: Show inca trail availability calendar
 * Version: 1.0
 * Author: Llika Inversiones
 * Author URI: http://llika.com
 * Text Domain: Optional. Inca Trail Availability Calendar
 */
function style_inca_trail()
{
    wp_register_style( 'custom-style', plugins_url( '/it-style.css', __FILE__ ), array(), '1', 'all' );

    wp_enqueue_style( 'custom-style' );
}
add_action( 'wp_enqueue_scripts', 'style_inca_trail' );

/**
* [IncaTrail it_month="12" it_year="2017" it_place="1"]
* 1: Camino Inca 2 Días
* 2: Camino Inca 4 Días
*/
function inca_trail_month( $atts ) {

    $fileName =  "it-form-view.php";
    ob_start();
    require($fileName);
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}
add_shortcode( 'IncaTrail', 'inca_trail_month' );

function inca_trail_menu()
{
    add_menu_page(
        'Configuration Inca trail calendar',
        'Inca trail calendar',
        'administrator',
        'inca_trail_settings',
        'inca_trail_page_settings',
        'dashicons-admin-links '
    );
}
add_action('admin_menu','inca_trail_menu');
/**
* Función que pinta la página de configuración del plugin
*/
function inca_trail_page_settings(){
?>
    <div class="wrap">
        <h2>Configuración inca trail calendar</h2>
        <form method="POST" action="options.php">
            <?php
                settings_fields('inca_trail_settings_group');
                do_settings_sections( 'inca_trail_settings_group' );
            ?>
            <table>
                <tr>
                    <td class="plugin-title column-primary"><b><label>Link contact us form:</label></b></td>
                    <td><input  type="text" size="60"
                    name="inca_trail_contact"
                    id="inca_trail_contact"
                    value="<?php echo get_option('inca_trail_contact'); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="plugin-title column-primary"><b><label>Link to book now from:</label></b></td>
                    <td><input  type="text" size="60"
                    name="inca_trail_book"
                    id="inca_trail_book"
                    value="<?php echo get_option('inca_trail_book'); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="plugin-title column-primary"><b><label>Link to alternative form:</label></b></td>
                    <td>
                        <input  type="text" size="60"
                    name="inca_trail_alternative"
                    id="inca_trail_alternative"
                    value="<?php echo get_option('inca_trail_alternative'); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="plugin-title column-primary"><label>Message on february:</label></td>
                    <td>
            <textarea cols="60" rows="6"
                    name="inca_trail_february"
                    id="inca_trail_february"/><?php echo get_option('inca_trail_february'); ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <p><strong>Example of Use</strong>: Choose one option and include in the content</p>
        <ul>
            <li><b>Full calendar: </b><code>[IncaTrail it_month="00" it_year="2017" it_place="1"]</code></li>
            <li><b>Calendar by month: </b><code>[IncaTrail month="01" year="2017" it_place="1"]</code></li>
        </ul>
        <ul>
            <li>1: Camino Inca de 2 Días</li>
            <li>2: Camino Inca de 4 Días</li>
        </ul>
    </div>
<?php }
/*
* Función que registra las opciones del formulario en una lista blanca para que puedan ser guardadas
*/
function inca_trail_settings(){
    register_setting('inca_trail_settings_group',
                     'inca_trail_contact' );
    register_setting('inca_trail_settings_group',
                     'inca_trail_book' );
    register_setting('inca_trail_settings_group',
                     'inca_trail_alternative' );
    register_setting('inca_trail_settings_group',
                     'inca_trail_february' );
}
add_action('admin_init','inca_trail_settings');

?>