
import siteHeader from './site-header/site-header.twig';

import breadcrumbData from '../../02-molecules/menus/breadcrumbs/breadcrumbs.yml';
import mainMenuData from '../../02-molecules/menus/main-menu/main-menu.yml';

import '../../02-molecules/menus/main-menu/main-menu';

/**
 * Storybook Definition.
 */
export default {
  title: 'Organisms/Site',
  parameters: {
    layout: 'fullscreen',
  },
};


export const header = () =>
  siteHeader({
    ...breadcrumbData,
    ...mainMenuData,
  });
