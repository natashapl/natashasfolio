window.onload = () => {
  const body = document.querySelector("body");
  const parent = document.querySelector("main");
  const portfolioItems = document.querySelectorAll(".grid-item");
  const asideContainerPanel = document.querySelector(".asideContainer");
  const asideClose = document.querySelector(".close");
  const slideClass = "show-detail";
  let currentTheme = localStorage.getItem("theme");
  const menuToggle = document.getElementById('menu-toggle');
  const navList = document.getElementById('nav-list');
  const themeToggleButton = document.getElementById('theme-toggle');
  const filterButtons = document.querySelectorAll('.filter-button');
  const showItemsFilterClass = "showPortfolioItems";
  const hideItemsFilterClass = "hidePortfolioItems";
  const resetItemsFilterClass = "resetPortfolioItems";
  const currentFilterClass = "currentFilter";

  // Deep linking functionality
  function openProjectByHash(hash) {
    // Remove the # from hash
    const projectId = hash.replace('#', '');
    
    // Try data-project attribute first (more reliable), then CSS class with escaping
    let targetItem = document.querySelector(`[data-project="${projectId}"]`);
    
    if (!targetItem) {
      // For CSS class selector, escape if it starts with a digit
      const escapedProjectId = /^\d/.test(projectId) ? `\\${projectId.charAt(0)} ${projectId.slice(1)}` : projectId;
      try {
        targetItem = document.querySelector(`.${escapedProjectId}`);
      } catch (e) {
        console.warn('Invalid CSS selector for project:', projectId);
      }
    }
    
    console.log('Looking for project:', projectId);
    console.log('Found target item:', targetItem);
    
    if (targetItem) {
      const itemLink = targetItem.querySelector(".gridItemLink");
      console.log('Found item link:', itemLink);
      
      if (itemLink) {
        // Scroll to portfolio section first
        const portfolioSection = document.getElementById('portfolio');
        if (portfolioSection) {
          portfolioSection.scrollIntoView({ behavior: 'smooth' });
        }
        
        // Small delay to ensure scroll completes before opening
        setTimeout(() => {
          // Trigger the portfolio item opening manually instead of click
          triggerPortfolioOpen(targetItem);
          
          // Update URL without triggering scroll
          history.replaceState(null, null, hash);
        }, 800);
        
        return true;
      }
    }
    console.log('Project not found:', projectId);
    return false;
  }

  // Helper function to manually trigger portfolio opening
  function triggerPortfolioOpen(elem) {
    let itemLink = elem.querySelector(".gridItemLink");
    let itemDetailHTML = elem.querySelector(".details").innerHTML;
    let asideDetail = document.querySelector(".aside-details");
    let detailHeader = elem.querySelector("h4");

    if (itemLink && itemDetailHTML && asideDetail && detailHeader) {
      const asidePanelId = itemLink.getAttribute('aria-controls');

      itemLink.setAttribute('aria-expanded', 'true');
      asideDetail.innerHTML = itemDetailHTML;
      asideContainerPanel.id = asidePanelId;
      body.classList.add(slideClass);

      const asidePanel = document.getElementById(asidePanelId);

      asidePanel.setAttribute('aria-hidden', 'false');
      asidePanel.setAttribute("aria-labelledby", detailHeader.id);
      asidePanel.classList.add('visible');
      
      asidePanel.focus();
    }
  }

  // Check for hash on page load
  function checkInitialHash() {
    const hash = window.location.hash;
    console.log('Initial hash:', hash);
    
    if (hash && hash !== '#home' && hash !== '#portfolio' && hash !== '#about' && 
        hash !== '#skills' && hash !== '#testimonials' && hash !== '#contact') {
      // This appears to be a project hash, try to open it
      setTimeout(() => {
        openProjectByHash(hash);
      }, 500); // Longer delay for initial load
    }
  }

  // Listen for hash changes (back/forward navigation)
  window.addEventListener('hashchange', () => {
    const hash = window.location.hash;
    
    // Close any open project first
    closePortfolio();
    
    // If it's a project hash, open it
    if (hash && hash !== '#home' && hash !== '#portfolio' && hash !== '#about' && 
        hash !== '#skills' && hash !== '#testimonials' && hash !== '#contact') {
      setTimeout(() => {
        openProjectByHash(hash);
      }, 300);
    }
  });

// Sticky nav (fixed throttle + avoid replaceState spam)
let isThrottled = false;
let lastSectionHash = null;

function updateStickyNav() {
  // Don’t update nav when a project is open
  if (body.classList.contains(slideClass)) return;

  const navLinks = document.querySelectorAll("nav li a");
  const scrollPos = window.scrollY + 60;

  for (const link of navLinks) {
    if (!link.hash) continue;

    const section = document.querySelector(link.hash);
    if (!section) continue;

    const inView =
      section.offsetTop < scrollPos &&
      section.offsetTop + section.offsetHeight > scrollPos;

    link.classList.toggle("current", inView);

    if (inView) {
      // Only write the hash if it actually changed
      if (lastSectionHash !== link.hash) {
        lastSectionHash = link.hash;

        // Don’t override a project hash
        const currentHash = window.location.hash;
        if (!currentHash || !isProjectHash(currentHash)) {
          history.replaceState(null, null, link.hash);
        }
      }
    }
  }
}

window.addEventListener("scroll", () => {
  if (isThrottled) return;

  isThrottled = true;
  setTimeout(() => {
    updateStickyNav();
    isThrottled = false;
  }, 100);
});


  // Helper function to check if hash is a project hash
  function isProjectHash(hash) {
    const projectHash = hash.replace('#', '');
    const knownSections = ['home', 'portfolio', 'about', 'skills', 'testimonials', 'contact'];
    return !knownSections.includes(projectHash);
  }

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

  function closePortfolio() {
    body.classList.remove(slideClass);
    asideContainerPanel.setAttribute('aria-hidden', 'true');
    asideContainerPanel.classList.remove('visible');

    // Update aria-expanded
    const associatedItem = document.querySelector(`[aria-controls="${asideContainerPanel.id}"]`);
    if (associatedItem) {
      associatedItem.setAttribute('aria-expanded', 'false');
      // Return focus to the associated portfolio item
      associatedItem.focus();
    }
    
    // Always return to #portfolio when closing a project
    history.replaceState(null, null, '#portfolio');
  }

  // Helper function to determine current section
  function getCurrentSection() {
    const sections = ['home', 'portfolio', 'about', 'skills', 'testimonials', 'contact'];
    const scrollPos = window.scrollY + 100; // Add offset for header
    
    for (const sectionName of sections) {
      const section = document.getElementById(sectionName);
      if (section && scrollPos >= section.offsetTop && 
          scrollPos < section.offsetTop + section.offsetHeight) {
        return sectionName;
      }
    }
    return 'home'; // Default
  }

  //Slide in Portfolio
  portfolioItems.forEach((elem) => {
    let itemLink = elem.querySelector(".gridItemLink");
    let itemDetailHTML = elem.querySelector(".details").innerHTML;
    let asideDetail = document.querySelector(".aside-details");
    let detailHeader = elem.querySelector("h4");

    function openPortfolioItem() {
      const isExpanded = itemLink.getAttribute('aria-expanded') === 'true';
      const asidePanelId = itemLink.getAttribute('aria-controls');

      itemLink.focus();
      itemLink.setAttribute('aria-expanded', !isExpanded);
      asideDetail.innerHTML = itemDetailHTML;
      asideContainerPanel.id = asidePanelId;
      body.classList.add(slideClass);

      const asidePanel = document.getElementById(asidePanelId);

      asidePanel.setAttribute('aria-hidden', 'false');
      asidePanel.setAttribute("aria-labelledby", detailHeader.id);
      asidePanel.classList.add('visible');
      
      asidePanel.focus();
      
      // Update URL with project hash (use data-project if available, fallback to class)
      const projectId = elem.getAttribute('data-project') || elem.classList[0];
      history.replaceState(null, null, `#${projectId}`);
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

    // Close when clicking outside a portfolio item link or the aside panel
    parent.addEventListener("click", (e) => {
      if (!body.classList.contains(slideClass)) return;

      // Don’t close when clicking inside the aside panel
      if (asideContainerPanel.contains(e.target)) return;

      // Don’t close when clicking the portfolio item link itself
      if (e.target.closest(".gridItemLink")) return;

      closePortfolio();
    });

    asideClose.addEventListener("click", () => closePortfolio());
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

  // Close panel with Escape key
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      closePortfolio();
    }
  });

  // Initialize deep linking after everything is set up
  setTimeout(checkInitialHash, 100);

// Form submission handler
(function() {
  const contactForm = document.getElementById('contactForm');
  const formStatus = document.getElementById('formStatus');
  
  if (!contactForm || !formStatus) {
    console.error('Form elements not found!');
    return;
  }
  
  contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    e.stopPropagation();
    
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending...';
    
    const formData = {
      name: document.getElementById('name').value,
      email: document.getElementById('email').value,
      message: document.getElementById('message').value,
      botField: document.querySelector('input[name="botField"]').value
    };
    
    try {
      await fetch('https://script.google.com/macros/s/AKfycbxPNIDKm93naZY5rPzibSLVpAfUV9cKzEaS_uPhcytB48aYJ6diwNEmsEjdmzshMlbt/exec', {
        method: 'POST',
        mode: 'no-cors',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      });
      
      formStatus.style.display = 'block';
      formStatus.textContent = 'Thanks! Your message has been sent.';
      contactForm.reset();
      
    } catch (error) {
      console.error('Fetch error:', error);
      formStatus.style.display = 'block';
      formStatus.style.color = 'red';
      formStatus.textContent = 'Oops! Something went wrong. Please try again.';
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Send Message';
    }
  });
  
  console.log('Form event listener attached!');
})();
};