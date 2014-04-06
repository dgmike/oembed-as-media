<form action="<?php echo $url; ?>" method="post" class="media-upload-form type-form validate">
	<input type="hidden" name="_wpnonce" value="<?php echo $nonce; ?>" />
	<input type="hidden" name="redirect" value="media-upload.php?type=file&tab=library" />
	<h3 class="media-title"><?php echo _e( 'oEmbed from URL', OEM_TRANSLATE_ID ); ?></h3>
	<div class="media-item media-blank">
		<table class="describe">
			<tbody>
				<tr>
					<th valign="middle" scope="row" class="label">
						<label for="oam_url"><span class="alignleft"><?php _e( 'URL', OEM_TRANSLATE_ID ); ?></span></label>
					</th>
					<td class="field"><input type="text" name="oam_url" id="oam_url" value="<?php echo filter_var( $oam_url, FILTER_SANITIZE_SPECIAL_CHARS ); ?>" placeholder="http://" /></td>
				</tr>
				<tr>
					<td<?php if ( $preview ): ?> rowspan="2"<?php endif; ?>></td>
					<td>
						<input type="submit" name="preview" class="button" value="<?php _e( 'Preview', OEM_TRANSLATE_ID ); ?>" />
						<input type="submit" name="insert" class="button button-primary" value="<?php _e( 'Add', OEM_TRANSLATE_ID ); ?>" />
					</td>
				</tr>
				<?php if ( $preview ): ?>
				<tr>
					<td id="preview"><?php echo $preview; ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</form>
