<?php

namespace Drupal\nmhockey_stats\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\migrate_plus\Plugin\migrate\process\EntityLookup;

/**
 * Returns EntityLookup for appending values to multi-valued field.
 *
 * @MigrateProcessPlugin(
 *   id = "entity_lookup_append",
 *   handle_multiples = TRUE
 * )
 */
class EntityLookupAppend extends EntityLookup {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Custom code to update the sourceid1 value. @todo: remove and use process.
    // $sourceid1 = $row->getSourceProperty('player');.
    $player = $row->getSourceProperty('player');
    $parts = explode(", ", $player);
    $sourceid1 = implode(' ', array_reverse($parts));

    // The migration to look up.
    $migration = $this->configuration['migration'];

    // Find the migrated item.
    $query = \Drupal::database()->select('migrate_map_' . $migration, 'm');
    $query->addField('m', 'destid1');
    $query->condition('m.sourceid1', $sourceid1);
    $nid = $query->execute()->fetchField();

    $values = [];

    // The referenced destination property. (@todo)
    $target_id = $this->configuration['target_id'];
    // @todo Use $target_id to get the target entity.
    $target = $row->getDestination()['nid'];
    // The entity type. (@todo)
    $type = $this->configuration['type'];
    // Find the existing values. @todo: Use $type.
    if ($node = \Drupal::entityTypeManager()->getStorage('node')->load($target)) {

      $values = $node->get($destination_property)->getValue();

    }

    // Append the looked up value as a target_id.
    $values[] = [
      'target_id' => $nid,
    ];

    return $values;
  }

}
