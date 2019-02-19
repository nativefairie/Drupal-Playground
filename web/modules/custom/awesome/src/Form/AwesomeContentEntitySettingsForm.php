<?php

namespace Drupal\awesome\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AwesomeContentEntitySettingsForm.
 *
 * @ingroup awesome_content_entity
 */
class AwesomeContentEntitySettingsForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'awesome_content_entity.awesome_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['awesome_settings']['#markup'] = 'Settings form for Awesome Content Entity. Manage field settings here.';
    return $form;
  }

}
