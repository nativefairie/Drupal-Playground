<?php
/**
 * @file
 * Contains \Drupal\awesome\UserTimeGenerator.
 */
namespace Drupal\awesome\Jurassic;

class UserTimeGenerator {
  /**
   *
   */
  public function generateUserTime() {
    return array(
      '#markup' => time(),
      '#cache' => ['contexts' => ['languages']],
    );
  }
}
