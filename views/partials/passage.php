<?php

$passage = cacs_get_post_meta('cs_bible_passages', $cs_post->ID);

if (empty($passage)) {
	return;
}

$passage_header = __('Passage: ', 'connected_sermons');

if (false !== strpos($passage, ',')) {
	$passage_header = __('Passages: ', 'connected_sermons');
}

?>

<p><span class='ca-bold'><?php esc_html_e($passage_header); ?></span><?php esc_html_e($passage); ?></p>