<footer class="main-footer">
    <div class="footer__top"><a href="" onclick="return false"><img src="../../assets/images/common__pagetop.png" alt="go to top"></a></div>
    <!-- <div class="footer__sns">
      <div class="container">
        <nav>
          <ul>
            <li><a href="https://www.facebook.com/naturesbestphotographyasia" target="_blank"><img src="../../assets/images/common__footer__facebook.png" alt="facebook"></a></li>
            <li><a href="https://twitter.com/nbpasia" target="_blank"><img src="../../assets/images/common__footer__twitter.png" alt="twitter"></a></li>
            <li><a href="https://www.pinterest.com/nbpawards/" target="_blank"><img src="../../assets/images/common__footer__pinterest.png" alt="pinterest"></a></li>
            <li><a href="https://www.instagram.com/nbpasia/" target="_blank" class="last"><img src="../../assets/images/common__footer__instagram.png" alt="instagram"></a></li>
          </ul>
        </nav>
      </div>
    </div> -->
    <div class="footer__links footer__linkspad ">
      <div class="container ">
        <nav>
          <ul>
            <li><a href="../en/contact-us.php">Contact Us</a></li>
            <li><a href="../en/privacy-policy.php">Privacy Policy</a></li>
            <li><a href="../en/terms.php">Terms of Use</a></li>
            <li><a href="../en/credits.php">Credits</a></li>
            <li><a href="../en/partners.php">Partners</a></li>
            <li class="js-langSelector "><a href=" " onclick="return false " class="last ">Language<small>▲</small></a>
              <ul class="js-langChild ">
                <li><a href="/en/ ">English</a></li>
                <li><a href="/ru/ ">Russian</a></li>
                <li><a href="/ja/ ">日本語</a></li>
                <li><a href="/sc/ ">中国語 簡体字</a></li>
                <li><a href="/tc/ ">中国語 繁体字</a></li>
                <li><a href="/ko/ " class="last ">韓国語</a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="footer__copyrights footer__copyrights130">
      <p>Copyright © 2020 Nature's Best Photography Asia. All Right Reserved.</p>
    </div>
  </footer>
  </div>
  <script type="text/javascript" src="../../assets/scripts/main.min.js"></script>
  <script>
    (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-60190803-1', 'auto');
    ga('send', 'pageview');
  </script>


  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "274px";
      document.getElementById("wrap").style.marginLeft = "274px";
    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("wrap").style.marginLeft = "0";
    }
  </script>


  <div id="wd1_nlpopup_overlay"></div>


  <div id="wd1_nlpopup" data-expires="7" data-delay="5000">
    <a href="#closepopup" id="wd1_nlpopup_close">x</a>
    <div class="container-fluid">
      <div class="row popup-row">
        <div class="col center">
          <h1>Join Our Newsletter</h1><br/>
          <h2>Join our newsletter to receive contest updates and deadline notices.</h2> <br/>
        </div>
      </div>
    </div>
    <div class="nlsubscribe">
      <form action="https://naturesbestphotography.asia/mail/subscribe" method="POST" accept-charset="utf-8">

        <input type="text" name="name" id="wd1_nlpopup_name" placeholder="Name" value="" class="textinput" tabindex="500">
        <input type="text" name="email" id="wd1_nlpopup_mail" placeholder="Your email" value="" class="textinput" tabindex="501">
        <input type="submit" name="submit" id="wd1_nlpopup_submit" value="Subscribe" class="btn btn-orange btn-large" tabindex="502">
        <input type="hidden" name="list" value="QNQ763ffKBPufy4ZMDpUZrrg" />
      </form>
    </div>
  </div>

  <script>
    var randomImage = {
      paths: [
        "../../assets/images/hero-top.jpg",
      ],

      generate: function() {
        var path = randomImage.paths[Math.floor(Math.random() * randomImage.paths.length)];
        var img = new Image();
        img.src = path;
        $("#randomImage a").html(img);
        $("#randomImage img").addClass("img-responsive");
      }
    }

    randomImage.generate();
  </script>

<script>
      function openNav() {
         document.getElementById("mySidenav").style.width = "274px";
         document.getElementById("gallerywrapper").style.marginLeft = "274px";
      }

      /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
      function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
         document.getElementById("gallerywrapper").style.marginLeft = "0";
      }
   </script>