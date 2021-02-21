  $("document").ready(function() {
      var homeSection = $('.home-section'),
          navbar = $('.navbar-custom'),
          navHeight = navbar.height(),
          width = Math.max($(window).width(), window.innerWidth),
          mobileTest = false;

      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
          mobileTest = true;
      }

      buildHomeSection(homeSection);
      navbarAnimation(navbar, homeSection, navHeight);
      // navbarSubmenu(width);
      // hoverDropdown(width, mobileTest);

      $(window).resize(function() {
          var width = Math.max($(window).width(), window.innerWidth);
          buildHomeSection(homeSection);
          //hoverDropdown(width, mobileTest);
      });

      $(window).scroll(function() {
          effectsHomeSection(homeSection, this);
          navbarAnimation(navbar, homeSection, navHeight);
      });

      /* ---------------------------------------------- /*
       * Set sections backgrounds
       /* ---------------------------------------------- */

      var module = $('.home-section, .module, .module-small, .side-image');
      module.each(function(i) {
          if ($(this).attr('data-background')) {
              $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
          }
      });

      /* ---------------------------------------------- /*
       * Home section height
       /* ---------------------------------------------- */

      function buildHomeSection(homeSection) {
          if (homeSection.length > 0) {
              if (homeSection.hasClass('home-full-height')) {
                  homeSection.height($(window).height() * 0.80);
              } else {
                  homeSection.height($(window).height() * 0.85);
              }
          }
      }

      /* ---------------------------------------------- /*
         * Home section effects
         /* ---------------------------------------------- */

      function effectsHomeSection(homeSection, scrollTopp) {
          if (homeSection.length > 0) {
              var homeSHeight = homeSection.height();
              var topScroll = $(document).scrollTop();
              if ((homeSection.hasClass('home-parallax')) && ($(scrollTopp).scrollTop() <= homeSHeight)) {
                  homeSection.css('top', (topScroll * 0.55));
              }
              if (homeSection.hasClass('home-fade') && ($(scrollTopp).scrollTop() <= homeSHeight)) {
                  var caption = $('.caption-content');
                  caption.css('opacity', (1 - topScroll / homeSection.height() * 1));
              }
          }
      }


      function navbarAnimation(navbar, homeSection, navHeight) {
          var topScroll = $(window).scrollTop();
          if (navbar.length > 0 && homeSection.length > 0) {
              if (topScroll >= navHeight) {
                  navbar.removeClass('navbar-transparent');
              } else {
                  navbar.addClass('navbar-transparent');
              }
          }
      }

      $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
              $('.scroll-up').fadeIn();
          } else {
              $('.scroll-up').fadeOut();
          }
      });

      $('a[href="#totop"]').click(function() {
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          return false;
      });


  });