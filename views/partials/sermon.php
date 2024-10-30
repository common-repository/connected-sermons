<div class="card mb-3 w-100">
	<div class="row no-gutters">
		<div class="col-md-4">
			<img src="<?php echo cacs_get_sermon_image($cs_post); ?>" class="" alt="..." width="100%" height="100%" style="height:100%;">
			<button class='cs-play-sermon-list' data-toggle="modal" data-target="#player-modal-<?php echo ($cs_post->ID); ?>"><img class="cs-play-icon" src="<?php echo WP_PLUGIN_URL . '/' . CACS_DIRECTORY_NAME . '/utils/images/play.svg' ?>" alt="Play Sermon Button"></button>
		</div>
		<div class="col-md-8">
			<div class="card-body">
				<a href="<?php echo get_permalink($cs_post->ID); ?>">
					<h5 class="card-title"><?php echo $cs_post->post_title ?></h5>
				</a>
				<p class="card-text"><?php echo cacs_get_post_meta('cs_sermon_teaser', $cs_post->ID); ?></p>
				<hr />
				<div class='row'>
					<div class='col-lg'>
						<p class="card-text"><span class='ca-bold'><?php esc_html_e('Sermon Date: ', 'connected_sermons'); ?></span><?php echo cacs_get_sermon_date($cs_post); ?></p>
					</div>
					<div class='col-lg'>
						<?php cacs_get_part('passage', $cs_post); ?>
					</div>
				</div>
				<div class='row'>
					<div class="col-md"><?php cacs_get_part('preachers', $cs_post); ?></div>
					<div class="col-md"><?php cacs_get_part('series', $cs_post); ?></div>
					<div class="col-md"><?php cacs_get_part('topics', $cs_post); ?></div>
					<div class="col-md"><?php cacs_get_part('books', $cs_post); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade " id="player-modal-<?php echo ($cs_post->ID); ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<?php echo $cs_post->post_title ?>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php cacs_get_part('media-player', $cs_post); ?>
			</div>
		</div>
	</div>
</div>