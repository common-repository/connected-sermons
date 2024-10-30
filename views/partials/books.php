<?php

$books = cacs_get_taxonomy_list_of_sermon($cs_post, 'cs_books');

if (empty($books)) {
	return;
} ?>

<p><span class='ca-bold'>Books</p>

<?php
foreach ($books as $book) {
	$term_link = cacs_get_sermon_list_selector_term_link($book);
	echo "<a href='{$term_link}'>{$book->name}</a>";
}
