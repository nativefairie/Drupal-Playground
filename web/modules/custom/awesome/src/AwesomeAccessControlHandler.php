<?php

namespace Drupal\awesome;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the awesome entity.
 */
class AwesomeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. checkAccess() is called with the
   * $operation as defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    // Check the admin_permission as defined in your @ContentEntityType
    // annotation.
    $admin_permission = $this->entityType->getAdminPermission();
    if (\Drupal::currentUser()->hasPermission($admin_permission)) {
      return AccessResult::allowed();
    }
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view awesome entity');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit awesome entity');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete awesome entity');
    }
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   *
   * Separate from the checkAccess because the entity does not yet exist. It
   * will be created during the 'add' process.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    // Check the admin_permission as defined in your @ContentEntityType
    // annotation.
    $admin_permission = $this->entityType->getAdminPermission();
    if (\Drupal::currentUser()->hasPermission($admin_permission)) {
      return AccessResult::allowed();
    }
    return AccessResult::allowedIfHasPermission($account, 'add awesome entity');
  }

}
