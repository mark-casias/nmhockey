
    const toggleExpand = document.getElementById('toggle-expand');
    const menu = document.getElementById('main-nav');
    if (menu) {
      const expandMenu = menu.getElementsByClassName('expand-sub');
      const hamburger = document.querySelector('.hamburger');

      // Mobile Menu Show/Hide.
      toggleExpand.addEventListener('click', (e) => {
        console.log(toggleExpand.classList);
        toggleExpand.classList.toggle('toggle-expand--open');
        menu.classList.toggle('main-nav--open');
        hamburger.classList.toggle('is-active');
        e.preventDefault();
      });

      // Expose mobile sub menu on click.
      Array.from(expandMenu).forEach((item) => {
        item.addEventListener('click', (e) => {
          const menuItem = e.currentTarget;
          const subMenu = menuItem.nextElementSibling;

          menuItem.classList.toggle('expand-sub--open');
          subMenu.classList.toggle('main-menu--sub-open');
          e.preventDefault();
        });
      });
    }
