<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'nmhockey_stats_penalty_stats' field type.
 *
 * @FieldType(
 *   id = "nmhockey_stats_penalty_stats",
 *   label = @Translation("Penalty Stats"),
 *   description = @Translation("Penalty Data"),
 *   default_widget = "nmhockey_stats_penalty_stats",
 *   default_formatter = "nmhockey_stats_penalty_stats_default",
 * )
 */
final class PenaltyStatsItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->penalty_period === NULL && $this->penalty_minute === NULL && $this->penalty_seconds === NULL && $this->penalty_type === NULL && $this->penalty_duration === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['penalty_period'] = DataDefinition::create('integer')
      ->setLabel(t('Period'));
    $properties['penalty_minute'] = DataDefinition::create('integer')
      ->setLabel(t('Minute'));
    $properties['penalty_seconds'] = DataDefinition::create('integer')
      ->setLabel(t('Seconds'));
    $properties['penalty_type'] = DataDefinition::create('string')
      ->setLabel(t('Type'));
    $properties['penalty_duration'] = DataDefinition::create('integer')
      ->setLabel(t('Duration'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['penalty_period']['AllowedValues'] = array_keys(PenaltyStatsItem::allowedPeriodValues());

    $options['penalty_period']['NotBlank'] = [];

    $options['penalty_minute']['AllowedValues'] = array_keys(PenaltyStatsItem::allowedMinuteValues());

    $options['penalty_minute']['NotBlank'] = [];

    $options['penalty_seconds']['AllowedValues'] = array_keys(PenaltyStatsItem::allowedSecondsValues());

    $options['penalty_seconds']['NotBlank'] = [];

    $options['penalty_type']['AllowedValues'] = array_keys(PenaltyStatsItem::allowedTypeValues());

    $options['penalty_type']['NotBlank'] = [];

    $options['penalty_duration']['AllowedValues'] = array_keys(PenaltyStatsItem::allowedDurationValues());

    $options['penalty_duration']['NotBlank'] = [];

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
      'penalty_period' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'penalty_minute' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'penalty_seconds' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'penalty_type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'penalty_duration' => [
        'type' => 'int',
        'size' => 'normal',
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

    $values['penalty_period'] = array_rand(self::allowedPeriodValues());

    $values['penalty_minute'] = array_rand(self::allowedMinuteValues());

    $values['penalty_seconds'] = array_rand(self::allowedSecondsValues());

    $values['penalty_type'] = array_rand(self::allowedTypeValues());

    $values['penalty_duration'] = array_rand(self::allowedDurationValues());

    return $values;
  }

  /**
   * Returns allowed values for 'penalty_period' sub-field.
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
   * Returns allowed values for 'penalty_minute' sub-field.
   */
  public static function allowedMinuteValues(): array {
    return array_combine(range(0, 20), range(0, 20));
  }

  /**
   * Returns allowed values for 'penalty_seconds' sub-field.
   */
  public static function allowedSecondsValues(): array {
    return array_combine(range(0, 60), range(0, 60));
  }

  /**
   * Returns allowed values for 'penalty_type' sub-field.
   */
  public static function allowedTypeValues(): array {
    // @todo Update allowed values.
    return [
      'minor' => t('Minor'),
      'major' => t('Major'),
      'match' => t('Match'),
    ];
  }

  /**
   * Returns allowed values for 'penalty_duration' sub-field.
   */
  public static function allowedDurationValues(): array {
    // @todo Update allowed values.
    return [
      2 => '2:00',
      4 => '4:00',
      5 => '5:00',
      10 => '10:00',
    ];
  }

}
