<?php

$series = cacs_get_taxonomy_list_of_sermon($cs_post, 'cs_series');

if ( empty( $series ) ) {
	return;
} ?>

<p><span class='ca-bold'>Series</p>

<?php
foreach ( $series as $serie ) {
	$term_link = cacs_get_sermon_list_selector_term_link($serie);
	echo "<a href='{$term_link}'>{$serie->name}</a>";
}
