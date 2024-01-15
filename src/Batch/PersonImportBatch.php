<?php
namespace Drupal\personsmodule\Batch;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Batch\BatchBase;

use Drupal\personsmodule\Import;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\personsmodule\Entity\PersonModule;
class PersonImportBatch  {

/**
   * {@inheritdoc}
   */
 

    /**
     * Batch process function to import data from a CSV file into a custom entity.
     *
     * @param mixed $csv_file
     *   The CSV file path.
     * @param mixed $options1
     *   The first set of options.
     * @param mixed $options2
     *   The second set of options.
     * @param array $context
     *   The batch context.
     */
    function process($csv_file, $options1, $options2, &$context) {
      
      // Open the CSV file for reading.
      $handle = fopen($csv_file, 'r');
    
      if ($handle !== FALSE) {
        // Move the file pointer to the current row.
        fseek($handle, $context['sandbox']['current_row']);
    
        // Read rows from the CSV file.
        while (($row = fgetcsv($handle)) !== FALSE && $context['sandbox']['progress'] < $context['sandbox']['max']) {
          // Here you can process the CSV data and create a new "Person" entity.
          $person_data = array_combine(['name', 'id', 'location', 'age'], $row);
    
          // Create a new Person entity.
          $person = \Drupal\personsmodule\Entity\PersonModule::create([
            'name' => $person_data['name'],
            'id' => $person_data['id'],
            'location' => $person_data['location'],
            'age' => $person_data['age'],
          ]);
          $person->save();
    
          // Store some result for post-processing in the finished callback.
          $context['results'][] = check_plain($person_data['name']);
    
          // Update our progress information.
          $context['sandbox']['progress']++;
          $context['sandbox']['current_row'] = ftell($handle);
          $context['message'] = t('Now processing row: @row', ['@row' => implode(', ', $row)]);
        }
    
        // Close the CSV file.
        fclose($handle);
      }
    
      // Inform the batch engine that we are not finished,
      // and provide an estimation of the completion level we reached.
      if ($context['sandbox']['progress'] < $context['sandbox']['max']) {
        $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
      }
    }
    
  
  public static function finished($success, $results, $operations) {
    
    if ($success) {
        \Drupal::messenger()->addMessage(t("CSV file import is complete."));
    }
    else {

      \Drupal::messenger()->addMessage(t("An error occurred during CSV file import."));
    }
  }

 

}

