<div class="container">
	<div class="row">
		<div class="col-md-8">
			<?php
			$form = cmb2_get_metabox_form('cs_settings', CACS_SETTNIGS_ID);
			echo $form;
			?>
		</div>
		<div class="col-md-4">
			<?php cacs_get_part('promo-column'); ?>
		</div>
	</div>
</div>