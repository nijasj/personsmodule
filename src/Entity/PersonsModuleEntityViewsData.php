<?php

namespace Drupal\personsmodule\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for persons_module entities.
 */
class PersonsModuleEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
