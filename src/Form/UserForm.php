<?php
namespace Drupal\personsmodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class UserForm extends FormBase {

  public function getFormId() {
    return 'user_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    // Add your form elements here, including the dropdown for 'Age' and 'Location'.
   
    $form['filter'] = [
      '#type' => 'select',
      '#title' => $this->t('Filter by'),
      '#options' => ['age' => $this->t('Age'), 'location' => $this->t('Location')],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Redirect to the page displaying the dynamic table.
    $form_state->setRedirect('personsmodule.dynamic_table', ['filter' => $form_state->getValue('filter')]);
  }
}