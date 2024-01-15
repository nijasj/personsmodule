<?php

namespace Drupal\personsmodule;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of person entities.
 *
 * @ingroup personsmodule
 */
class PersonsModuleEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = $this->t('Name');
    $header['id'] = $this->t('id');
    $header['location'] = $this->t('location');
    $header['age'] = $this->t('age');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\personsmodule\Entity\PersonsModuleEntity $entity */
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.persons_module.canonical',
      ['persons_module' => $entity->id()]
    );
    $row['id'] = $entity->id->getValue()['0']['value'];
    $row['location'] = $entity->location->getValue()['0']['value'];
    $row['age'] = $entity->age->getValue()['0']['value'];
    return $row + parent::buildRow($entity);
  }
}
