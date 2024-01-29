# NMHockey
Drupal version of NM Hockey

## Requirements

- [DDev](https://ddev.com/get-started/) 

## Getting started

- `ddev start`
- `ddev composer install`
- `ddev drush si minimal` - to be replaced with a snapshot later.
- `ddev drush config-set "system.site" uuid 2843a22b-1102-4b0d-b0ad-034f8427ac3b` - Updates the site UUID so the config imports without issue.
- `ddev drush cim` - one day this will work out of the box, but the snapshot will replace it anyway
- Site is available at [https://nmhockey.ddev.site](https://nmhockey.ddev.site)

## Setting up Storybook

- `cp web/sites/example.settings.local.php web/sites/default/settings.local.php`
- `ddev drush cr`
- `ddev yarn install`
- `ddev yarn storybook`
- Storybook instance is viewable at [https://nmhockey.ddev.site:6006](https://nmhockey.ddev.site:6006)

## Updating Storybook

Storybook is based on the [Storybook](https://www.drupal.org/project/storybook) module. All stories are kept in `web/themes/custom/nmhockey/stories` in a twig file that needs to be recompiled if you update any of the arguments or add new stories.

- `ddev drush storybook:generate-all-stories`
