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
	$nonce = wp_create_nonce( 'oembed-as-media' );
	$post_id = null;
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
			$oam_oembed = oam_oembed(
				$oam_url,
				array(
					'width' => 400,
					'height' => 300
				)
			);
			if ( !is_string( $oam_oembed ) ) {
				$preview = $oam_oembed->html;
			}
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

// helper method
function oam_oembed( $oam_url, $args = array() ) {
	$oembed = new WP_oEmbed;
	$provider = $oembed->discover( $oam_url );

	if ( $provider === false && substr( $url, 0, 5 ) === 'https' ) {
		$url = str_replace( 'https', 'http', $url );
		$provider = $oembed->discover( $url );
	}
	if ( $provider === false ) {
		return __( 'No provider found for this URL.', OEM_TRANSLATE_ID );
	}
	$response = $oembed->fetch( $provider, $oem_url, $args );
	if ( $response === false ) {
		return __( 'Bad response from the provider for this URL.', OEM_TRANSLATE_ID );
	}
	return $response;
}

// action
function oam_add_media() {
	if ( !$_REQUEST['_wpnonce'] ) {
		return;
	}
	if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'oembed-as-media' ) ) {
		return;
	}
	if ( !isset( $_POST['insert'] ) ) {
		return;
	}
	$oam_url = filter_input( INPUT_POST, 'oam_url', FILTER_SANITIZE_URL );
	if ( isset( $_REQUEST['post_id'] ) ) {
		$post_id = intval( $_REQUEST['post_id'] );
	}
	$response = oam_oembed( $oam_url );
	$oEmbedPost = array(
		'post_title'     => $response->title,
		'post_content'   => '',
		'post_status'    => 'inherit',
		'post_author'    => get_current_user_id(),
		'post_type'      => 'attachment',
		'guid'           => $oam_url,
		'post_mime_type' => 'oembed/' . $response->provider_name
	);
	if ( $post_id ) {
		$oEmbedPost['post_parent'] = $post_id;
	}
	$media_post_id = wp_insert_post( $oEmbedPost );
	if( ! is_int( $media_post_id ) ) {
		$preview = __('An error occured during media saving.', OEM_TRANSLATE_ID );
	}
	if ( $_REQUEST['redirect'] ) {
		wp_safe_redirect( admin_url( $_REQUEST['redirect'] ) );
	} else {
		wp_safe_redirect( admin_url( 'upload.php' ) );
	}
	exit();
}

add_action( 'init', 'oam_add_media' );