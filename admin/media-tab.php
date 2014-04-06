<form action="<?php echo $url; ?>" class="media-upload-form type-form validate">
	<h3 class="media-title"><?php echo _e( 'oEmbed from URL', OEM_TRANSLATE_ID ); ?></h3>
	<div class="media-item media-blank">
		<table class="describe">
			<tbody>
				<tr>
					<th valign="middle" scope="row" class="label">
						<label for="oam_url"><span class="alignleft"><?php _e( 'URL', OEM_TRANSLATE_ID ); ?></span></label>
					</th>
					<td class="field"><input type="text" name="oam_url" id="oam_url" /></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" id="oam_preview" class="button button-primary" value="<?php _e( 'Add', OEM_TRANSLATE_ID ); ?>" />
						<input type="submit" class="button" value="<?php _e( 'Preview', OEM_TRANSLATE_ID ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</form>
