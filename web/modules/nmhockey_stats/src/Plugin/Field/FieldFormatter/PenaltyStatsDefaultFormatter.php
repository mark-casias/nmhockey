<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\nmhockey_stats\Plugin\Field\FieldType\PenaltyStatsItem;

/**
 * Plugin implementation of the 'nmhockey_stats_penalty_stats_default' formatter.
 *
 * @FieldFormatter(
 *   id = "nmhockey_stats_penalty_stats_default",
 *   label = @Translation("Default"),
 *   field_types = {"nmhockey_stats_penalty_stats"},
 * )
 */
final class PenaltyStatsDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->penalty_period) {
        $allowed_values = PenaltyStatsItem::allowedPeriodValues();
        $element[$delta]['penalty_period'] = [
          '#type' => 'item',
          '#title' => $this->t('Period'),
          '#markup' => $allowed_values[$item->penalty_period],
        ];
      }

      if ($item->penalty_minute) {
        $allowed_values = PenaltyStatsItem::allowedMinuteValues();
        $element[$delta]['penalty_minute'] = [
          '#type' => 'item',
          '#title' => $this->t('Minute'),
          '#markup' => $allowed_values[$item->penalty_minute],
        ];
      }

      if ($item->penalty_seconds) {
        $allowed_values = PenaltyStatsItem::allowedSecondsValues();
        $element[$delta]['penalty_seconds'] = [
          '#type' => 'item',
          '#title' => $this->t('Seconds'),
          '#markup' => $allowed_values[$item->penalty_seconds],
        ];
      }

      if ($item->penalty_type) {
        $allowed_values = PenaltyStatsItem::allowedTypeValues();
        $element[$delta]['penalty_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Type'),
          '#markup' => $allowed_values[$item->penalty_type],
        ];
      }

      if ($item->penalty_duration) {
        $allowed_values = PenaltyStatsItem::allowedDurationValues();
        $element[$delta]['penalty_duration'] = [
          '#type' => 'item',
          '#title' => $this->t('Duration'),
          '#markup' => $allowed_values[$item->penalty_duration],
        ];
      }

    }

    return $element;
  }

}
