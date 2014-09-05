<?php

/**
 * @file
 * Contains \Drupal\micro\Access\MicroAddAccessCheck.
 */

namespace Drupal\micro\Access;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Determines access to for micro add pages.
 */
class MicroAddAccessCheck implements AccessInterface {

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs a EntityCreateAccessCheck object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function access(Route $route, Request $request, AccountInterface $account) {
    $access_controller = $this->entityManager->getAccessControlHandler('micro');
    // If a micro type is set on the request, just check that.
    if ($request->attributes->has('micro_type')) {
      return $access_controller->createAccess($request->attributes->get('micro_type')->id, $account) ? static::ALLOW : static::DENY;
    }
    foreach ($this->entityManager->getBundleInfo('micro') as $bundle => $info) {
      if ($access_controller->createAccess($bundle, $account)) {
        // Allow access if at least one type is permitted.
        return static::ALLOW;
      }
    }
    return static::DENY;
  }

}
