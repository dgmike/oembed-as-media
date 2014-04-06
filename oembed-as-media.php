<?php
/**
 * Plugin Name: oEmbed as media
 * Plugin URI: http://github.com/dgmike/oembed-as-media
 * Description: Creates an media in your library with an youtube, vimeo, hulu, and another oembed media. The plugin will fetch the data and create an media item with this data.
 * Version: $version$
 * Author: dgmike
 * Author URI: http://dgmike.com.br
 * License: GPLv2 or later
 */

define ( 'OEM_TRANSLATE_ID', 'oembedasmedia' );

require_once ABSPATH . WPINC . '/class-oembed.php';
require_once dirname( __FILE__ ) . '/admin/media-upload.php';
