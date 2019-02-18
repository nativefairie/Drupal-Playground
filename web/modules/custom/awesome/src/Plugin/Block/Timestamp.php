<?php
/**
 * @file
 * Contains \Drupal\awesome\Plugin\Block\Timestamp.
 */
namespace Drupal\awesome\Plugin\Block;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'timestamp' block.
 *
 * @Block(
 * id = "timestamp",
 * admin_label = @Translation("Timestamp"),
 * )
 */
class Timestamp extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['timestamp'] = array(
      '#lazy_builder' => ['timestamp:generateUserTime', array()],
      '#create_placeholder' => TRUE,
    );
    $build['#markup'] = $this->t('The current time is: ');
    $build['#cache']['contexts'][] = 'languages';
    return $build;
  }
}