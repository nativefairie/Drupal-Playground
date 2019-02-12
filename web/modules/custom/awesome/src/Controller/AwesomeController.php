<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/5/19
 * Time: 5:41 AM
 */

namespace Drupal\awesome\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\awesome\Jurassic\RoarGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class AwesomeController extends ControllerBase
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

        $var['node']['info'] = [
            '#markup' => '<h1>Article Info </h1>',
            '#title' => 'Article Info',
            '#theme' => 'table',
            '#header' => array(
                $this
                    ->t('ID'),
                $this
                    ->t('Time created'),
                $this
                    ->t('Author'),
                $this
                    ->t('Title')
            ),

        ];
        $rows = [];
        $node_storage = \Drupal::entityTypeManager()->getStorage('node');
        $node = $node_storage->loadMultiple();

        foreach($node as $key => $item) {

            $rows[$key]['id'] = $item->id();
            $rows[$key]['time-created'] = format_date($item->getCreatedTime());
            $account = \Drupal\user\Entity\User::load($item->getOwnerId());
            $rows[$key]['author'] = $account->getUsername();
            $rows[$key]['title'] = $item->label();

        }
        $var['node']['info']['#rows'] = $rows;

        return $var['node']['info'];
    }

}