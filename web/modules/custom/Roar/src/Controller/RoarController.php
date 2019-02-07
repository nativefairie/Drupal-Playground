<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/5/19
 * Time: 5:41 AM
 */

namespace Drupal\roar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\roar\Jurassic\RoarGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
//use Symfony\Component\HttpFoundation\Response;

class RoarController extends ControllerBase
{

    /**
     * @var RoarGenerator
     */
    private $roarGenerator;

    public function __construct(RoarGenerator $roarGenerator)
    {

        $this->roarGenerator = $roarGenerator;
    }

    public static function create(ContainerInterface $container)
    {
        $roarGenerator = $container->get('jurassic_roar.dino_internal');
        if (!empty($roarGenerator)) {
            return new static($roarGenerator);
        } else
            return new static($roarGenerator);
    }


    public function roar($number)
    {
        $roar = $this->roarGenerator->getRoar($number);
        return array(
            '#markup' => $roar
        );
    }

}