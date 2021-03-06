<?php
/**
 * Add as favourite action
 *
 */

$entity_guid = (int) get_input('guid');

//check to see if the user has already marked the item as favourite
if (elgg_annotation_exists($entity_guid, 'favourite')) {
    system_message(elgg_echo("favourites:alreadyfavourite"));
    forward(REFERER);
}
// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
    register_error(elgg_echo("favourites:notfound"));
    forward(REFERER);
}

// limit markings as favourite through a plugin hook (to prevent liking your own content for example)
if (!$entity->canAnnotate(0, 'favourite')) {
    // plugins should register the error message to explain why marking as favourite isn't allowed
    forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();
$annotation = create_annotation($entity->guid,
                                'favourite',
                                "",
				"",
				$user->guid,
				$entity->access_id);

// tell user annotation didn't work if that is the case
if (!$annotation) {
    register_error(elgg_echo("favourites:failure"));
    forward(REFERER);
}

// notify if poster wasn't owner
if ($entity->owner_guid != $user->guid) {
    favourites_notify_user($entity->getOwnerEntity(), $user, $entity);
}

system_message(elgg_echo("favourites:added"));

// Forward back to the page where the user marked the object as favourites
forward(REFERER);
