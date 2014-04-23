<?php
/**
 * Dive Logbook Plugin
 *
 * @package Divelog
 */

elgg_register_event_handler('init', 'system', 'divelog_init');

/**
 * Divelog init
 */
function divelog_init() {

	$root = dirname(__FILE__);
	elgg_register_library('divelog', "$root/lib/divelog.php");

	// actions
	$action_path = "$root/actions/divelog";
	elgg_register_action('divelog/save', "$action_path/save.php");
	elgg_register_action('divelog/delete', "$action_path/delete.php");
	elgg_register_action('divelog/convert_to_divelog', "$action_path/convert_to_divelog.php");
	elgg_register_action('divelog/copy_divelog', "$action_path/copy_divelog.php");
	elgg_register_action('divelog/upload', "$action_path/upload.php");
	elgg_register_action('divelog/confirmation_report', "$action_path/upload.php");
	elgg_register_action('divelog/delete_upload', "$action_path/delete_upload.php");
	elgg_register_action('divelog/confirmation_delete', "$action_path/delete_upload.php");
	// elgg_register_action('divelog/share', "$action_path/share.php");

	// menus
	elgg_register_menu_item('site', array(
		'name' => 'divelog',
		'text' => elgg_echo('divelog:sitemenu'),
		'href' => 'divelog/all'
	));

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'divelog_owner_block_menu');

	elgg_register_page_handler('divelog', 'divelog_page_handler');

	elgg_extend_view('css/elgg', 'divelog/css');
	elgg_extend_view('js/elgg', 'divelog/js');

	elgg_extend_view('page/layouts/content/filter', 'divelog/prependtofilter', 400); // must be prepended

	elgg_register_widget_type('divelog', elgg_echo('divelog'), elgg_echo('divelog:widget:description'));

	// Register granular notification for this type
	register_notification_object('object', 'divelog', elgg_echo('divelog:new'));

	// Listen to notification events and supply a more useful message
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'divelog_notify_message');

	// Register divelog view for ecml parsing
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'divelog_ecml_views_hook');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'divelog_entity_menu_setup');

	// Register a URL handler for divelog
	elgg_register_entity_url_handler('object', 'divelog', 'divelog_url');

	// Register entity type for search
	elgg_register_entity_type('object', 'divelog');
	
	// Groups
	add_group_tool_option('divelog', elgg_echo('divelog:enabledivelog'), true);
	elgg_extend_view('groups/tool_latest', 'divelog/group_module');
}

/**
 * Dispatcher for divelog.
 *
 * URLs take the form of
 *  All divelog:        divelog/all
 *  User's divelog:     divelog/owner/<username>
 *  Friends' divelog:   divelog/friends/<username>
 *  View divelog:        divelog/view/<guid>/<title>
 *  New divelog:         divelog/add/<guid> (container: user, group, parent)
 *  Edit divelog:        divelog/edit/<guid>
 *  Group divelog:      divelog/group//all
 *
 * Title is ignored
 *
 * @param array $page
 * @return bool
 */
function divelog_page_handler($page) {
	
	elgg_load_library('divelog');

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo('divelog'), 'divelog/all');

	// old group usernames
	if (substr_count($page[0], 'group:')) {
		preg_match('/group\:([0-9]+)/i', $page[0], $matches);
		$guid = $matches[1];
		if ($entity = get_entity($guid)) {
			divelog_url_forwarder($page);
		}
	}

	// user usernames
	$user = get_user_by_username($page[0]);
	if ($user) {
		divelog_url_forwarder($page);
	}

	$pages = dirname(__FILE__) . '/pages/divelog';

	switch ($page[0]) {
		case "all":
			include "$pages/all.php";
			break;

		case "owner":
			include "$pages/owner.php";
			break;

		case "friends":
			include "$pages/friends.php";
			break;

		case "stats":
			include "$pages/stats.php";
			break;

		case "planned":
			include "$pages/planned.php";
			break;

		case "buddy":
			include "$pages/buddy.php";
			break;

		case "view":
			set_input('guid', $page[1]);
			include "$pages/view.php";
			break;
			
		case 'read': // Elgg 1.7 compatibility
			register_error(elgg_echo("changedivelog"));
			forward("divelog/view/{$page[1]}");
			break;

		case "add":
			gatekeeper();
			include "$pages/add.php";
			break;

		case "upload":
			gatekeeper();
			include "$pages/upload.php";
			break;

		case "delete_upload":
			gatekeeper();
			include "$pages/delete_upload.php";
			break;

		case "edit":
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;

		case 'group':
			group_gatekeeper();
			include "$pages/owner.php";
			break;

		default:
			return false;
	}

	elgg_pop_context();
	return true;
}

/**
 * Forward to the new style of URLs
 *
 * @param string $page
 */
function divelog_url_forwarder($page) {
	global $CONFIG;

	if (!isset($page[1])) {
		$page[1] = 'items';
	}

	switch ($page[1]) {
		case "read":
			$url = "{$CONFIG->wwwroot}divelog/view/{$page[2]}/{$page[3]}";
			break;
		case "inbox":
			$url = "{$CONFIG->wwwroot}divelog/inbox/{$page[0]}";
			break;
		case "friends":
			$url = "{$CONFIG->wwwroot}divelog/friends/{$page[0]}";
			break;
		case "add":
			$url = "{$CONFIG->wwwroot}divelog/add/{$page[0]}";
			break;
		case "items":
			$url = "{$CONFIG->wwwroot}divelog/owner/{$page[0]}";
			break;
	}

	register_error(elgg_echo("changedivelog"));
	forward($url);
}

/**
 * Populates the ->getUrl() method for Divelog objects
 *
 * @param ElggEntity $entity The Divelog object
 * @return string Divelog item URL
 */
function divelog_url($entity) {
	global $CONFIG;

	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return $CONFIG->url . "divelog/view/" . $entity->getGUID() . "/" . $title;
}

/**
 * Add a menu item to an ownerblock
 * 
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function divelog_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "divelog/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('divelog', elgg_echo('divelog'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->divelog_enable != 'no') {
			$url = "divelog/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('divelog', elgg_echo('divelog:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Returns the body of a notification message
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $returnvalue
 * @param array  $params
 */
function divelog_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'divelog')) {
		$descr = $entity->description;
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();

		return elgg_echo('divelog:notification', array(
			$owner->name,
			$title,
			$descr,
			$entity->getURL()
		));
	}
	return null;
}

/**
 * Return divelog views to parse for ecml
 *
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function divelog_ecml_views_hook($hook, $type, $return, $params) {
	$return['object/divelog'] = elgg_echo('item:object:divelog');
	return $return;
}


/**
 * Return add metadata menu entry to convert event_calendar to divelog
 * Removes all other menu entries, leaving just a "convert to divelog".
 *
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function divelog_entity_menu_setup ($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	//echo 'Handler: '.$handler.'<br/>';
	switch($handler) {
		case 'divelog_convert':
		    // Add a new menu item
			$options = array(
				'name' => 'divelog_convert',
				'text' => elgg_echo('divelog:convert'),
				'title' => elgg_echo('divelog:convert_hint'),
				'href' => elgg_add_action_tokens_to_url("action/divelog/convert_to_divelog?guid={$entity->guid}"),
				'priority' => 500,
			);
			$return = array(); // new empty array, remove all other options
		    $return[] = ElggMenuItem::factory($options);
			break;
		case 'divelog':
		    // Add a new menu item to copy dive if not owner of it.
			if ($entity->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
				$options = array(
					'name' => 'divelog_copy',
					'text' => elgg_echo('divelog:copy'),
					'title' => elgg_echo('divelog:copy_hint'),
					'href' => elgg_add_action_tokens_to_url("action/divelog/copy_divelog?guid={$entity->guid}"),
					'priority' => 500,
				);
				//$return = array(); // new empty array, remove all other options
			    $return[] = ElggMenuItem::factory($options);
			}
			break;
		default:
			break;
	}
    return $return;
}
