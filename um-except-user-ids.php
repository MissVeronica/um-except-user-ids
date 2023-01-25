<?php
/**
 * Plugin Name:     Ultimate Member - Except Users Access Shortcode
 * Description:     Extension to Ultimate Member Shortcode to exclude logged in users from accessing Pages/Posts.
 * Version:         2.0.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica?tab=repositories
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.5.0
 */


if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'UM' ) ) return;

class UM_Except_Users_Access {

    public function __construct() {

        if ( is_admin()) {

            add_filter( 'um_settings_structure',   array( $this, 'um_settings_structure_except_user_ids' ), 10, 1 );

        } else {

            add_shortcode( 'um_except_user_ids', array( $this, 'um_except_user_ids' ));
        }
    }

    public function um_except_user_ids( $args = array(), $content = "" ) {

        global $current_user;

        ob_start();

        $args = shortcode_atts(
            array(
                   'lock_text'  => __( 'This content has been restricted to logged in users only. Please <a href="{login_referrer}">login</a> to view this content.', 'ultimate-member' ),
                   'show_lock'  => 'yes',
                   'except'     => ''
            ), $args, 'um_except_user_ids'
        );

        if ( ! is_user_logged_in() ) {

            if ( 'no' === $args['show_lock'] ) {
                echo '';

            } else {

                $args['lock_text'] = UM()->shortcodes()->convert_locker_tags( $args['lock_text'] );
                UM()->get_template( 'login-to-view.php', '', $args, true );
            }

        } else {

            $except_ids = array();
            $meta_exception = UM()->options()->get( 'um_except_user_meta_key_value' );

            if ( ! empty( $meta_exception )) {

                $meta_exception = explode( ':', strtolower( $meta_exception ));
                $meta_value_except = maybe_unserialize( um_user( $meta_exception[0] ));

                if ( is_array( $meta_value_except )) {

                    if ( in_array( $meta_exception[1], array_map( 'strtolower', $meta_value_except ))) {
                        $except_ids[] = $current_user->ID;
                    }

                } else {
                
                    if ( ! empty( $meta_value_except ) && strtolower( $meta_value_except ) == $meta_exception[1] ) {
                        $except_ids[] = $current_user->ID;
                    }
                }

            } else {

                if ( empty( $args['except'] ) ) {

                    $except_ids = UM()->options()->get( 'um_except_user_ids' );
                    if ( ! empty( $except_ids )) {
                        $except_ids = array_map( 'intval', explode( ',', $except_ids ));
                    }

                } else {

                    $except_ids = array_map( 'intval', explode( ',', $args['except'] ));
                }
            }

            if ( is_array( $except_ids ) && in_array( $current_user->ID, $except_ids )) {

                if ( 'no' === $args['show_lock'] ) {

                    echo '';

                } else {

                    $args['lock_text'] = UM()->shortcodes()->convert_locker_tags( UM()->options()->get( 'um_except_user_ids_lock_text' ) );
                    UM()->get_template( 'login-to-view.php', '', $args, true );
                }

            } else {

                $this->display_shortcode( $content );
            }
        }

        $output = ob_get_clean();

        return htmlspecialchars_decode( $output, ENT_NOQUOTES );
    }

    public function display_shortcode( $content ) {

        if ( version_compare( get_bloginfo('version'),'5.4', '<' ) ) {

            echo do_shortcode( UM()->shortcodes()->convert_locker_tags( wpautop( $content ) ) );

        } else {

            echo apply_shortcodes( UM()->shortcodes()->convert_locker_tags( wpautop( $content ) ) );
        }
    }

    public function um_settings_structure_except_user_ids( $settings_structure ) {

        $settings_structure['access']['sections']['other']['fields'][] = array(
                        'id'      => 'um_except_user_ids',
                        'type'    => 'text',
                        'label'   => __( 'Except User IDs - User ID list', 'ultimate-member' ),
                        'tooltip' => __( 'User ID list comma separated.', 'ultimate-member' )
                    );

        $settings_structure['access']['sections']['other']['fields'][] = array(
                        'id'      => 'um_except_user_meta_key_value',
                        'type'    => 'text',
                        'label'   => __( 'Except User IDs - meta_key:meta_value', 'ultimate-member' ),
                        'tooltip' => __( 'meta_key:meta_value for exclusion.', 'ultimate-member' )
                    );

        $settings_structure['access']['sections']['other']['fields'][] = array(
                        'id'      => 'um_except_user_ids_lock_text',
                        'type'    => 'text',
                        'label'   => __( 'Except User IDs - Lock out text', 'ultimate-member' ),
                        'tooltip' => __( 'Text to display for the users in the except list.', 'ultimate-member' )
                    );

        return $settings_structure;
    }
}

new UM_Except_Users_Access();
