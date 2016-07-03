# Wordpress Plugin: Find a Distributor

## Distributor Post Type

This plugin adds a new post type to WordPress: Distributors.  Each post of this type represents a distributor which may be found through the plugin's other features.  The title of such a post is taken to be the name of the distributor-in-qusetion.  The body of such a post is taken to be a description of the distributor-in-question.  The edit page in the WordPress admin area for a distributor post allows users to enter metadata which allows the distributor to be geocoded (i.e. address, city, et cetera).

## [find_a_distributor] Shortcode

Placing `[find_a_distributor]` into any WordPress post causes the plugin to emit a widget which may be used to search a radius around a given geographical point for distributors.

## AJAX API

This plugin provides an AJAX API (accessible through `/wp-admin/admin-ajax.php`) through which clients may search for distributors within a certain radius of a certain point.

The API accepts `GET` requests with the following query string parameters:

- `action`: Must always be set to `fgms_distributor_radius`
- `radius`: The radius in kilometers around the specified point (see below)

It then accepts one of two mutually exclusive sets of parameters which specify the center of the search radius: Either an absolute point in latitude and longitude, or a string which will be geocoded.

For an absolute point:

- `lat`: The latitude in degrees as a floating point number
- `lng`: The longitude in degrees as a floating point number

For a string which shall be geocoded:

- `address`: Despite the name not limited to simply addresses, you may provide addresses, the name of a city, a postal code, et cetera

It returns a response with `Content-Type: application/json` which is a JSON object which has the following properties:

- `lat`: The latitude provided, or the latitude in degrees to which the provided string geocoded
- `lng`: The longitude provided, or the longitude in degrees to which the provided string geocoded
- `radius`: The radius provided in kilometers
- `results`: An array containing objects representing each entry found within the search radius

The entries in the `results` array are not guaranteed to be in any particular order.

Each entry in the `results` array is a JSON object representing the distributor which has the following properties:

- `lat`: The latitude in degrees
- `lng`: The longitude in degrees
- `distance`: The distance in kilometers from the center of the search radius to this distributor
- `name`: The name of the distributor (this is the title of the WordPress post which represents this distributor)
- `description`: A description of the distributor (this is the content of the WordPress post which represents this distributor)
- `address`: The street address of the distributor
- `city`: The city in which the distributor is located
- `territorial_unit`: The state or province in which the distributor is located
- `country`: The country in which the distributor is located