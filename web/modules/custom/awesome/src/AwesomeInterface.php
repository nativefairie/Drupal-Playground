<?php

namespace Drupal\awesome;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining an Awesome entity.
 *
 * We have this interface so we can join the other interfaces it extends.
 *
 * @ingroup awesome_content_entity
 */
interface AwesomeInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
