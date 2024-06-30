<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'nmhockey_stats_goalie_stats' field type.
 *
 * @FieldType(
 *   id = "nmhockey_stats_goalie_stats",
 *   label = @Translation("Goalie Stats"),
 *   description = @Translation("Some description."),
 *   default_widget = "nmhockey_stats_goalie_stats",
 *   default_formatter = "nmhockey_stats_goalie_stats_default",
 * )
 */
final class GoalieStatsItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->shots_against === NULL && $this->goals_against === NULL && $this->w_l_otl === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['shots_against'] = DataDefinition::create('integer')
      ->setLabel(t('Shots Against'));
    $properties['goals_against'] = DataDefinition::create('integer')
      ->setLabel(t('Goals Against'));
    $properties['w_l_otl'] = DataDefinition::create('string')
      ->setLabel(t('W/L/OTL'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['w_l_otl']['AllowedValues'] = array_keys(GoalieStatsItem::allowedWlotlValues());

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    // @todo Add more constraints here.
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {

    $columns = [
      'shots_against' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'goals_against' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'w_l_otl' => [
        'type' => 'varchar',
        'length' => 255,
      ],
    ];

    $schema = [
      'columns' => $columns,
      // @DCG Add indexes here if necessary.
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition): array {

    $random = new Random();

    $values['shots_against'] = mt_rand(0, 100);

    $values['goals_against'] = mt_rand(0, 10);

    $values['w_l_otl'] = array_rand(self::allowedWlotlValues());

    return $values;
  }

  /**
   * Returns allowed values for 'w_l_otl' sub-field.
   */
  public static function allowedWlotlValues(): array {
    return [
      'win' => 'Win',
      'loss' => 'Loss',
      'otl' => 'Overtime Loss',
    ];
  }

}
