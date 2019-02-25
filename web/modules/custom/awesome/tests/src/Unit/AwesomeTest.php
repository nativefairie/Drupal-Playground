<?php
namespace Drupal\awesome\tests\src\Unit;

use Drupal\awesome\Jurassic\RoarGenerator;
use Drupal\Tests\UnitTestCase;

/**
 * Simple test to ensure that asserts pass.
 *
 * @group awesome_test
 */
class AwesomeTest extends UnitTestCase {
  protected $unit;
  /**
   * Before a test method is run, setUp() is invoked.
   * Create new unit object.
   */
  public function setUp() {
    $this->unit = new RoarGenerator(3, false);
  }

  public function testGetRoar() {
    $this->assertEquals('3 - Woah, you got the exact number I was thinking of!', getRoar(3));
  }
//  /**
//   * @covers Drupal\awesome\Jurassic\RoarGenerator::getRoar
//   */
//  public function testGetLength() {
//    $this->unit->setLength(9);
//    $this->assertNotEquals(10, $this->unit->getLength());
//  }
  /**
   * Once test method has finished running, whether it succeeded or failed, tearDown() will be invoked.
   * Unset the $unit object.
   */
  public function tearDown() {
    unset($this->unit);
  }
}

