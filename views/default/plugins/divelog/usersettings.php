<?php
/**
 * User settings edit code
 * user selects menu options from a list
 *
 * @package Divelog
 *
 */

// Load global lib for get_user_units
elgg_load_library('divelog');

// get previously saved settings for user, if any, otherwise, uses system default.
$guid = elgg_get_page_owner_guid();
$settings = elgg_get_all_plugin_user_settings($guid, 'divelog');
$create_from_event = $settings['create_from_event'];
$user_units = get_user_units();
?>
<div>
<?php
	echo elgg_echo('divelog:units_selection') . ' ';
	echo elgg_view('input/dropdown', array(
		'name' => 'params[user_units]',
		'options_values' => array(
			'metric' => elgg_echo('divelog:units_metric'),
			'imperial' => elgg_echo('divelog:units_imperial'),
		),
		'value' => $user_units,
	));
	echo '<p></p>';
	echo elgg_view('input/checkbox', array(
		'name' => 'params[create_from_event]',
		'checked' => $create_from_event ? $create_from_event : false,
	));
	echo elgg_echo('divelog:create_from_event') . ' ';
?>
</div>

<div>
<?php
	echo elgg_view_icon('divelog');
	echo '&nbsp;';
	echo elgg_view('output/url', array(
				'href' => elgg_get_site_url().'divelog/upload',
				'text' => elgg_echo('divelog:upload:linktopage'),
				'title' => elgg_echo('divelog:upload:linktopagehelp'),
			));?>	
</div>