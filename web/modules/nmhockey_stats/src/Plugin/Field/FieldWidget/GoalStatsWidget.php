<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\nmhockey_stats\Plugin\Field\FieldType\GoalStatsItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'nmhockey_stats_goal_stats' field widget.
 *
 * @FieldWidget(
 *   id = "nmhockey_stats_goal_stats",
 *   label = @Translation("Goal Stats"),
 *   field_types = {"nmhockey_stats_goal_stats"},
 * )
 */
final class GoalStatsWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['goal_period'] = [
      '#type' => 'select',
      '#title' => $this->t('Period'),
      '#options' => GoalStatsItem::allowedPeriodValues(),
      '#default_value' => $items[$delta]->goal_period ?? NULL,
    ];

    $element['goal_minute'] = [
      '#type' => 'select',
      '#title' => $this->t('Minute'),
      '#options' => GoalStatsItem::allowedMinuteValues(),
      '#default_value' => $items[$delta]->goal_minute ?? NULL,
    ];

    $element['goal_seconds'] = [
      '#type' => 'select',
      '#title' => $this->t('Seconds'),
      '#options' => GoalStatsItem::allowedSecondsValues(),
      '#default_value' => $items[$delta]->goal_seconds ?? NULL,
    ];

    $element['goal_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#options' => GoalStatsItem::allowedTypeValues(),
      '#default_value' => $items[$delta]->goal_type ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'nmhockey-stats-goal-stats-elements';
    $element['#attached']['library'][] = 'nmhockey_stats/nmhockey_stats_goal_stats';

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
      if ($value['goal_period'] === '') {
        $values[$delta]['goal_period'] = NULL;
      }
      if ($value['goal_minute'] === '') {
        $values[$delta]['goal_minute'] = NULL;
      }
      if ($value['goal_seconds'] === '') {
        $values[$delta]['goal_seconds'] = NULL;
      }
      if ($value['goal_type'] === '') {
        $values[$delta]['goal_type'] = NULL;
      }
    }
    return $values;
  }

}
