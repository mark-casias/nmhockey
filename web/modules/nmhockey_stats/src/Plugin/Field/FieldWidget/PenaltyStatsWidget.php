<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\nmhockey_stats\Plugin\Field\FieldType\PenaltyStatsItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'nmhockey_stats_penalty_stats' field widget.
 *
 * @FieldWidget(
 *   id = "nmhockey_stats_penalty_stats",
 *   label = @Translation("Penalty Stats"),
 *   field_types = {"nmhockey_stats_penalty_stats"},
 * )
 */
final class PenaltyStatsWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['penalty_period'] = [
      '#type' => 'select',
      '#title' => $this->t('Period'),
      '#options' => ['' => $this->t('- Select a value -')] + PenaltyStatsItem::allowedPeriodValues(),
      '#default_value' => $items[$delta]->penalty_period ?? NULL,
    ];

    $element['penalty_minute'] = [
      '#type' => 'select',
      '#title' => $this->t('Minute'),
      '#options' => ['' => $this->t('- Select a value -')] + PenaltyStatsItem::allowedMinuteValues(),
      '#default_value' => $items[$delta]->penalty_minute ?? NULL,
    ];

    $element['penalty_seconds'] = [
      '#type' => 'select',
      '#title' => $this->t('Seconds'),
      '#options' => ['' => $this->t('- Select a value -')] + PenaltyStatsItem::allowedSecondsValues(),
      '#default_value' => $items[$delta]->penalty_seconds ?? NULL,
    ];

    $element['penalty_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#options' => ['' => $this->t('- Select a value -')] + PenaltyStatsItem::allowedTypeValues(),
      '#default_value' => $items[$delta]->penalty_type ?? NULL,
    ];

    $element['penalty_duration'] = [
      '#type' => 'select',
      '#title' => $this->t('Duration'),
      '#options' => ['' => $this->t('- Select a value -')] + PenaltyStatsItem::allowedDurationValues(),
      '#default_value' => $items[$delta]->penalty_duration ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'nmhockey-stats-penalty-stats-elements';
    $element['#attached']['library'][] = 'nmhockey_stats/nmhockey_stats_penalty_stats';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $error, array $form, FormStateInterface $form_state): array|bool {
    $element = parent::errorElement($element, $error, $form, $form_state);
    if ($element === FALSE) {
      return FALSE;
    }
    $error_property = explode('.', $error->getPropertyPath())[1];
    return $element[$error_property];
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state): array {
    foreach ($values as $delta => $value) {
      if ($value['penalty_period'] === '') {
        $values[$delta]['penalty_period'] = NULL;
      }
      if ($value['penalty_minute'] === '') {
        $values[$delta]['penalty_minute'] = NULL;
      }
      if ($value['penalty_seconds'] === '') {
        $values[$delta]['penalty_seconds'] = NULL;
      }
      if ($value['penalty_type'] === '') {
        $values[$delta]['penalty_type'] = NULL;
      }
      if ($value['penalty_duration'] === '') {
        $values[$delta]['penalty_duration'] = NULL;
      }
    }
    return $values;
  }

}
