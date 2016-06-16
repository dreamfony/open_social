<?php

/**
 * @file
 * Contains \Drupal\activity_creator\Plugin\ActivityContext\GroupActivityContext.
 */

namespace Drupal\activity_creator\Plugin\ActivityContext;

use Drupal\activity_creator\Plugin\ActivityContextBase;
use Drupal\Core\Entity\Entity;
use Drupal\group\Entity\GroupContent;
use Drupal\social_group\SocialGroupHelperService;
use Drupal\social_post\Entity\Post;
use \Drupal\node\Entity\Node;

/**
 * Provides a 'GroupActivityContext' activity context.
 *
 * @ActivityContext(
 *  id = "group_activity_context",
 *  label = @Translation("Group activity context"),
 * )
 */
class GroupActivityContext extends ActivityContextBase {

  /**
   * {@inheritdoc}
   */
  public function getRecipients(array $data, $last_uid, $limit) {

    $recipients = [];

    // We only know the context if there is a related object.
    if (isset($data['related_object']) && !empty($data['related_object'])) {

      $referenced_entity = $data['related_object']['0'];

      if ($gid = SocialGroupHelperService::getGroupFromEntity($referenced_entity)) {
        $recipients[] = [
          'target_type' => 'group',
          'target_id' => $gid,
        ];
      }
    }

    return $recipients;
  }
}
