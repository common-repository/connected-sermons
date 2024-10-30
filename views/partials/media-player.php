<?php
$media_type = get_post_meta($cs_post->ID, 'cs_media_type', true);
?>

<?php if ('mp3' === $media_type) : ?>
	<audio id="player-<?php echo ($cs_post->ID); ?>" controls>
		<source src="<?php echo cacs_get_post_meta('cs_mp3', $cs_post->ID) ?>" />
	</audio>
<?php endif ?>

<?php if ('youtube' === $media_type) : ?>
	<div class="plyr__video-embed" id="player-<?php echo ($cs_post->ID); ?>">
		<iframe src="<?php echo get_post_meta($cs_post->ID, 'cs_youtube_url', true) ?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency></iframe>
	</div>
<?php endif ?>

<?php if ('facebook' === $media_type) : ?>
	<div class="plyr__video-embed" id="player-<?php echo ($cs_post->ID); ?>">
		<?php echo get_post_meta($cs_post->ID, 'cs_facebook_embed', true) ?>
	</div>
<?php endif ?>

<?php if ('vimeo' === $media_type) : ?>
	<div class="plyr__video-embed" id="player-<?php echo ($cs_post->ID); ?>">
		<?php echo get_post_meta($cs_post->ID, 'cs_vimeo_embed', true) ?>
	</div>
<?php endif ?>

<?php if ('embed_code' === $media_type) : ?>
	<div class="plyr__video-embed" id="player-<?php echo ($cs_post->ID); ?>">
		<?php echo get_post_meta($cs_post->ID, 'cs_embed_code', true) ?>
	</div>
<?php endif ?>

<?php if ('url' === $media_type) : ?>
	<div class="plyr__video-embed" id="player-<?php echo ($cs_post->ID); ?>">
		<video id="player" playsinline controls data-poster="/path/to/poster.jpg">
			<source src="<?php echo get_post_meta($cs_post->ID, 'cs_source_url', true) ?>" type="video/mp4" />
		</video>
	</div>
<?php endif ?>

<script>
	const player_<?php echo ($cs_post->ID); ?> = new Plyr('#player-<?php echo ($cs_post->ID); ?>');
</script>