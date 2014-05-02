<?php
/**
 * Upload divelog creation report view. Prints a nice table of all the created divelog/upload/.
 *
 * @package divelog/upload/
 */
echo $vars['report'];

echo '<p></p>';
echo elgg_view_icon('divelog');
echo '&nbsp;&nbsp;';
echo elgg_view('output/url', array(
			'href' => elgg_get_site_url().'divelog/upload',
			'text' => elgg_echo('divelog:upload:linktopage'),
			'title' => elgg_echo('divelog:upload:linktopagehelp'),
		));
echo '<p></p>';
echo elgg_view_icon('divelog');
echo '&nbsp;&nbsp;';
echo elgg_view('output/url', array(
			'href' => elgg_get_site_url().'divelog/download',
			'text' => elgg_echo('divelog:download'),
			'title' => elgg_echo('divelog:download'),
		));