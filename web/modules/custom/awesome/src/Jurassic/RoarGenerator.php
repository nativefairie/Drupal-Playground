<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/5/19
 * Time: 8:28 AM
 */

namespace Drupal\awesome\Jurassic;

use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;

class RoarGenerator
{
    /**
     * @var KeyValueFactoryInterface
     */
    private $keyValueFactory;
    private $useCache;

    public function __construct(KeyValueFactoryInterface $keyValueFactory, $useCache)
    {

        $this->keyValueFactory = $keyValueFactory;
        $this->useCache = $useCache;
    }

    public function getRoar($enteredNumber)
    {

        $store = $this->keyValueFactory->get('dino');
        $key = 'roar_'.$enteredNumber;

        if($this->useCache && $store->has($key)) {
          return $store->get($key);
        }

        sleep(2);

        if($enteredNumber > 10) {
            $string =  'R'.str_repeat('O', 10).'AR';
            $store->set('roar_10', $string);
            return $string;
        } else {
            $string = $string =  'R'.str_repeat('O', $enteredNumber).'AR';
            $store->set($key, $string);
            return $string;
        }
    }

}