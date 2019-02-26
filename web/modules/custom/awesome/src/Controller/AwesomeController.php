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
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;


class AwesomeController extends ControllerBase
{

    /**
     * @var RoarGenerator
     */
    private $roarGenerator;
    private $formatDate;

    public function __construct(RoarGenerator $roarGenerator, DateFormatterInterface $formatDate)
    {
        $this->roarGenerator = $roarGenerator;
        $this->formatDate = $formatDate;
    }


    public static function create(ContainerInterface $container)
    {
        $roarGenerator = $container->get('jurassic_roar.dino_internal');
        $formatDate = $container->get('date.formatter');
        return new static($roarGenerator, $formatDate);
    }

    public function roar($number)
    {
      $roar = $this->roarGenerator->getRoar($number);
      $build = [
        '#title' => 'Article Info',
        '#prefix' => '<div id="page_wrapper">',
        '#suffix' => '</div>',
        'roar' => array(
            '#markup' => $roar
        ),
        'table' => array(
            '#theme' =>  'table',
        ),

//        'list' => array(
//            '#theme' =>  'awesome',
//            '#prefix' => '<div id="list_wrapper">',
//            '#suffix' => '</div>',
//        ),
        /**
          * 'field' => array(
          * '#prefix' => '<div id="field_wrapper">',
          * '#suffix' => '</div>',
          * '#theme' => 'item_list',
          * '#list_type' => 'ul',
          * '#items' => []
          * ),
         */

      ];

      $rows = [];
      $header = array($this->t('ID'), $this->t('Time created'), $this->t('Author'), $this->t('Title'));

      $nids = \Drupal::entityQuery('node')->condition('type','page')->execute();
      $node =  \Drupal\node\Entity\Node::loadMultiple($nids);
      $i = -1;
      foreach($node as $key => $item) {
        ++$i;
        if($i<2) {
          $rows[$key]['id'] = $item->id();
          $rows[$key]['date'] = $this->formatDate->format($item->getCreatedTime(), '', '', date_default_timezone_get());
          $account = \Drupal\user\Entity\User::load($item->getOwnerId());
          $rows[$key]['author'] = $account->getUsername();
          $rows[$key]['title'] = $item->label();
          /**
           * if($item->hasField('field_url')!=null)
           *  $build['field']['#items'][$key] = $item->field_url->uri;
           */
        }
      }


      $build['table']['#rows'] = $rows;
      $build['table']['#header'] = $header;
      $build['#attached']['library'][] = 'awesome/awesome_libraries';
//      $build['list']['#theme'] = 'awesome';
//      $build['list']['#rows'] = $rows;
//      $build['list']['#header'] = $header;

      return $build;
    }

}