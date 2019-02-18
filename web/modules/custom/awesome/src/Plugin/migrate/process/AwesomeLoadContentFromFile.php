<?php

namespace Drupal\awesome\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin import values from a file.
 *
 * @MigrateProcessPlugin(
 *   id = "awesome_load_content_from_file"
 * )
 */
class AwesomeLoadContentFromFile extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value,
                            MigrateExecutableInterface $migrate_executable,
                            Row $row,
                            $destination_property) {

    if (empty($this->configuration['folder'])) {
      throw new MigrateException('Argument folder is mandatory.');
    }
    if (empty($this->configuration['source'])) {
      throw new MigrateException('Argument source is mandatory.');
    }

    $folder = $this->configuration['folder'];
    $source = $this->configuration['source'];
    $body = $row->getSourceProperty($source);
    $data = file_get_contents($folder . '/' . $body);
    print_r($data);
    return $data;
  }

}
