<?php
namespace Drupal\personsmodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\personsmodule\Batch\PersonImportBatch;
use Drupal\file\Entity\File;

class PersonImportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'person_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Add file upload field.
    $form['csv_file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('CSV File'),
      
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
      ],
     
       
      '#description' => $this->t('Upload a CSV file containing person data (name, id, location, age).'),
    ];


    // Add submit button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Import'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */

  

  public function submitForm(array &$form, FormStateInterface $form_state) {
    if (\Drupal::currentUser()->hasPermission('upload_file_permission')) {
      // User has permission, proceed with file upload logic.
      // ...
    
  
    $file = $form_state->getValue('csv_file');
  
    if (!empty($file[0])) {
      $file = File::load($file[0]);
  
      // Trigger the batch operation to process the CSV file.
     
       
      $batch = [
        'title'            => $this->t('Importing CSV ...'),
        'operations' => array(
          array('\Drupal\personsmodule\Batch\PersonImportBatch::process', array($file->getFileUri())),
        ),
        'init_message'     => $this->t('Commencing'),
        'progress_message' => $this->t('Processed @current out of @total.'),
        'error_message'    => $this->t('An error occurred during processing'),
        'finished'         => '\Drupal\personsmodule\Batch\PersonImportBatch::finished',
      ];

      // Add the batch operation.
      $batch['operations'][] = [
        '\Drupal\personsmodule\Batch\PersonImportBatch::process',
        [$file_uri],
      ];
      
      // Start the batch.
      batch_set($batch);
    }
      \Drupal::messenger()->addMessage(t("CSV file import has started. Check progress on the Batch Operations page"));    
    }
    else {
     
      \Drupal::messenger()->addMessage(t("No file uploaded. Please try again."));
    }

  }
 
  
}

  