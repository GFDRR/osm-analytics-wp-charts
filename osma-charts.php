<?php
/**
 * Plugin Name: OSMA charts
 * Description: Allows adding charts to OSMA projects from the admin
 * Author: Vizzuality
 * Author URI: http://vizzuality.com
 */

require_once __DIR__ . '/osma-charts-settings.php';
$OSMA_API_ENDPOINT_ADDRESS = get_option('osma_api_endpoint_address' );
$OSMA_SITE_ADDRESS = get_option('osma_site_address' );
$loader_bg = '#f0f0f0;';

function getVal($params, $value, $default) {
  return isset($params[$value]) ? $params[$value] : $default;
}

function loading($width, $height, $bg = '', $style = '') {
  $img_url = plugins_url('img/loading_2x_360.gif', __FILE__);

  $baseStyle =
    "width: {$width};" .
    "height: {$height};" .
    "background-image: url({$img_url});" .
    "background-repeat: no-repeat;" .
    "background-position: center;" .
    "background-size: 35px;" .
    "background-color: {$bg};" . $style;

  return "<div style=\"{$baseStyle}\"></div>";
}

function compare_map( $atts ) {
  global $OSMA_API_ENDPOINT_ADDRESS;
  global $OSMA_SITE_ADDRESS;
  global $loader_bg;
  $atts_encode = json_encode($atts);
  $chart_id = uniqid('compare-map-');
  $width = getVal($atts, 'width', '100%');
  $height = getVal($atts, 'height', '100%');
  $loader = loading($width, $height, $loader_bg);

  return <<<EOD
  <div id="{$chart_id}" class="compare-map">{$loader}</div>
  <script>
    (function() {
      window.document.body.classList.add('-has-osm-attribution');
      function compareMap(settings) {
        ODRI.compareMap('#{$chart_id}', {
          width: '100%',
          height: '500px',
          settings: settings
        });
      }
      var settings = {$atts_encode};
      settings.iframe_base_url = '{$OSMA_SITE_ADDRESS}';
      if (settings.polygon === undefined) {
        var country = settings.country.toUpperCase() || 'HTI';
        fetch('{$OSMA_API_ENDPOINT_ADDRESS}/meta/country_polyline/' + country)
          .then(function(response) {
            return response.text();
          })
          .then(function(polygon) {
            settings.polygon = polygon;
            compareMap(settings);
          });
      } else {
        compareMap(settings);
      }
    })()
  </script>
EOD;
}

function activity_chart( $atts ) {
  global $OSMA_API_ENDPOINT_ADDRESS;
  global $loader_bg;
  $atts_encode = json_encode($atts);
  $chart_id = uniqid('activity-chart-');
  $width = getVal($atts, 'width', '100%');
  $height = getVal($atts, 'height', '320px');
  $loader = loading($width, $height, $loader_bg, 'margin: 1rem 0;');

  return <<<EOD
  <div id="{$chart_id}">{$loader}</div>
  <script>
  (function() {
    window.document.body.classList.add('-has-osm-attribution');
    var settings = {$atts_encode};
    var country = settings.country.toUpperCase() || 'HTI';
    fetch('{$OSMA_API_ENDPOINT_ADDRESS}/stats/all/country/' + country + '?period=' + settings.start_date + ',' + settings.end_date)
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        ODRI.activity('#{$chart_id}', {
          data: data,
          granularity: settings.default_granularity,
          facet: settings.default_facet,
          range: [settings.start_date, settings.end_date]
        })
      });
  })()
  </script>
EOD;
}


function contributor_chart( $atts ) {
  global $OSMA_API_ENDPOINT_ADDRESS;
  global $loader_bg;
  $atts_encode = json_encode($atts);
  $chart_id = uniqid('contributor-chart-');
  $width = getVal($atts, 'width', '100%');
  $height = getVal($atts, 'height', '450px');
  $loader = loading($width, $height, $loader_bg, 'margin-top: 1rem;margin-bottom: 1rem;');

  return <<<EOD
  <div id="{$chart_id}" style="width: 50%">{$loader}</div>
  <script>
  (function() {
    window.document.body.classList.add('-has-osm-attribution');
    var settings = {$atts_encode};
    var country = settings.country.toUpperCase() || 'HTI';
    fetch('{$OSMA_API_ENDPOINT_ADDRESS}/stats/all/country/' + country + '?period=' + settings.start_date + ',' + settings.end_date)
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        ODRI.contributors('#{$chart_id}', {
          data: data,
          range: [settings.start_date, settings.end_date]
        })
      });
  })()
  </script>
EOD;
}

add_shortcode( 'osma_charts_compare_map', 'compare_map' );
add_shortcode( 'osma_charts_activity', 'activity_chart' );
add_shortcode( 'osma_charts_contributors', 'contributor_chart' );


function osma_charts_script() {
   wp_register_script('osma_charts_bundle', plugins_url('scripts/bundle.js', __FILE__) );
   wp_enqueue_script('osma_charts_bundle');
   wp_register_style('osma_charts_styles', plugins_url('styles/styles.css', __FILE__) );
   wp_enqueue_style('osma_charts_styles');
}

add_action( 'wp_enqueue_scripts', 'osma_charts_script' );
