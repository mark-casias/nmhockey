<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\nmhockey_stats\Plugin\Field\FieldType\GoalStatsItem;

/**
 * Plugin implementation of the 'nmhockey_stats_goal_stats_default' formatter.
 *
 * @FieldFormatter(
 *   id = "nmhockey_stats_goal_stats_default",
 *   label = @Translation("Default"),
 *   field_types = {"nmhockey_stats_goal_stats"},
 * )
 */
final class GoalStatsDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->goal_period) {
        $allowed_values = GoalStatsItem::allowedPeriodValues();
        $element[$delta]['goal_period'] = [
          '#type' => 'item',
          '#title' => $this->t('Period'),
          '#markup' => $allowed_values[$item->goal_period],
        ];
      }

      if ($item->goal_minute) {
        $allowed_values = GoalStatsItem::allowedMinuteValues();
        $element[$delta]['goal_minute'] = [
          '#type' => 'item',
          '#title' => $this->t('Minute'),
          '#markup' => $allowed_values[$item->goal_minute],
        ];
      }

      if ($item->goal_seconds) {
        $allowed_values = GoalStatsItem::allowedSecondsValues();
        $element[$delta]['goal_seconds'] = [
          '#type' => 'item',
          '#title' => $this->t('Seconds'),
          '#markup' => $allowed_values[$item->goal_seconds],
        ];
      }

      if ($item->goal_type) {
        $allowed_values = GoalStatsItem::allowedTypeValues();
        $element[$delta]['goal_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Type'),
          '#markup' => $allowed_values[$item->goal_type],
        ];
      }

    }

    return $element;
  }

}
