<?php

$preachers = cacs_get_taxonomy_list_of_sermon($cs_post, 'cs_preachers');

if (empty($preachers)) {
	return;
}
?>

<p><span class='ca-bold'>Preacher</p>

<?php
foreach ($preachers as $preacher) {
	$term_link = cacs_get_sermon_list_selector_term_link($preacher);
	echo "<a href='{$term_link}'>{$preacher->name}</a>";
}
