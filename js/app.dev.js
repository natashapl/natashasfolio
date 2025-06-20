"use strict";

window.onload = function () {
  var filterLink = document.querySelectorAll(".filterLink");
  var body = document.querySelector("body");
  var parent = document.querySelector("main");
  var portfolioItems = document.querySelectorAll(".grid-item");
  var asideContainerPanel = document.querySelector(".asideContainer");
  var asideClose = document.querySelector(".close");
  var slideClass = "show-detail";
  var toggleSwitch = document.querySelector('.themeSwitcher input[type="checkbox"]');
  var currentTheme = localStorage.getItem("theme");
  var menuToggle = document.getElementById('menu-toggle');
  var navList = document.getElementById('nav-list');
  var themeToggleButton = document.getElementById('theme-toggle');
  var darkThemeClass = 'dark-theme';
  var lightThemeClass = 'light-theme';
  var filterButtons = document.querySelectorAll('.filter-button');
  var showItemsFilterClass = "showPortfolioItems";
  var hideItemsFilterClass = "hidePortfolioItems";
  var resetItemsFilterClass = "resetPortfolioItems";
  var currentFilterClass = "currentFilter"; // Deep linking functionality

  function openProjectByHash(hash) {
    // Remove the # from hash
    var projectId = hash.replace('#', ''); // Try data-project attribute first (more reliable), then CSS class with escaping

    var targetItem = document.querySelector("[data-project=\"".concat(projectId, "\"]"));

    if (!targetItem) {
      // For CSS class selector, escape if it starts with a digit
      var escapedProjectId = /^\d/.test(projectId) ? "\\".concat(projectId.charAt(0), " ").concat(projectId.slice(1)) : projectId;

      try {
        targetItem = document.querySelector(".".concat(escapedProjectId));
      } catch (e) {
        console.warn('Invalid CSS selector for project:', projectId);
      }
    }

    console.log('Looking for project:', projectId);
    console.log('Found target item:', targetItem);

    if (targetItem) {
      var itemLink = targetItem.querySelector(".gridItemLink");
      console.log('Found item link:', itemLink);

      if (itemLink) {
        // Scroll to portfolio section first
        var portfolioSection = document.getElementById('portfolio');

        if (portfolioSection) {
          portfolioSection.scrollIntoView({
            behavior: 'smooth'
          });
        } // Small delay to ensure scroll completes before opening


        setTimeout(function () {
          // Trigger the portfolio item opening manually instead of click
          triggerPortfolioOpen(targetItem); // Update URL without triggering scroll

          history.replaceState(null, null, hash);
        }, 800);
        return true;
      }
    }

    console.log('Project not found:', projectId);
    return false;
  } // Helper function to manually trigger portfolio opening


  function triggerPortfolioOpen(elem) {
    var itemLink = elem.querySelector(".gridItemLink");
    var itemDetailHTML = elem.querySelector(".details").innerHTML;
    var asideDetail = document.querySelector(".aside-details");
    var detailHeader = elem.querySelector("h4");

    if (itemLink && itemDetailHTML && asideDetail && detailHeader) {
      var asidePanelId = itemLink.getAttribute('aria-controls');
      itemLink.setAttribute('aria-expanded', 'true');
      asideDetail.innerHTML = itemDetailHTML;
      asideContainerPanel.id = asidePanelId;
      body.classList.add(slideClass);
      var asidePanel = document.getElementById(asidePanelId);
      asidePanel.setAttribute('aria-hidden', 'false');
      asidePanel.setAttribute("aria-labelledby", detailHeader.id);
      asidePanel.classList.add('visible');
      asidePanel.focus();
    }
  } // Check for hash on page load


  function checkInitialHash() {
    var hash = window.location.hash;
    console.log('Initial hash:', hash);

    if (hash && hash !== '#home' && hash !== '#portfolio' && hash !== '#about' && hash !== '#skills' && hash !== '#testimonials' && hash !== '#contact') {
      // This appears to be a project hash, try to open it
      setTimeout(function () {
        openProjectByHash(hash);
      }, 500); // Longer delay for initial load
    }
  } // Listen for hash changes (back/forward navigation)


  window.addEventListener('hashchange', function () {
    var hash = window.location.hash; // Close any open project first

    closePortfolio(); // If it's a project hash, open it

    if (hash && hash !== '#home' && hash !== '#portfolio' && hash !== '#about' && hash !== '#skills' && hash !== '#testimonials' && hash !== '#contact') {
      setTimeout(function () {
        openProjectByHash(hash);
      }, 300);
    }
  }); //Sticky nav

  window.addEventListener("scroll", function () {
    var throttleTimer;
    var navLinks = document.querySelectorAll("nav li a");
    var scrollPos = window.scrollY;

    var throttle = function throttle(callback, time) {
      if (throttleTimer) return;
      throttleTimer = true;
      setTimeout(function () {
        callback();
        throttleTimer = false;
      }, time);
    };

    var updatePosition = function updatePosition() {
      // Don't update navigation if a project is currently open
      if (body.classList.contains(slideClass)) {
        return;
      }

      navLinks.forEach(function (link) {
        if (link.hash) {
          var section = document.querySelector(link.hash);

          if (section) {
            if (section.offsetTop < scrollPos + 60 && section.offsetTop + section.offsetHeight > scrollPos + 60) {
              link.classList.add("current"); // Only update URL if it's not already a project hash

              var currentHash = window.location.hash;

              if (!currentHash || !isProjectHash(currentHash)) {
                history.replaceState(null, null, link.hash);
              }
            } else {
              link.classList.remove("current");
            }
          }
        }
      });
    };

    throttle(updatePosition, 100);
  }); // Helper function to check if hash is a project hash

  function isProjectHash(hash) {
    var projectHash = hash.replace('#', '');
    var knownSections = ['home', 'portfolio', 'about', 'skills', 'testimonials', 'contact'];
    return !knownSections.includes(projectHash);
  }

  filterButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      filterButtons.forEach(function (btn) {
        btn.setAttribute('aria-pressed', 'false');
        btn.classList.remove(currentFilterClass);
      });
      button.setAttribute('aria-pressed', 'true');

      if (!button.classList.contains(currentFilterClass)) {
        button.classList.add(currentFilterClass);
      } else {
        button.classList.remove(currentFilterClass);
      }

      var filterValue = button.getAttribute('data-filter');
      console.log('filterValue:', filterValue);
      portfolioItems.forEach(function (item) {
        var itemCategories = item.getAttribute('data-category').split(' ');

        if (filterValue === 'all' || itemCategories.includes(filterValue)) {
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
    }); // Enable keyboard interaction

    button.addEventListener('keydown', function (event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        button.click();
      }
    });
  });

  function closePortfolio() {
    body.classList.remove(slideClass);
    asideContainerPanel.setAttribute('aria-hidden', 'true');
    asideContainerPanel.classList.remove('visible'); // Update aria-expanded

    var associatedItem = document.querySelector("[aria-controls=\"".concat(asideContainerPanel.id, "\"]"));

    if (associatedItem) {
      associatedItem.setAttribute('aria-expanded', 'false'); // Return focus to the associated portfolio item

      associatedItem.focus();
    } // Always return to #portfolio when closing a project


    history.replaceState(null, null, '#portfolio');
  } // Helper function to determine current section


  function getCurrentSection() {
    var sections = ['home', 'portfolio', 'about', 'skills', 'testimonials', 'contact'];
    var scrollPos = window.scrollY + 100; // Add offset for header

    for (var _i = 0, _sections = sections; _i < _sections.length; _i++) {
      var sectionName = _sections[_i];
      var section = document.getElementById(sectionName);

      if (section && scrollPos >= section.offsetTop && scrollPos < section.offsetTop + section.offsetHeight) {
        return sectionName;
      }
    }

    return 'home'; // Default
  } //Slide in Portfolio


  portfolioItems.forEach(function (elem) {
    var itemLink = elem.querySelector(".gridItemLink");
    var itemDetailHTML = elem.querySelector(".details").innerHTML;
    var asideDetail = document.querySelector(".aside-details");
    var detailHeader = elem.querySelector("h4");

    function openPortfolioItem() {
      var isExpanded = itemLink.getAttribute('aria-expanded') === 'true';
      var asidePanelId = itemLink.getAttribute('aria-controls');
      itemLink.focus();
      itemLink.setAttribute('aria-expanded', !isExpanded);
      asideDetail.innerHTML = itemDetailHTML;
      asideContainerPanel.id = asidePanelId;
      body.classList.add(slideClass);
      var asidePanel = document.getElementById(asidePanelId);
      asidePanel.setAttribute('aria-hidden', 'false');
      asidePanel.setAttribute("aria-labelledby", detailHeader.id);
      asidePanel.classList.add('visible');
      asidePanel.focus(); // Update URL with project hash (use data-project if available, fallback to class)

      var projectId = elem.getAttribute('data-project') || elem.classList[0];
      history.replaceState(null, null, "#".concat(projectId));
    }

    itemLink.addEventListener('click', function (event) {
      event.preventDefault();
      openPortfolioItem();
    });
    itemLink.addEventListener('keydown', function (event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        openPortfolioItem();
      }
    });
    parent.addEventListener("click", function (e) {
      if (!e.target.matches(".thumbnail")) {
        closePortfolio();
        console.log("parent clicked");
      }
    });
    asideClose.addEventListener("click", function () {
      closePortfolio();
    });
  }); //Print Year in Footer

  document.querySelector(".year").innerHTML = new Date().getFullYear();
  menuToggle.addEventListener('click', function () {
    var isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', !isExpanded);
    navList.classList.toggle('open');
  }); // Handle keyboard navigation

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
        navList.classList.remove('open'); // Optionally, move focus back to the menu toggle button

        menuToggle.focus();
      }
    }
  }); //Theme Switcher

  if (currentTheme) {
    document.documentElement.setAttribute("data-theme", currentTheme);
  } else {
    document.documentElement.setAttribute("data-theme", "light");
    themeToggleButton.setAttribute('aria-pressed', 'false');
    themeToggleButton.setAttribute('aria-label', 'Activate dark theme');
    localStorage.setItem('theme', 'light');
  }

  themeToggleButton.addEventListener('click', function () {
    var isDarkTheme = document.documentElement.getAttribute("data-theme") === "dark";

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
  }); // Close menu when focus moves outside

  document.addEventListener('click', function (event) {
    if (!navList.contains(event.target) && !menuToggle.contains(event.target)) {
      navList.classList.remove('open');
      menuToggle.setAttribute('aria-expanded', 'false');
    }
  }); // Close panel with Escape key

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      closePortfolio();
    }
  }); // Initialize deep linking after everything is set up

  setTimeout(checkInitialHash, 100);
};