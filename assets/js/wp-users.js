jQuery(function ($) {
  let typingTimer;
  const delay = 500; // milliseconds
  // Initialize View from LocalStorage
  const savedView = localStorage.getItem('listivo_users_view');
  if (savedView === 'list') {
      $("#wp-users-result").addClass('list-view');
      $(".listivo-view-btn[data-view='list']").addClass('active');
      $(".listivo-view-btn[data-view='grid']").removeClass('active');
  }

  // Function to trigger AJAX
  function fetchUsers() {
    const formData = $("#wp-user-search-form").serialize();
    
    // Update URL without reloading
    const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + formData;
    window.history.pushState({path: newUrl}, '', newUrl);

    $.ajax({
      url: window.location.href, // This will now include the query params if we want, or we can just send data
      type: "GET",
      data: formData,
      beforeSend: function() {
          $("#wp-users-result").css("opacity", "0.5");
      },
      success: function (response) {
        const html = $(response).find("#wp-users-result").html();
        const pagination = $(response).find(".lst-pagination").length ? $(response).find(".lst-pagination")[0].outerHTML : '';
        
        $("#wp-users-result").html(html).css("opacity", "1");
        
        // Update pagination if it exists outside the result container, or ensure it's part of the replaced content.
        // In the template, pagination is outside #wp-users-result. We need to update it too.
        if ($(".lst-pagination").length) {
            $(".lst-pagination").replaceWith(pagination);
        } else if (pagination) {
            $("#wp-users-result").after(pagination);
        }
      },
      error: function() {
          $("#wp-users-result").css("opacity", "1");
      }
    });
  }

  // Text Inputs (Debounced)
  $("#wp-user-search-form input[type='text']").on("input", function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(fetchUsers, delay);
  });

  // Select Inputs (Immediate)
  $("#wp-user-search-form select").on("change", function () {
    fetchUsers();
  });
  
  // Prevent form submission on enter
  $("#wp-user-search-form").on("submit", function(e) {
      e.preventDefault();
      fetchUsers();
  });

  // View Toggle Logic
  $(".listivo-view-btn").on("click", function() {
      const view = $(this).data('view');
      
      $(".listivo-view-btn").removeClass('active');
      $(this).addClass('active');

      if (view === 'list') {
          $("#wp-users-result").addClass('list-view');
          localStorage.setItem('listivo_users_view', 'list');
      } else {
          $("#wp-users-result").removeClass('list-view');
          localStorage.setItem('listivo_users_view', 'grid');
      }
  });

  // Phone Reveal Logic (Delegated for AJAX content)
  $(document).on("click", ".listivo-user-phone-reveal", function() {
      const fullPhone = $(this).data("full-phone");
      const $textSpan = $(this).find(".listivo-user-phone-text");
      const $icon = $(this).find(".listivo-phone-eye-icon");

      if (fullPhone) {
          $textSpan.text(fullPhone);
          $icon.hide(); // Hide the eye icon after reveal
          $(this).css("cursor", "default"); // Change cursor
      }
  });

  var stats = siteData;

  function animateStat($el, value, suffix) {
      if (!$el.length) return;
      
      var cleanVal = String(value).replace(/,/g, '');
      var endNum = parseInt(cleanVal, 10);
      var suffixStr = suffix || '';
      
      if (isNaN(endNum)) {
          // Fallback if not a number
          $el.contents().first().replaceWith(value + suffixStr);
          return;
      }

      // Prepare start state
      var startNum = 1;
      var $wrapper = $('<span>' + startNum + suffixStr + '</span>');
      
      // Replace the content once
      $el.contents().first().replaceWith($wrapper);
      
      var duration = 2000;
      var startTime = null;

      function step(timestamp) {
          if (!startTime) startTime = timestamp;
          var progress = Math.min((timestamp - startTime) / duration, 1);
          
          // Easing: EaseOutCubic (smoother, more visible counting)
          var ease = 1 - Math.pow(1 - progress, 3);
          
          var current = Math.floor(ease * (endNum - startNum) + startNum);
          
          // formatting numbers with commas if needed, but keeping it simple for now based on input
          // usually counters don't add commas during animation unless expensive
          // let's add commas back if the original had them? 
          // The user input 'value' might have commas. Let's try to format 'current' similarly if endNum is large.
          var currentStr = current.toLocaleString('en-US'); // standardized comma format
          
          $wrapper.text(currentStr + suffixStr);
          
          if (progress < 1) {
              window.requestAnimationFrame(step);
          } else {
              // Ensure final value matches the input exactly (including specific formatting)
              $wrapper.text(value + suffixStr);
          }
      }
      
      window.requestAnimationFrame(step);
  }

  var $stats = $(".listivo-attributes-v3");
  animateStat($stats.find(".listivo-attributes-v3__attribute:nth-child(1) .listivo-attributes-v3__value"), stats.listings);
  animateStat($stats.find(".listivo-attributes-v3__attribute:nth-child(2) .listivo-attributes-v3__value"), stats.users);
  animateStat($stats.find(".listivo-attributes-v3__attribute:nth-child(3) .listivo-attributes-v3__value"), stats.businesses);
  animateStat($stats.find(".listivo-attributes-v3__attribute:nth-child(4) .listivo-attributes-v3__value"), stats.categories);

  var $stats2 = $(".listivo-stats-v2");
  animateStat($stats2.find(".listivo-stats-v2__item:nth-child(1) .listivo-stats-v2__value"), stats.listings, '+');
  animateStat($stats2.find(".listivo-stats-v2__item:nth-child(2) .listivo-stats-v2__value"), stats.users, '+');
  animateStat($stats2.find(".listivo-stats-v2__item:nth-child(3) .listivo-stats-v2__value"), stats.businesses, '+');
  animateStat($stats2.find(".listivo-stats-v2__item:nth-child(4) .listivo-stats-v2__value"), stats.categories, '+');

  var $stats3 = $(".listivo-stats-v1");
  animateStat($stats3.find(".listivo-stats-v1__item:nth-child(1) .listivo-stats-v1__value"), stats.listings);
  animateStat($stats3.find(".listivo-stats-v1__item:nth-child(2) .listivo-stats-v1__value"), stats.users);
  animateStat($stats3.find(".listivo-stats-v1__item:nth-child(3) .listivo-stats-v1__value"), stats.businesses);
  animateStat($stats3.find(".listivo-stats-v1__item:nth-child(4) .listivo-stats-v1__value"), stats.categories);

  setTimeout(function() {
      // Select both carousel types
      var termCarousels = document.querySelectorAll(
          '.listivo-term-carousel .listivo-swiper-container'
      );
      var listingCarousels = document.querySelectorAll(
          '.listivo-listing-carousel-with-tabs-v2__content > .listivo-swiper-container'
      );
      
      console.log('Found ' + termCarousels.length + ' carousels');
      
      termCarousels.forEach(function(carousel) {
          updateSwiper(carousel);
      });

      listingCarousels.forEach(function(carousel) {
          updateSwiper(carousel);
      });
  }, 1500);

  function updateSwiper(carousel) {
      if (!carousel) {
          console.log('Carousel element is undefined');
          return;
      }
      
      console.log('Processing carousel:', carousel);
      
      if (carousel.swiper) {
          console.log('Swiper instance found');
          
          var swiper = carousel.swiper;
        var isTermCarousel = carousel.closest('.listivo-term-carousel') !== null;

          
          // Update params
          // swiper.params.freeMode = true;
          swiper.params.speed = 1000;
          // swiper.params.loop = true;
          swiper.params.autoplay = {
              delay: 4000,
              disableOnInteraction: false,
              pauseOnMouseEnter: true
          };

          if (isTermCarousel) {
            swiper.params.slidesPerView = 2; // Default for mobile
            swiper.params.spaceBetween = 10;
            swiper.params.breakpoints = {
                // Mobile (up to 640px)
                0: {
                    slidesPerView: 1.5,
                    spaceBetween: 10
                },
                // Tablet (641px to 1024px)
                641: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                // Desktop (1025px and up)
                1025: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                // Large desktop
                1440: {
                    slidesPerView: 4,
                    spaceBetween: 32
                }
            };
        }
          
          // Update and start
          swiper.update();
          swiper.autoplay.start();
          
          // Pause on hover
          carousel.addEventListener('mouseenter', function() {
              if (swiper && swiper.autoplay) {
                  swiper.autoplay.stop();
              }
          });
          
          carousel.addEventListener('mouseleave', function() {
              if (swiper && swiper.autoplay) {
                  swiper.autoplay.start();
              }
          });
      } else {
          console.log('No swiper instance on this element');
      }
  }

  // Menu Dropdown Hover Logic for Register
  $('.listivo-menu-v2__register-wrapper').on('mouseenter', function() {
      $(this).find('.listivo-menu-v2__register-dropdown').stop(true, true).fadeIn(200);
  }).on('mouseleave', function() {
      $(this).find('.listivo-menu-v2__register-dropdown').stop(true, true).fadeOut(200);
  });

});
