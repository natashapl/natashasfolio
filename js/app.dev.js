"use strict";

window.onload = function () {
  var filterLink = document.querySelectorAll(".filterLink");
  var body = document.querySelector("body");
  var parent = document.querySelector("main");
  var asideClose = document.querySelector(".close");
  var portfolioItems = document.querySelectorAll(".grid-item");
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
  var currentFilterClass = "currentFilter"; //Sticky nav

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
      navLinks.forEach(function (link) {
        var section = document.querySelector(link.hash);

        if (section.offsetTop < scrollPos + 60 && section.offsetTop + section.offsetHeight > scrollPos + 60) {
          link.classList.add("current");
        } else {
          link.classList.remove("current");
        }
      });
    };

    throttle(updatePosition, 100);
  });
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
  }); //Slide in Portfolio

  portfolioItems.forEach(function (elem) {
    var itemLink = elem.querySelector(".gridItemLink");
    var itemDetailHTML = elem.querySelector(".details").innerHTML;
    var asideDetail = document.querySelector(".aside-details");
    itemLink.addEventListener("click", function () {
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
    parent.addEventListener("click", function (e) {
      if (!e.target.matches(".thumbnail")) {
        body.classList.remove(slideClass);
      } else {
        console.log("is grid a item");
      }
    });
    asideClose.addEventListener("click", function () {
      body.classList.remove(slideClass);
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
  });
};