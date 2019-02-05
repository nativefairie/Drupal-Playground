<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/5/19
 * Time: 5:41 AM
 */

namespace Drupal\roar\Controller;

use Symfony\Component\HttpFoundation\Response;

class RoarController
{

    public function roar()
    {
        return new Response('ROAR');
//        return array(
//            '#markup' => t('ROAR')
//        );
    }

}