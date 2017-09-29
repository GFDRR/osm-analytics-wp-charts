# Open Street Maps Analytics Charts

This Wordpress plugin provides integration with OSMA to display charts and maps inside pages.

## Installation

Install like any other Wordpress plugin

## Configuration

The plugin supports 2 configuration values, both of which are required:
- API URL: Address the API endpoint, typically ending in `/api/v1`
- Site URL: Address of the OSM analytics site, used in map embeds.


## Usage

The plugin currently provides 3 shortcodes, each rendering a different visualization:

#### Compare map:
![Compare map](https://github.com/GFDRR/osm-analytics-wp-charts/blob/master/samples/map.png?raw=true 'Compare map')

The compare map consists of a trimmed-down, embedded version of the OSM Analytics site. It uses a slider to show the status 
of OSM contributions in two dates, allowing a seamless visual comparison between them.

###### Shortcode:
`osma_charts_compare_map`

###### Options + example values:
- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __default_start_year__ (`2016`) represents the start year of an OpenDRI project
- __default_end_year__ (`now`) represents the end year of an OpenDRI project. `now` can also be provided to compare with latest OSM data
- __default_feature_type__ (`buildings`) compare `buildings` or `highways`

###### Example:

```
[osma_charts_compare_map country="HTI" default_feature_type="highways" default_start_year="2015" default_end_year="now"]
```

#### Activity chart:
![Activity chart](https://github.com/GFDRR/osm-analytics-wp-charts/blob/master/samples/activity.png?raw=true "Activity chart")

The activity charts illustrate a comparison between contributions done on multiple OSM features. As the features may not be directly aggregatable,
a simplified [https://en.wikipedia.org/wiki/Mahalanobis_distance](Mahalanobis distance) calculation is used to aggregate contributions.  

###### Shortcode:
`osma_charts_activity`

###### Options + example values:
- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __start_date__ (mandatory) (`2016-01-01`) represents the start date of an OpenDRI project
- __end_date__ (mandatory) (`2017-01-01`) represents the end date of an OpenDRI project
- __default_granularity__ (`daily`) show activity `daily|weekly|monthly` by default
- __default_facet__ (`features`) show either `features` or `users` histogram by default

###### Example:

```
[osma_charts_activity country="HTI" start_date="2000-01-01" end_date="2017-02-01" default_granularity="monthly" default_facet="features"]
```

#### Contributors chart:
![Contributors chart](https://github.com/GFDRR/osm-analytics-wp-charts/blob/master/samples/contributors.png?raw=true "Contributors chart")

The contributors chart shows a list of the top users for the given filter options, and an aggregated value for the remaining contributions

###### Shortcode:
`osma_charts_contributors`

###### Options + example values:
- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __start_date__ (mandatory) (`2016-01-01`) represents the start date of an OpenDRI project
- __end_date__ (mandatory) (`2017-01-01`) represents the end date of an OpenDRI project
- __num_users__ (`10`) number of users to show on the chart.
- __feature_type__ (`buildings`) buildings, highways or waterways
 
###### Example:

```
[osma_charts_statistics_table country="UGA" start_date="2010/01/01" end_date="2017/02/01" statistics="buildings-users,buildings-activity,waterways-users,waterways-activity"]
```

#### Statistics table:
![Statistics table](https://github.com/GFDRR/osm-analytics-wp-charts/blob/master/samples/statistics.png?raw=true "Statistics table")

The statistics table shows a list of the most relevant statistics for a given geography and time range.

###### Shortcode:
`osma_charts_statistics_table`

###### Options + example values:
- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __start_date__ (mandatory) (`2016-01-01`) represents the start date of an OpenDRI project
- __end_date__ (mandatory) (`2017-01-01`) represents the end date of an OpenDRI project
- __statistics__ (mandatory) (`buildings-users,...`) a comma separated list of feature/type pairs. Each feature/type pair must be separated by a dash. Features can be 
  `buildings`, `waterways` or `waterways`, and type should be either `users` or `activity`
 
###### Example:

```
[osma_charts_statistics_table country="UGA" start_date="2010/01/01" end_date="2017/02/01" statistics="buildings-users,buildings-activity,waterways-users,waterways-activity"]
```


#### Statistic value:

Shows a single statistical value for a given geography and time range. Ideal for embedding inline with other text.

###### Shortcode:
`osma_charts_statistic_value`

###### Options + example values:
- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __start_date__ (mandatory) (`2016-01-01`) represents the start date of an OpenDRI project
- __end_date__ (mandatory) (`2017-01-01`) represents the end date of an OpenDRI project
- __feature_type__ (mandatory) (`buildings`) `buildings`, `waterways` or `waterways`
- __statistic__ (mandatory) (`users`) type should be either `users` or `activity`
 
###### Example:

```
[osma_charts_statistic_value country="UGA" start_date="2010/01/01" end_date="2017/02/01" feature_type="buildings" statistic="activity"]
```


## Development / build from source

This plugin is a Wordpress wrapper for JavaScript/CSS found in [OSMA Charts](https://github.com/Vizzuality/osma-charts), and the content of `scripts` and `styles` are exports of that project.

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
