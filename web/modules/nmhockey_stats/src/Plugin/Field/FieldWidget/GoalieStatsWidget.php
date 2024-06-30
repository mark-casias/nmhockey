<?php

declare(strict_types=1);

namespace Drupal\nmhockey_stats\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\nmhockey_stats\Plugin\Field\FieldType\GoalieStatsItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'nmhockey_stats_goalie_stats' field widget.
 *
 * @FieldWidget(
 *   id = "nmhockey_stats_goalie_stats",
 *   label = @Translation("Goalie Stats"),
 *   field_types = {"nmhockey_stats_goalie_stats"},
 * )
 */
final class GoalieStatsWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['shots_against'] = [
      '#type' => 'number',
      '#title' => $this->t('Shots Against'),
      '#default_value' => $items[$delta]->shots_against ?? NULL,
    ];

    $element['goals_against'] = [
      '#type' => 'number',
      '#title' => $this->t('Goals Against'),
      '#default_value' => $items[$delta]->goals_against ?? NULL,
    ];

    $element['w_l_otl'] = [
      '#type' => 'select',
      '#title' => $this->t('W/L/OTL'),
      '#options' => ['' => $this->t('- None -')] + GoalieStatsItem::allowedWlotlValues(),
      '#default_value' => $items[$delta]->w_l_otl ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'nmhockey-stats-goalie-stats-elements';
    $element['#attached']['library'][] = 'nmhockey_stats/nmhockey_stats_goalie_stats';

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
      if ($value['shots_against'] === '') {
        $values[$delta]['shots_against'] = NULL;
      }
      if ($value['goals_against'] === '') {
        $values[$delta]['goals_against'] = NULL;
      }
      if ($value['w_l_otl'] === '') {
        $values[$delta]['w_l_otl'] = NULL;
      }
    }
    return $values;
  }

}
