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
use Drupal\examples\Utility\DescriptionTemplateTrait;
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
//        $renderer = \Drupal::service('renderer');
//
//        $config = \Drupal::config('system.site');
//        $current_user = \Drupal::currentUser();
        $build = [
            '#title' => 'Article Info',
            '#prefix' => '<div id="page_wrapper">',
            '#suffix' => '</div>',
            'initial' => array
            (
                '#markup' => $roar
            ),
            'table' => array
            (
                '#theme' =>  'table',
            ),
            'list' => array
            (
                '#theme' =>  'awesome',
                '#prefix' => '<div id="list_wrapper">',
                '#suffix' => '</div>',
            ),
            'field' => array
            (
                '#prefix' => '<div id="field_wrapper">',
                '#suffix' => '</div>',
                '#theme' => 'item_list',
                '#list_type' => 'ul',
                '#items' => []
            ),
            'plain' => array
            (
                '#markup' => t('The coolest @time', ['@time' => time()]),
                '#cache' => [
                  'contexts' => ['languages'],
                ]
            )

        ];

        $rows = [];
        $header = array($this->t('ID'), $this->t('Time created'), $this->t('Author'), $this->t('Title'));

        $node_storage = \Drupal::entityTypeManager()->getStorage('node');
        $node = $node_storage->loadMultiple();
        foreach($node as $key => $item)  {
            $rows[$key]['id'] = $item->id();
            $rows[$key]['time-created'] = format_date($item->getCreatedTime());
            $account = \Drupal\user\Entity\User::load($item->getOwnerId());
            $rows[$key]['author'] = $account->getUsername();
            $rows[$key]['title'] = $item->label();
            if($item->hasField('field_url')!=null)
                $build['field']['#items'][$key] = $item->field_url->uri;

        }

        $build['table']['#rows'] = $rows;
        $build['table']['#header'] = $header;
        $build['table']['#theme'] = 'table';
        $build['list']['#theme'] = 'awesome';
        $build['#attached']['library'][] = 'awesome/awesome_libraries';
        $build['list']['#rows'] = $rows;
        $build['list']['#header'] = $header;

//        dd($this->cache();


      \Drupal :: logger ( 'awesome' ) -> debug( 'Info message' ) ;
      return $build;
    }

}