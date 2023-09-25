<?php

namespace Drupal\announcement_module;

use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * A service for retrieving Announcement content.
 */
class AnnouncementService {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructor for AnnouncementService.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }
  

  /**
   * Get a list of Announcement contents in descending order by date.
   *
   * @return array
   *   An array of Announcement content entities.
   */
  public function getAnnouncements() {
    $query = $this->entityTypeManager->getStorage('node')
    ->getQuery()
    ->condition('type', 'announcement')
    ->sort('created', 'DESC')
    ->accessCheck(TRUE); 

  
    // Access checks are enabled by default. No need to disable them.
  
    $result = $query->execute();
  
    return $this->entityTypeManager->getStorage('node')->loadMultiple($result);
  }

}
