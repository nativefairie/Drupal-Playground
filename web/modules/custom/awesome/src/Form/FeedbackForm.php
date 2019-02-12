<?php

namespace Drupal\awesome\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class FeedbackForm extends FormBase
{

    /**
     * Returns a unique string identifying the form.
     *
     * The returned ID should be a unique string that can be a valid PHP function
     * name, since it's used in hook implementation names such as
     * hook_form_FORM_ID_alter().
     *
     * @return string
     *   The unique string identifying the form.
     */
    public function getFormId()
    {
        return 'feedback';
    }

    /**
     * Form constructor.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     *
     * @return array
     *   The form structure.
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name'),
            '#required' => TRUE,
        );
        $form['email'] = array(
            '#type' => 'email',
            '#title' => t('Email'),
            '#required' => TRUE,
        );
        $form['number'] = array (
            '#type' => 'tel',
            '#title' => t('Phone'),
        );
        $form['birthdate'] = array (
            '#type' => 'date',
            '#title' => t('Date of Birth'),
            '#required' => TRUE,
        );
        $form['gender'] = array (
            '#type' => 'select',
            '#title' => ('Gender'),
            '#options' => array(
                'female' => t('Female'),
                'male' => t('Male'),
                'na' => t('N/A'),
            ),
        );
        $form['confirmation'] = array (
            '#type' => 'radios',
            '#title' => ('Anonymous feedback-er?'),
            '#options' => array(
                'Yes' =>t('Yes'),
                'No' =>t('No')
            ),
        );
        $form['feedback'] = array(
            '#type' => 'textfield',
            '#title' => t('Your feedback'),
            '#required' => TRUE,
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#button_type' => 'primary',
        );
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if (strlen($form_state->getValue('feedback')) < 10) {
            $form_state->setErrorByName('feedback', $this->t('Your feedback is too short. Please be more specific.'));
        }
    }


    /**
     * Form submission handler.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        foreach ($form_state->getValues() as $key => $value) {
            echo($key . ': ' . $value);
        }
    }
}