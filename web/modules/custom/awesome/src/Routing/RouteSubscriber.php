<?php
/**
 * @file
 * Contains \Drupal\awesomeRouting\RouteSubscriber.
 */

namespace Drupal\awesome\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    // Change controller class for "node/add".
    if ($route = $collection->get('node.add_page')) {
      $route->setDefaults(array(
        '_title' => 'Add content',
        '_controller' => '\Drupal\awesome\Controller\AwesomeControllerOverrideNode::addPage'
      ));
    }
  }

}