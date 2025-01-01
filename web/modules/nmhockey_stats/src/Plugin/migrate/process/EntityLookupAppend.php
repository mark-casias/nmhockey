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
    $player = $row->getSourceProperty('player');
    $parts = explode(", ", $player);
    $sourceid1 = implode(' ', array_reverse($parts));
    $target = $row->getDestination()['nid'];
    $migration = $this->configuration['migration'];

    // Find the migrated item.
    $query = \Drupal::database()->select('migrate_map_' . $migration, 'm');
    $query->addField('m', 'destid1');
    $query->condition('m.sourceid1', $sourceid1);
    $nid = $query->execute()->fetchField();

    // Find the existing values.
    if ($node = \Drupal::entityTypeManager()->getStorage('node')->load($target)) {

      $values = $node->get($destination_property)->getValue();

    }

    $values[] = [
      'target_id' => $nid,
    ];

    return $values;
  }

}
