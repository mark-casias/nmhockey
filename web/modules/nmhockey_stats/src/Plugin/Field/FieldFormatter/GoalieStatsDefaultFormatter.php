<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\nmhockey_stats\Plugin\Field\FieldType\GoalieStatsItem;

/**
 * Plugin implementation of the 'nmhockey_stats_goalie_stats_default' formatter.
 *
 * @FieldFormatter(
 *   id = "nmhockey_stats_goalie_stats_default",
 *   label = @Translation("Default"),
 *   field_types = {"nmhockey_stats_goalie_stats"},
 * )
 */
final class GoalieStatsDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->shots_against) {
        $element[$delta]['shots_against'] = [
          '#type' => 'item',
          '#title' => $this->t('Shots Against'),
          '#markup' => $item->shots_against,
        ];
      }

      if ($item->goals_against) {
        $element[$delta]['goals_against'] = [
          '#type' => 'item',
          '#title' => $this->t('Goals Against'),
          '#markup' => $item->goals_against,
        ];
      }

      if ($item->w_l_otl) {
        $allowed_values = GoalieStatsItem::allowedWlotlValues();
        $element[$delta]['w_l_otl'] = [
          '#type' => 'item',
          '#title' => $this->t('W/L/OTL'),
          '#markup' => $allowed_values[$item->w_l_otl],
        ];
      }

    }

    return $element;
  }

}
