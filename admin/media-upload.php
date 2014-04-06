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
	$oam_url = filter_input( INPUT_POST, 'oam_url', FILTER_SANITIZE_URL );
	// form url
	$query = array(
		'type' => $GLOBALS['type'],
		'tab'  => 'oembedasmedia',
	);
	if ( isset( $_REQUEST['post_id'] ) ) {
		$query['post_id'] = intval( $_REQUEST['post_id'] );
	}
	$url = site_url(
		'wp-admin/media-upload.php?' . http_build_query( $query ), 'admin'
	);
	// preview
	$preview = '';
	if ( isset( $_POST['preview'] ) && $oam_url ) {
		$preview = $_POST['preview'];
		try {
			$oembed = new WP_oEmbed;
			$preview = $oembed->get_html($oam_url, array(
				'width' => 400,
				'height' => 300
			));
		} catch ( Exception $e ) {
			$preview = $e->getMessage();
		}
	}
	// view
	require dirname( __FILE__ ) . '/media-tab.php';
}

function insert_oembed_as_media_iframe() {
	return wp_iframe( 'create_oembed_as_media_page');
}

add_action('media_upload_oembedasmedia', 'insert_oembed_as_media_iframe');
