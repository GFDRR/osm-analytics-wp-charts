# Open Street Maps Analytics Charts

This Wordpress plugin provides integration with OSMA to display charts and maps inside pages.

## Installation

Install like any other Wordpress plugin

## Build from source

On the <a href="https://github.com/Vizzuality/wp-osma-charts">source repo</a>, build and push:
```
npm run build
...
git push origin master
```

On this repo, update and copy the dependencies:
```
npm update && npm run update-osma-charts
```

## Configuration

The plugin supports 2 configuration values, both of which are required:
- API URL: Address the API endpoint, typically ending in `/api/v1`
- Site URL: Address of the OSM analytics site, used in map embeds.


## Usage

The plugin currently provides 3 shortcodes, each rendering a different visualization:

#### Compare map:
![Compare map](https://github.com/GFDRR/opendri-website/blob/master/wp-content/plugins/osma-charts/samples/map.png?raw=true '')

###### Shortcode:
`osma_charts_compare_map`

###### Options + example values:
- default_feature_type="highways"
- default_start_year="2012"
- default_end_year="now"
- country="SWE"

#### Activity chart:
![Activity chart](https://github.com/GFDRR/opendri-website/blob/master/wp-content/plugins/osma-charts/samples/activity.png?raw=true "Compare map")

###### Shortcode:
`osma_charts_activity`

###### Options + example values:
- country="HTI"
- start_date="2000/01/01"
- end_date="2017/02/01"
- default_granularity="monthly"
- default_facet="features"

#### Contributors chart:
![Contributors chart](https://github.com/GFDRR/opendri-website/blob/master/wp-content/plugins/osma-charts/samples/contributors.png?raw=true "Compare map")

###### Shortcode:
`osma_charts_contributors`

###### Options + example values:
- country="HTI"
- start_date="2000/01/01"
- end_date="2017/02/01"

## Development

This plugin is a Wordpress wrapper for JavaScript/CSS found in [OSMA Charts](https://github.com/Vizzuality/osma-charts), and the content of `scripts` and `styles` are exports of that project.
Keep this in mind if you wish to modify them.
