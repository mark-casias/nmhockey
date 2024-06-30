<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'nmhockey_stats_goal_stats' field type.
 *
 * @FieldType(
 *   id = "nmhockey_stats_goal_stats",
 *   label = @Translation("Goal Stats"),
 *   description = @Translation("Goal Data"),
 *   default_widget = "nmhockey_stats_goal_stats",
 *   default_formatter = "nmhockey_stats_goal_stats_default",
 * )
 */
final class GoalStatsItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->goal_period === NULL && $this->goal_minute === NULL && $this->goal_seconds === NULL && $this->goal_type === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['goal_period'] = DataDefinition::create('integer')
      ->setLabel(t('Period'));
    $properties['goal_minute'] = DataDefinition::create('integer')
      ->setLabel(t('Minute'));
    $properties['goal_seconds'] = DataDefinition::create('integer')
      ->setLabel(t('Seconds'));
    $properties['goal_type'] = DataDefinition::create('string')
      ->setLabel(t('Type'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['goal_period']['AllowedValues'] = array_keys(GoalStatsItem::allowedPeriodValues());

    $options['goal_period']['NotBlank'] = [];

    $options['goal_minute']['AllowedValues'] = array_keys(GoalStatsItem::allowedMinuteValues());

    $options['goal_minute']['NotBlank'] = [];

    $options['goal_seconds']['AllowedValues'] = array_keys(GoalStatsItem::allowedSecondsValues());

    $options['goal_seconds']['NotBlank'] = [];

    $options['goal_type']['AllowedValues'] = array_keys(GoalStatsItem::allowedTypeValues());

    $options['goal_type']['NotBlank'] = [];

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
      'goal_period' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'goal_minute' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'goal_seconds' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'goal_type' => [
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

    $values['goal_period'] = array_rand(self::allowedPeriodValues());
    $values['goal_minute'] = array_rand(self::allowedMinuteValues());
    $values['goal_seconds'] = array_rand(self::allowedSecondsValues());
    $values['goal_type'] = array_rand(self::allowedTypeValues());

    return $values;
  }

  /**
   * Returns allowed values for 'goal_period' sub-field.
   */
  public static function allowedPeriodValues(): array {
    return [
      1 => 1,
      2 => 2,
      3 => 3,
      4 => 'OT',
    ];
  }

  /**
   * Returns allowed values for 'goal_minute' sub-field.
   */
  public static function allowedMinuteValues(): array {
    return array_reverse(array_combine(range(0, 20), range(0, 20)), TRUE);
  }

  /**
   * Returns allowed values for 'goal_seconds' sub-field.
   */
  public static function allowedSecondsValues(): array {
    return array_reverse(array_combine(range(0, 60), range(0, 60)), TRUE);
  }

  /**
   * Returns allowed values for 'goal_type' sub-field.
   */
  public static function allowedTypeValues(): array {
    return [
      'Even Strength' => 'Even Strength',
      'Power Play' => 'Power Play',
      'Short Handed' => 'Short Handed',
      'Empty Net' => 'Empty Net',
    ];
  }

}
