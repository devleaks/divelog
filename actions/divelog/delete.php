<?php
/**
 * Delete a divelog
 *
 * @package Divelog
 */

$guid = get_input('guid');
$divelog = get_entity($guid);

if (elgg_instanceof($divelog, 'object', 'divelog') && $divelog->canEdit()) {
	$container = $divelog->getContainerEntity();

//@todo: delete relationships for this dive (event_calendar and buddies)

	if ($divelog->delete()) {
		system_message(elgg_echo("divelog:delete:success"));
		if (elgg_instanceof($container, 'group')) {
			forward("divelog/group/$container->guid/all");
		} else {
			forward("divelog/owner/$container->username");
		}
	}
}

register_error(elgg_echo("divelog:delete:failed"));
forward(REFERER);
