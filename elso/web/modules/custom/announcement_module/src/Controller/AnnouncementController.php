<?php

namespace Drupal\announcement_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\announcement_module\AnnouncementService;

/**
 * Controller for displaying announcements.
 */
class AnnouncementController extends ControllerBase {

  /**
   * The announcement service.
   *
   * @var \Drupal\announcement_module\AnnouncementService
   */
  protected $announcementService;

  /**
   * Constructs a new AnnouncementController object.
   *
   * @param \Drupal\announcement_module\AnnouncementService $announcement_service
   *   The announcement service.
   */
  public function __construct(AnnouncementService $announcement_service) {
    $this->announcementService = $announcement_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('announcement_module.announcement_service')
    );
  }

  /** 
 * Lists announcements.
 *
 * @return array
 *   A render array. 
 */
public function listAnnouncements() {
  $announcements = $this->announcementService->getAnnouncements();

  $build = [];
  foreach ($announcements as $announcement) {
    $build[] = [
      '#markup' => '<h2>' . $announcement->getTitle() . '</h2>',
    ];
    
    // Ellenőrzés a field_document létezésére és, hogy van-e hozzárendelt entitás.
    if ($announcement->hasField('field_document') && !$announcement->get('field_document')->isEmpty() && $announcement->get('field_document')->entity) {
      $build[] = [
        '#markup' => '<p>' . $announcement->get('field_document')->entity->getFileUri() . '</p>',
      ];
    } else {
      $build[] = [
        '#markup' => '<p>No document attached.</p>',
      ];
    }
  }

  return $build;
}


}
