<?php

$topics = cacs_get_taxonomy_list_of_sermon($cs_post, 'cs_topics');

if (empty($topics)) {
	return;
}
?>

<p><span class='ca-bold'>Topics</p>

<?php
foreach ($topics as $topic) {
	$term_link = cacs_get_sermon_list_selector_term_link($topic);
	echo "<a href='{$term_link}'>{$topic->name}</a>";
}
