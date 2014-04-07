<?php
/**
 * Divelog plugin settings.
 *
 * @package Divelog
 */
$units = $vars['entity']->divelog_units;
if (!$units)
	$units = 'metric';
?>
<div>
<?php
	echo elgg_echo('divelog:units_selection') . ' ';
	echo elgg_view('input/dropdown', array(
			'name' => 'params[divelog_units]',
			'options_values' => array(
			'metric' => elgg_echo('divelog:units_metric'),
			'imperial' => elgg_echo('divelog:units_imperial'),
		),
		'value' => $units,
	));
?>
</div>
