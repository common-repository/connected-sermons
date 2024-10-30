<div class="container">
	<div class="row">
		<div class="col-md">
			<?php if (cacs_is_free()) : ?>
				<div class="card">
					<div class="card-body">
						<h4><?php echo __('Everything is better when you go Pro!', 'connected_sermons'); ?></h4>
						<ul>
							<li><?php echo __('Premium Shortcodes', 'connected_sermons'); ?></li>
							<li><?php echo __('14 Additional Bible Translations!', 'connected_sermons'); ?></li>
							<li><?php echo __('Premium Layouts (Coming Soon)', 'connected_sermons'); ?></li>
							<li><?php echo __('Sermon Document Attachments (Coming Soon)', 'connected_sermons'); ?></li>
							<li><?php echo __('Social Sharing (Coming Soon)', 'connected_sermons'); ?></li>
							<li><?php echo __('Sermon Analytics (Coming Soon)', 'connected_sermons'); ?></li>
							<li><?php echo __('Premium Support', 'connected_sermons'); ?></li>
							<li><?php echo __('Ad Removal', 'connected_sermons'); ?></li>
						</ul>
					</div>
				</div>
			<?php endif ?>
		</div>
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<ul>
						<?php if (cacs_is_free()) : ?>
							<li><a href="https://church.agency/connected-sermons/#buy-connected-sermons"> <?php echo __('Go Premium', 'connected_sermons'); ?></a></li>
						<?php endif ?>
						<li><a href="https://church.agency/connected-sermons/#changelog"> <?php echo __('Change Log', 'connected_sermons'); ?></a></li>
						<li><a href="https://church.agency/docs/"> <?php echo __('Documentation', 'connected_sermons'); ?></a></li>
						<li><a href="https://church.agency/contact-us/"> <?php echo __('Support', 'connected_sermons'); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md">
			<?php cacs_get_part('promo-column'); ?>
		</div>
	</div>
</div>