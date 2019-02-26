<?php

namespace Drupal\Tests\awesome\Kernel;

use Drupal\awesome\Controller\AwesomeController;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\user\Entity\User;

/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/21/19
 * Time: 6:51 AM
 */

class AwesomeControllerTest extends EntityKernelTestBase {
  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'awesome', 'node', 'user', 'text', 'field', 'entity_test', 'datetime', 'system'
  ];
  /**
   * The controller under test.
   *
   * @var \Drupal\awesome\Controller\AwesomeController
   */
  private $controllerUnderTest;

  public function setUp() {
    parent::setUp();
    /**
     * The create function injects the service so there's no need to mock it.
     */
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installConfig(['system', 'field']);

//    $this->getMockBuilder('Drupal\awesome\Jurassic\RoarGenerator')->disableOriginalConstructor()->getMock();
    $this->controllerUnderTest = AwesomeController::create($this->container);

  }

  /**
   * Test Controller response.
   *
   * @test
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Exception
   */
  public function shouldRenderArrayContainTheFirstTwoNodesOfTypePage() {
    $nodeType = NodeType::create([
      'type' => 'page',
      'label' => 'Page',
    ]);
    $nodeType->save();

    $user = User::create();
    $user->setPassword('password');
    $user->enforceIsNew();
    $user->setEmail('email');
    $user->setUsername('user_name');
    $user->save();

    $node = Node::create([
      'type' => 'page',
      'title' => 'Page Title'
    ]);
    $timestamp = time();
//    $timestamp->setTimestamp();
//    print_r($timestamp);
    $node->setCreatedTime($timestamp);


    $node->setOwnerId($user->id());
    $node->save();
    $entity = Node::load($node->id());

    $this->assertTrue($entity->id(), 'The Node is enabled');
    $controllerResponse = $this->controllerUnderTest->roar(1);
    $this->assertContains($entity->id(), $controllerResponse['table']['#rows'][$entity->id()]);
  }
  /**
   * Test Controller response.
   * @test
   */
  public function shouldControllerInjectService() {
    $receivedResponse = ['#markup' => 'ROAR'];
    $controllerResponse = $this->controllerUnderTest->roar(1);
    $this->assertContains($receivedResponse, $controllerResponse, 'The service is successfully injected');
  }
}