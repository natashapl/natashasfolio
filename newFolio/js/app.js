//Sticky nav
let throttleTimer;
let navLinks = document.querySelectorAll("nav li a");
const throttle = (callback, time) => {
  if (throttleTimer) return;
    throttleTimer = true;
    setTimeout(() => {
        callback();
        throttleTimer = false;
    }, time);
};

window.addEventListener("scroll", e => {
    let scrollPos = window.scrollY;
    const updatePosition = () => {      
        navLinks.forEach(link => {
            let section = document.querySelector(link.hash);
    
            if(section.offsetTop < scrollPos + 60 && section.offsetTop + section.offsetHeight > scrollPos + 60) {
                link.classList.add("current");
            } else {
                link.classList.remove("current");
            }

            console.log("section: ", section);
            console.log("scrollPos: ", scrollPos);
            console.log("offsetTop: ", section.offsetTop);
           // console.log("offsetHeight: ", section.offsetHeight);
        });
    };
    //updatePosition();
    throttle(updatePosition, 100);
});


//Filter
const grid = document.querySelector(".grid");
const filterLink = document.querySelectorAll(".filterLink");
const iso = new Isotope(grid, {
  itemSelector: ".grid-item",
  layoutMode: "fitRows",
});

filterLink.forEach((elem) => {
  elem.addEventListener("click", (e) => {
    let linkElem = e.target;
    let filterValue = linkElem.getAttribute("data-filter");

    filterLink.forEach((otherLink) => otherLink.classList.remove("selected"));
    linkElem.classList.toggle("selected");

    iso.arrange({
        filter: filterValue,
    });
  });
});

//Slide in Portfolio
const body = document.querySelector("body");
const parent = document.querySelector("main");
const aside = document.querySelector("#aside");
const asidetarget = document.querySelector(".aside-details");
const asideClose = document.querySelector(".close");
const portfolioItems = document.querySelectorAll(".grid-item");
const slideClass = "show-detail";
//const loadItemData = 

portfolioItems.forEach((elem) => {
  let itemLink = elem.querySelector(".gridItemLink");
  let itemDetailHTML = elem.querySelector(".details").innerHTML;
  let asideDetail = document.querySelector(".aside-details");

  itemLink.addEventListener("click", (e) => {
    asideDetail.innerHTML= itemDetailHTML;
    body.classList.add(slideClass);
  });
});

parent.addEventListener("click", (e) => {
  if (!e.target.matches(".thumbnail")) {
    body.classList.remove(slideClass);
  } else {
    console.log("is grid item")
  }
});

asideClose.addEventListener("click", (e) => {
  body.classList.remove(slideClass);
});

//Print Year in Footer
document.querySelector(".year").innerHTML = new Date().getFullYear();
