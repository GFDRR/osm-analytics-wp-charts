<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class OsmaChartsSettingsPage
{
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $osma_api_endpoint_address;
  
  /**
   * Start up
   */
  public function __construct()
  {
	add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
	add_action( 'admin_init', array( $this, 'page_init' ) );
  }

  /**
   * Add options page
   */
  public function add_plugin_page()
  {
	// This page will be under "Settings"
	add_options_page(
	  'Settings Admin',
	  'OSMA Charts',
	  'manage_options',
	  'osma-charts-admin',
	  array( $this, 'create_admin_page' )
	);
  }

  /**
   * Options page callback
   */
  public function create_admin_page()
  {
	// Set class property
	$this->osma_api_endpoint_address = get_option( 'osma_api_endpoint_address', 'https://osm-analytics.vizzuality.com/api/v1' );
	$this->osma_site_address = get_option( 'osma_site_address', 'https://osm-analytics.vizzuality.com:442/' );
	?>
	<div class="wrap">
	  <h1>OSMA Charts Settings</h1>
	  <form method="post" action="options.php">
		<?php
		// This prints out all hidden setting fields
		settings_fields( 'osma_api_group' );
		do_settings_sections( 'osma-charts-admin' );
		submit_button();
		?>
	  </form>
	</div>
	<?php
  }

  /**
   * Register and add settings
   */
  public function page_init()
  {
	register_setting(
	  'osma_api_group', // Option group
	  'osma_api_endpoint_address', // Option name
	  array( $this, 'sanitize' ) // Sanitize
	);

	add_settings_section(
	  'osma_api', // ID
	  'OSMA API', // Title
	  null, // Callback
	  'osma-charts-admin' // Page
	);

	add_settings_field(
	  'osma_api_endpoint_address', // ID
	  'API URL', // Title
	  array( $this, 'osma_api_endpoint_address_callback' ),
	  'osma-charts-admin', // Page
	  'osma_api' // Section
	);
 
 
	register_setting(
	  'osma_api_group', // Option group
	  'osma_site_address', // Option name
	  array( $this, 'sanitize' ) // Sanitize
	);
  
	add_settings_section(
	  'osma_site', // ID
	  'OSMA Site', // Title
	  null, // Callback
	  'osma-charts-admin' // Page
	);
	
	add_settings_field(
	  'osma_site_address', // ID
	  'Site URL', // Title
	  array( $this, 'osma_site_address_callback' ),
	  'osma-charts-admin', // Page
	  'osma_site' // Section
	);
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   *
   * @return array
   */
  public function sanitize( $input )
  {
	$new_input = array();

	if ( isset( $input ) ) {
	  $new_input = sanitize_text_field( $input );
	}

	return $new_input;
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function osma_api_endpoint_address_callback()
  {
	printf(
	  '<input type="text" id="endpoint" name="osma_api_endpoint_address" value="%s" />',
	  isset( $this->osma_api_endpoint_address ) ? esc_attr( $this->osma_api_endpoint_address) : ''
	);
  }
  
  /**
   * Get the settings option array and print one of its values
   */
  public function osma_site_address_callback()
  {
	printf(
	  '<input type="text" id="site_address" name="osma_site_address" value="%s" />',
	  isset( $this->osma_site_address ) ? esc_attr( $this->osma_site_address) : ''
	);
  }

}

if ( is_admin() ) {
  $osma_settings_page = new OsmaChartsSettingsPage();
}
