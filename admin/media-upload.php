<?php
/**
 * Create the tab in media lightbox
 */
function oam_add_tab ( $tabs ) {
	$oam_tab = array (
		'oembedasmedia' => __( 'Embed from URL', OEM_TRANSLATE_ID )
	);
	$tabs = array_merge( $tabs, $oam_tab );
	return $tabs;
}

add_filter( 'media_upload_tabs', 'oam_add_tab' );

/**
 * Create the content of page in media lightbox
 */
function create_oembed_as_media_page() {
	media_upload_header();
	wp_enqueue_style( 'media' );
	$post_id = isset($_REQUEST['post_id']) ? intval( $_REQUEST['post_id'] ) : '';
	$query = http_build_query(
		array(
			'type'    => $GLOBALS['type'],
			'tab'     => 'oembedasmedia',
			'post_id' => $post_id,
		)
	);
	$url = site_url( 'wp-admin/media-upload.php?' . $query, 'admin');
	require dirname( __FILE__ ) . '/media-tab.php';
}

function insert_oembed_as_media_iframe() {
	return wp_iframe( 'create_oembed_as_media_page');
}

add_action('media_upload_oembedasmedia', 'insert_oembed_as_media_iframe');
