<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/5/19
 * Time: 8:28 AM
 */

namespace Drupal\roar\Jurassic;

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

    public function generateRandomNumber()
    {
        try {
            $randomNumber = random_int(1, 100);
        }
        catch (\Exception $e) {
        }
        return $randomNumber;
    }

    public function getRoar($enteredNumber)
    {
        $store = $this->keyValueFactory->get('dino');
        $key = 'roar_'.$enteredNumber;

        if($this->useCache && $store->has($key)) {
            return $store->get($key);
        }

        $expectedNumber = $this->generateRandomNumber();

        if($expectedNumber - 15 <= $enteredNumber && $enteredNumber <= $expectedNumber + 15 ) {

            $string =  $expectedNumber.' was the number I was thinking of, but '.$enteredNumber.' was close :) <br>BTW: hit ctrl+R to see cache in action!';
            $store->set($key, $string);
            return $string;
        } elseif( $expectedNumber == $enteredNumber) {

            $string =  $expectedNumber .' - Woah, you got the exact number I was thinking of!';
            $store->set($key, $string);
            return $string;
        } else {
            $string =  $expectedNumber.' was the number I was thinking of. '.$enteredNumber.' wasn\'t too close :) <br>BTW: hit ctrl+R to see cache in action!';
            $store->set($key, $string);
            return $string;
        }
    }

}