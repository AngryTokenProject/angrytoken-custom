<?php
/**
 * Plugin Name: AngryToken
 * Plugin URI: https://dev.angrytoken.com/plugins/angrytoken-custom
 * Description: AngryToken custom website plugin
 * Version: 0.0.1
 * Author: iwkse
 * Author URI: https://github.com/angrytokenproject/angrytoken-custom
 * Text Domain: angrytoken
 * License: GPL-3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('ANG_PATH', plugin_dir_path(__FILE__));
define('ANG_PLUGIN_URL', plugins_url() . '/angrytoken-custom');

class AngryTokenSettingsPage 
{
    private $options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'angrytoken_page_init' ) );
    }

    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'AngryToken',
            'manage_options',
            'angrytoken-setting-admin',
            array( $this, 'create_admin_page' )
        );
    }

    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'angrytoken_option_name' );
        ?>
        <div class="wrap">
            <h1>AngryToken</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'angrytoken_option_group' );
                do_settings_sections( 'angrytoken-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    public function angrytoken_page_init() 
    {
        register_setting(
            'angrytoken_option_group', // Option group
            'angrytoken_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        add_settings_section(
            'message_section_id', // ID
            'AngryToken Message', // Title
            null,
            'angrytoken-setting-admin' // Page
        );
        add_settings_field(
            'ang_message', // ID
            'Message', // Title
            array( $this, 'ang_message_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'message_section_id' // Section
        );
        add_settings_section(
            'snipslink_section_id', // ID
            'Snipad/Slinkad', // Title
            null,
            'angrytoken-setting-admin' // Page
        );
        add_settings_field(
            'ang_snipad', // ID
            'Snipad', // Title
            array( $this, 'ang_snipad_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'snipslink_section_id' // Section
        );
        add_settings_field(
            'ang_slinkad', // ID
            'Slinkad', // Title
            array( $this, 'ang_slinkad_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'snipslink_section_id' // Section
        );
        add_settings_section(
            'empower_section_id', // ID
            'Empowering & Rewarding', // Title
            array( $this, 'print_section_info' ), // Callback
            'angrytoken-setting-admin' // Page
        );
        add_settings_field(
            'ang_ads', // ID
            'Ads', // Title
            array( $this, 'ang_ads_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'empower_section_id' // Section
        );
        add_settings_field(
            'ang_creators', // ID
            'Creators', // Title
            array( $this, 'ang_creators_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'empower_section_id' // Section
        );
        add_settings_field(
            'ang_visitors', // ID
            'Visitors', // Title
            array( $this, 'ang_visitors_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'empower_section_id' // Section
        );
        add_settings_field(
            'ang_nofake', // ID
            'No more fake news', // Title
            array( $this, 'ang_nofake_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'empower_section_id' // Section
        );
        add_settings_field(
            'ang_fasteasy', // ID
            'Fast & Easy', // Title
            array( $this, 'ang_fasteasy_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'empower_section_id' // Section
        );
        add_settings_field(
            'ang_boost', // ID
            'Boost your revenue', // Title
            array( $this, 'ang_boost_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'empower_section_id' // Section
        );
        add_settings_field(
            'ang_localnews', // ID
            'Give local news a global audience', // Title
            array( $this, 'ang_localnews_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'empower_section_id' // Section
        );

        // Social Media
        add_settings_section(
            'social_section_id', // ID
            'Social media icon links', // Title
            null,
            'angrytoken-setting-admin' // Page
        );
        add_settings_field(
            'ang_instagram', // ID
            'Instagram', // Title
            array( $this, 'ang_instagram_cb' ), // Callback
            'angrytoken-setting-admin', // Page
            'social_section_id' // Section
        );
        add_settings_field(
            'ang_telegram',
            'Telegram',
            array( $this, 'ang_telegram_cb' ),
            'angrytoken-setting-admin',
            'social_section_id'
        );
        add_settings_field(
            'ang_twitter',
            'Twitter',
            array( $this, 'ang_twitter_cb' ),
            'angrytoken-setting-admin',
            'social_section_id'
        );
        add_settings_field(
            'ang_facebook',
            'Facebook',
            array( $this, 'ang_facebook_cb' ),
            'angrytoken-setting-admin',
            'social_section_id'
        );
        add_settings_field(
            'ang_bitcointalk',
            'Bitcointalk',
            array( $this, 'ang_bitcointalk_cb' ),
            'angrytoken-setting-admin',
            'social_section_id'
        );
        add_settings_field(
            'ang_medium',
            'Medium',
            array( $this, 'ang_medium_cb' ),
            'angrytoken-setting-admin',
            'social_section_id'
        );
    }
    // Message from AngryToken
    public function ang_message_cb()
    {
        printf(
            '<textarea rows="5" cols="70" id="ang_message" name="angrytoken_option_name[ang_message]">%s</textarea>',
            isset( $this->options['ang_message'] ) ? esc_attr( $this->options['ang_message']) : ''
        );
    }
    // Snipad/Slinkad
    public function ang_snipad_cb()
    {
        printf(
            '<textarea rows="5" cols="70" id="ang_snipad" name="angrytoken_option_name[ang_snipad]">%s</textarea>',
            isset( $this->options['ang_snipad'] ) ? esc_attr( $this->options['ang_snipad']) : ''
        );
    }
    public function ang_slinkad_cb()
    {
        printf(
            '<textarea rows="5" cols="70"  id="ang_slinkad" name="angrytoken_option_name[ang_slinkad]">%s</textarea>',
            isset( $this->options['ang_slinkad'] ) ? esc_attr( $this->options['ang_slinkad']) : ''
        );
    }
    // Empowering & Rewarding
    public function ang_ads_cb()
    {
        printf(
            '<textarea rows="3" cols="70"  id="ang_ads" name="angrytoken_option_name[ang_ads]">%s</textarea>',
            isset( $this->options['ang_ads'] ) ? esc_attr( $this->options['ang_ads']) : ''
        );
    }
    public function ang_creators_cb()
    {
        printf(
            '<textarea rows="3" cols="70"  id="ang_creators" name="angrytoken_option_name[ang_creators]">%s</textarea>',
            isset( $this->options['ang_creators'] ) ? esc_attr( $this->options['ang_creators']) : ''
        );
    }
    public function ang_visitors_cb()
    {
        printf(
            '<textarea rows="3" cols="70"  id="ang_visitors" name="angrytoken_option_name[ang_visitors]">%s</textarea>',
            isset( $this->options['ang_visitors'] ) ? esc_attr( $this->options['ang_visitors']) : ''
        );
    }
    public function ang_nofake_cb()
    {
        printf(
            '<textarea rows="3" cols="70"  id="ang_nofake" name="angrytoken_option_name[ang_nofake]">%s</textarea>',
            isset( $this->options['ang_nofake'] ) ? esc_attr( $this->options['ang_nofake']) : ''
        );
    }
    public function ang_fasteasy_cb()
    {
        printf(
            '<textarea rows="3" cols="70"  id="ang_fasteasy" name="angrytoken_option_name[ang_fasteasy]">%s</textarea>',
            isset( $this->options['ang_fasteasy'] ) ? esc_attr( $this->options['ang_fasteasy']) : ''
        );
    }
    public function ang_boost_cb()
    {
        printf(
            '<textarea rows="3" cols="70"  id="ang_boost" name="angrytoken_option_name[ang_boost]">%s</textarea>',
            isset( $this->options['ang_boost'] ) ? esc_attr( $this->options['ang_boost']) : ''
        );
    }
    public function ang_localnews_cb()
    {
        printf(
            '<textarea rows="3" cols="70"  id="ang_localnews" name="angrytoken_option_name[ang_localnews]">%s</textarea>',
            isset( $this->options['ang_localnews'] ) ? esc_attr( $this->options['ang_localnews']) : ''
        );
    }
    // Social Media
    public function ang_instagram_cb()
    {
        printf(
            '<input size="35" type="text" id="ang_instagram" name="angrytoken_option_name[ang_instagram]" value="%s" />',
            isset( $this->options['ang_instagram'] ) ? esc_attr( $this->options['ang_instagram']) : ''
        );
    }

    public function ang_telegram_cb()
    {
        printf(
            '<input size="35" type="text" id="ang_telegram" name="angrytoken_option_name[ang_telegram]" value="%s" />',
            isset( $this->options['ang_telegram'] ) ? esc_attr( $this->options['ang_telegram']) : ''
        );
    }

    public function ang_twitter_cb()
    {
        printf(
            '<input size="35" type="text" id="ang_twitter" name="angrytoken_option_name[ang_twitter]" value="%s" />',
            isset( $this->options['ang_twitter'] ) ? esc_attr( $this->options['ang_twitter']) : ''
        );
    }
    
    public function ang_facebook_cb()
    {
        printf(
            '<input size="35" type="text" id="ang_facebook" name="angrytoken_option_name[ang_facebook]" value="%s" />',
            isset( $this->options['ang_facebook'] ) ? esc_attr( $this->options['ang_facebook']) : ''
        );
    }

    public function ang_bitcointalk_cb()
    {
        printf(
            '<input size="35" type="text" id="ang_bitcointalk" name="angrytoken_option_name[ang_bitcointalk]" value="%s" />',
            isset( $this->options['ang_bitcointalk'] ) ? esc_attr( $this->options['ang_bitcointalk']) : ''
        );
    }
    
    public function ang_medium_cb()
    {
        printf(
            '<input size="35" type="text" id="ang_medium" name="angrytoken_option_name[ang_medium]" value="%s" />',
            isset( $this->options['ang_medium'] ) ? esc_attr( $this->options['ang_medium']) : ''
        );
    }
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['ang_instagram'] ) )
            $new_input['ang_instagram'] = sanitize_text_field( $input['ang_instagram'] );
        if( isset( $input['ang_telegram'] ) )
            $new_input['ang_telegram'] = sanitize_text_field( $input['ang_telegram'] );
        if( isset( $input['ang_twitter'] ) )
            $new_input['ang_twitter'] = sanitize_text_field( $input['ang_twitter'] );
        if( isset( $input['ang_facebook'] ) )
            $new_input['ang_facebook'] = sanitize_text_field( $input['ang_facebook'] );
        if( isset( $input['ang_bitcointalk'] ) )
            $new_input['ang_bitcointalk'] = sanitize_text_field( $input['ang_bitcointalk'] );
        if( isset( $input['ang_medium'] ) )
            $new_input['ang_medium'] = sanitize_text_field( $input['ang_medium'] );
        return $input;
    }
}

if( is_admin() ) {
    $angrytoken_settings_page = new AngryTokenSettingsPage();
}
