<?php
/**
 * Additional content filters. DOES NOT render anything.
 *
 * Add selection to filter for planned, buddy, and statistics
 *
 * @uses $vars['filter_context']  Filter context: all, friends, mine
 * @uses $vars['context']         Page context (override)
 */
$context = elgg_extract('context', $vars, elgg_get_context());

// we only add these in the divelog filter menu
if(strpos($context, 'divelog') === false)
	return;

$menu_insert_priority = 700;

if (elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');

	// generate a list of additional tabs
	$tabs = array(
		'buddy' => array(
			'text' => elgg_echo('divelog:filter:buddy'),
			'href' => "$context/buddy/$username",
			'selected' => ($filter_context == 'buddy'),
			'priority' => $menu_insert_priority + 20,
		),
		'planned' => array(
			'text' => elgg_echo('divelog:filter:planned'),
			'href' => "$context/planned/$username",
			'selected' => ($filter_context == 'planned'),
			'priority' => $menu_insert_priority + 40,
		),
		'stats' => array(
			'text' => elgg_echo('divelog:filter:stats'),
			'href' => "$context/stats/$username",
			'selected' => ($filter_context == 'stats'),
			'priority' => $menu_insert_priority + 60,
		),
	);
	
	// insert them into filter bar
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}
}
