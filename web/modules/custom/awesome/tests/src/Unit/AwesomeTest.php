<?php
namespace Drupal\Tests\awesome\Unit;

use Drupal\awesome\Jurassic\RoarGenerator;
use Drupal\Core\KeyValueStore\KeyValueFactory;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use Drupal\Core\KeyValueStore\KeyValueStoreInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Test are awesome
 *
 * @group awesome_test
 */
class AwesomeTest extends UnitTestCase {
  protected $unit;
  private $keyValueFactory;
  private $number;

  /**
   * Before a test method is run, setUp() is invoked.
   * Create new unit object.
   *
   * @param $number
   */

  public function buildMocks($cacheStatus = TRUE) {
    $keyValueStore = $this->createMock(KeyValueStoreInterface::class);
    $keyValueStore->method('has')
      ->with($this->anything())
      ->willReturn($cacheStatus);

    $keyValueStore->method('get')
      ->willReturn('R'.$this->noMoreThanTen($this->number).'AR');

    $keyValueFactory =$this->createMock(KeyValueFactoryInterface::class);
    $keyValueFactory->method('get')
      ->with('dino')
      ->willReturn($keyValueStore);
    $this->keyValueFactory = $keyValueFactory;
  }

  private function noMoreThanTen($number) {
    if($this->number > 10){
      return str_repeat('O', 10);
    } else {
      return str_repeat('O', $this->number);
    }
  }

  /**
   * @test
   */
  public function shouldReturnStoreKeyWhenCacheActive() {
    $this->number = 1;
    $this->buildMocks();
    $this->unit = new RoarGenerator($this->keyValueFactory, TRUE);
    $Roar = $this->unit->getRoar($this->number);
    $this->assertEquals('ROAR', $Roar);

    $this->number = 14;
    $this->buildMocks();
    $this->unit = new RoarGenerator($this->keyValueFactory, TRUE);
    $Roar = $this->unit->getRoar($this->number);
    $this->assertEquals('ROOOOOOOOOOAR', $Roar);
  }

  /**
   * @test
   */
  public function shouldReturnStoreKeyWhenCacheNotActive() {
    $this->number = 1;
    $this->buildMocks(FALSE);
    $this->unit = new RoarGenerator($this->keyValueFactory, TRUE);
    $Roar = $this->unit->getRoar($this->number);
    $this->assertEquals('ROAR', $Roar);

    $this->number = 14;
    $this->buildMocks(FALSE);
    $this->unit = new RoarGenerator($this->keyValueFactory, TRUE);
    $Roar = $this->unit->getRoar($this->number);
    $this->assertEquals('ROOOOOOOOOOAR', $Roar);
  }

  /**
   * @test
   */
  public function shouldReturnTenRoarsWhenInputGreaterThanTen() {
    $this->number = 1;
    $this->buildMocks(FALSE);
    $this->unit = new RoarGenerator($this->keyValueFactory, FALSE);
    $Roar = $this->unit->getRoar($this->number);
    $this->assertEquals('ROAR', $Roar);

    $this->number = 14;
    $this->buildMocks();
    $this->unit = new RoarGenerator($this->keyValueFactory, FALSE);
    $Roar = $this->unit->getRoar($this->number);
    $this->assertEquals('ROOOOOOOOOOAR', $Roar);
  }

  public function tearDown() {
    unset($this->unit);
  }
}

