<?php


namespace Drupal\awesome\Controller;

use \Drupal\node\Controller\NodeController;

/**
 * Returns my customizations for Node routes.
 */
class AwesomeControllerOverrideNode extends NodeController {

  /**
   * {@inheritdoc}
   */
  public function addPage() {
    $build = [
      '#theme' => 'node_add_list',
      '#cache' => [
        'tags' => $this->entityManager()->getDefinition('node_type')->getListCacheTags(),
      ],
    ];

    $content = array();

    // Only use node types the user has access to.
    foreach ($this->entityManager()->getStorage('node_type')->loadMultiple() as $type) {
      $access = $this->entityManager()->getAccessControlHandler('node')->createAccess($type->id(), NULL, [], TRUE);
      if ($access->isAllowed()) {
        $content[$type->label()] = $type;
      }
//      $my_var = $this->entityManager()->getStorage('awesome_content_entity')->getEntityType();
//      array_push($content, $my_var);
//      dd($content);
      $this->renderer->addCacheableDependency($build, $access);
    }

    // Bypass the node/add listing if only one content type is available.
    if (count($content) == 1) {
      $type = array_shift($content);
      return $this->redirect('node.add', array('node_type' => $type->id()));
    }

    $build['#content'] = $content;

    return $build;
  }

}