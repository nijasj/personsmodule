<?php

namespace Drupal\personsmodule\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining person entities.
 *
 * @ingroup personsmodule
 */
interface PersonsModuleEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the person Title.
   *
   * @return string
   *   Title of the person.
   */
  public function getTitle();

  /**
   * Sets the  person.
   *
   * @param string $title
   *   The  person title.
   *
   * @return \Drupal\personsmodule\Entity\PersonsModuleEntityInterface
   *   The called person entity.
   */
  public function setTitle($title);

  /**
   * Gets the person creation timestamp.
   *
   * @return int
   *   Creation timestamp of the person.
   */
  public function getCreatedTime();

  /**
   * Sets the person creation timestamp.
   *
   * @param int $timestamp
   *   The person creation timestamp.
   *
   * @return \Drupal\personsmodule\Entity\PersonsModuleEntityInterface
   *   The called person entity.
   */
  public function setCreatedTime($timestamp);

}
