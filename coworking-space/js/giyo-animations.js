/**
 * Use IntersectionObserver to insert classes for scrolling animations
 * and apply the 'animate-path-dash' class to visible SVG <path> elements
 */

// Create a new IntersectionObserver
const observer = new IntersectionObserver((entries) => {
  // Loop through all the entries
  entries.forEach((entry) => {
    // Check if the entry is intersecting with the viewport
    if (entry.isIntersecting) {
      // Add the "show" class to the entry's target element
      entry.target.classList.add('animated');
      // Add the same classes to the child elements with a slight delay
      setTimeout(() => {
        const childElements = entry.target.querySelectorAll('.to-animate');
        childElements.forEach((childElement) => {
          childElement.classList.add('animated');
        });
      }, 500);
      // Unobserve the entry to improve performance
      observer.unobserve(entry.target);

      // For the SVG <path> elements inside the .to-animate container
      const pathElements = entry.target.querySelectorAll('.progress-path-animate');
      pathElements.forEach((pathElement) => {
        if (!pathElement.dataset.animate) {
          pathElement.dataset.animate = "true";
          pathElement.classList.add('animate-path-dash');
          // Stop observing after the class is added to prevent unnecessary work
          observer.unobserve(pathElement);
        }
      });
    }
  });
}, {
  threshold: .25
});

// Get all the elements with the class "to-animate"
const elementsToAnimate = document.querySelectorAll('.to-animate');

// Observe each element
elementsToAnimate.forEach((element) => {
  observer.observe(element);
});


jQuery(function ($) {
  var $window = $(window);
  var $buttonTop = $('.button-top');
  var scrollTimer;

  $buttonTop.on('click', function () {
      $('html, body').animate({
          scrollTop: 0,
      }, 400);
  });

  $window.on('scroll', function () {
      clearTimeout(scrollTimer);
      scrollTimer = setTimeout(function() {
          if ($window.scrollTop() > 600) {
              $buttonTop.addClass('button-top-visible');
              $buttonTop.fadeIn();
          } else {
              $buttonTop.removeClass('button-top-visible');
              $buttonTop.fadeOut();
          }         
      }, 250);
  });  
  
});