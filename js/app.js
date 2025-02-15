window.onload = () => {
  const filterLink = document.querySelectorAll(".filterLink");
  const body = document.querySelector("body");
  const parent = document.querySelector("main");
  const asideClose = document.querySelector(".close");
  const portfolioItems = document.querySelectorAll(".grid-item");
  const slideClass = "show-detail";
  const toggleSwitch = document.querySelector('.themeSwitcher input[type="checkbox"]');
  let currentTheme = localStorage.getItem("theme");
  const menuToggle = document.getElementById('menu-toggle');
  const navList = document.getElementById('nav-list');
  const themeToggleButton = document.getElementById('theme-toggle');
  const darkThemeClass = 'dark-theme';
  const lightThemeClass = 'light-theme';
  const filterButtons = document.querySelectorAll('.filter-button');
  const showItemsFilterClass = "showPortfolioItems";
  const hideItemsFilterClass = "hidePortfolioItems";
  const resetItemsFilterClass = "resetPortfolioItems";
  const currentFilterClass = "currentFilter";

  //Sticky nav
  window.addEventListener("scroll", () => {
    let throttleTimer;
    let navLinks = document.querySelectorAll("nav li a");
    let scrollPos = window.scrollY;
    const throttle = (callback, time) => {
      if (throttleTimer) return;
      throttleTimer = true;
      setTimeout(() => {
        callback();
        throttleTimer = false;
      }, time);
    };
    const updatePosition = () => {
      navLinks.forEach((link) => {
        let section = document.querySelector(link.hash);

        if (
          section.offsetTop < scrollPos + 60 &&
          section.offsetTop + section.offsetHeight > scrollPos + 60
        ) {
          link.classList.add("current");
        } else {
          link.classList.remove("current");
        }
      });
    };
    throttle(updatePosition, 100);
  });

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {

      filterButtons.forEach(btn => {
        btn.setAttribute('aria-pressed', 'false');
        btn.classList.remove(currentFilterClass);
      });

      button.setAttribute('aria-pressed', 'true');
      
      if(!button.classList.contains(currentFilterClass)) {
        button.classList.add(currentFilterClass);
      } else {
        button.classList.remove(currentFilterClass);
      }
      
      const filterValue = button.getAttribute('data-filter');
      console.log('filterValue:', filterValue);

      portfolioItems.forEach(item => {
        const itemCategories = item.getAttribute('data-category').split(' ');
        if ( filterValue === 'all' || itemCategories.includes(filterValue)) {
          item.style.animation = 'none';
          item.offsetHeight;
          item.style.animation = null; 
          item.classList.add(showItemsFilterClass);
          item.classList.remove(hideItemsFilterClass);
          item.classList.remove(resetItemsFilterClass);
        } else {
          item.classList.add(hideItemsFilterClass);
          item.classList.remove(showItemsFilterClass);
          item.classList.remove(resetItemsFilterClass);
        }
        console.log('itemCategories:', itemCategories);
      });
    });

    // Enable keyboard interaction
    button.addEventListener('keydown', (event) => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        button.click();
      }
    });
  });

  //Slide in Portfolio
  portfolioItems.forEach((elem) => {
    let itemLink = elem.querySelector(".gridItemLink");
    let itemDetailHTML = elem.querySelector(".details").innerHTML;
    let asideDetail = document.querySelector(".aside-details");

    itemLink.addEventListener("click", () => {
      asideDetail.innerHTML = itemDetailHTML;
      body.classList.add(slideClass);
    });

    itemLink.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        asideDetail.innerHTML = itemDetailHTML;
        body.classList.add(slideClass);
      }
    });

    parent.addEventListener("click", (e) => {
      if (!e.target.matches(".thumbnail")) {
        body.classList.remove(slideClass);
      } else {
        console.log("is grid a item");
      }
    });
  
    asideClose.addEventListener("click", () => {
      body.classList.remove(slideClass);
    });
  });

  //Print Year in Footer
  document.querySelector(".year").innerHTML = new Date().getFullYear();

  menuToggle.addEventListener('click', function () {
    const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', !isExpanded);
    navList.classList.toggle('open');
  });

  // Handle keyboard navigation
  menuToggle.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' || event.key === ' ') {
      event.preventDefault();
      menuToggle.click();
    }

    if (event.key === 'Escape') {  
      // Check if the menu is currently open
      if (menuToggle.getAttribute('aria-expanded') === 'true') {
        // Close the menu
        menuToggle.setAttribute('aria-expanded', 'false');
        navList.classList.remove('open');
  
        // Optionally, move focus back to the menu toggle button
        menuToggle.focus();
      }
    }    
  });

    //Theme Switcher

    if (currentTheme) {
      document.documentElement.setAttribute("data-theme", currentTheme);
    } else {
      document.documentElement.setAttribute("data-theme", "light");
      themeToggleButton.setAttribute('aria-pressed', 'false');
      themeToggleButton.setAttribute('aria-label', 'Activate dark theme');
      localStorage.setItem('theme', 'light');
    }
  
    themeToggleButton.addEventListener('click', function () {
      const isDarkTheme =  document.documentElement.getAttribute("data-theme") === "dark";
      if (isDarkTheme) {
        document.documentElement.setAttribute("data-theme", "light");
        themeToggleButton.setAttribute('aria-pressed', 'false');
        themeToggleButton.setAttribute('aria-label', 'Activate dark theme');
        localStorage.setItem('theme', 'light');
      } else {
        document.documentElement.setAttribute("data-theme", "dark");
        themeToggleButton.setAttribute('aria-pressed', 'true');
        themeToggleButton.setAttribute('aria-label', 'Activate light theme');
        localStorage.setItem('theme', 'dark');
      }
    });
  

  // Close menu when focus moves outside
  document.addEventListener('click', function (event) {
    if (!navList.contains(event.target) && !menuToggle.contains(event.target)) {
      navList.classList.remove('open');
      menuToggle.setAttribute('aria-expanded', 'false');
    }
  });

};

