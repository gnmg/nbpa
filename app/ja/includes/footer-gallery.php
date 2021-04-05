<footer class="main-footer">
    <div class="footer__top"><a href="" onclick="return false"><img src="../../../assets/images/common__pagetop.png"
                alt="go to top"></a></div>
    <!-- <div class="footer__sns">
      <div class="container">
        <nav>
          <ul>
            <li><a href="https://www.facebook.com/naturesbestphotographyasia" target="_blank"><img
                  src="../../assets/images/common__footer__facebook.png" alt="facebook"></a></li>
            <li><a href="https://twitter.com/nbpasia" target="_blank"><img
                  src="../../assets/images/common__footer__twitter.png" alt="twitter"></a></li>
            <li><a href="https://www.pinterest.com/nbpawards/" target="_blank"><img
                  src="../../assets/images/common__footer__pinterest.png" alt="pinterest"></a></li>
            <li><a href="https://www.instagram.com/nbpasia/" target="_blank" class="last"><img
                  src="../../assets/images/common__footer__instagram.png" alt="instagram"></a></li>
          </ul>
        </nav>
      </div>
    </div> -->
    <div class="footer__links footer__linkspad">
        <div class="container">
            <nav>
                <ul>
                    <li><a href="../../ja/contact-us.php">お問い合せ</a></li>
                    <li><a href="../../ja/privacy-policy.php">プライバシーポリシー</a></li>
                    <li><a href="../../ja/terms.php">利用規約</a></li>

                    <li class="js-langSelector"><a href="" onclick="return false"
                            class="last">Language<small>▲</small></a>
                            <ul class="js-langChild ">
                            <li><a href="/en/">English</a></li>
                            <!-- <li><a href="/ru/ ">Russian</a></li> -->
                            <li><a href="/ja/" class="last">日本語</a></li>
                            <!-- <li><a href="/sc/ ">中国語 簡体字</a></li>
                            <li><a href="/tc/ ">中国語 繁体字</a></li>
                            <li><a href="/ko/ " class="last ">韓国語</a></li> -->
                        </ul>
                    </li>
                </ul>
                <div class="ssl">
                </div>
            </nav>
        </div>
    </div>
    <div class="footer__copyrights footer__copyrights130">
        <p>Copyright © <?php echo date("Y"); ?>
            Nature's Best Photography Asia. All Right Reserved.</p>
    </div>
</footer>
</div>
<script type="text/javascript" src="../../assets/scripts/main.min.js"></script>
<script src="../../assets/scripts/jquery.mb.YTPlayer.js"></script>
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

<!-- Popup -->
<div id="wd1_nlpopup_overlay"></div>


<div id="wd1_nlpopup" data-expires="7" data-delay="5000">
    <a href="#closepopup" id="wd1_nlpopup_close">x</a>
    <div class="container-fluid">
        <div class="row popup-row">
            <div class="col center">
                <h1>ニュースレターを購読しませんか</h1><br />
                <h2>コンテストの最新情報や締め切りをお知らせする<br />ニュースレターをお送りします</h2>
            </div>
        </div>
    </div>
    <div class="nlsubscribe">
        <form action="https://mail2.naturesbestphotography.asia/mail/subscribe" method="POST" accept-charset="utf-8">

            <input type="text" name="name" id="wd1_nlpopup_name" placeholder="名前" value="" class="textinput"
                tabindex="500">
            <input type="text" name="email" id="wd1_nlpopup_mail" placeholder="メールアドレス" value="" class="textinput"
                tabindex="501">
            <input type="submit" name="submit" id="wd1_nlpopup_submit" value="Subscribe"
                class="btn btn-orange btn-large" tabindex="502">
            <input type="hidden" name="list" value="seJpyP9yr763eLf7hF0UZcLg" />
        </form>
    </div>
</div>

<script>
var randomImage = {
    paths: [
        "../../assets/images/english-hero-2020-winners.jpg",
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
      $(function() {
         $('.lazy').Lazy();
      });
   </script>
   <script>
      $(function() {
         $(".footer__top").click(function() {
            $('body, html').animate({
               scrollTop: 0
            }, 500);
         });
         $(".js-langSelector").click(function() {
            $(".js-langChild").add(this).toggleClass("on");
         });
         $(document).click(function(e) {
            if (!$.contains($(".js-langSelector")[0], e.target)) {
               $(".js-langSelector, .js-langChild").removeClass("on");
            }
         });
         $('.hero__slide').slick({
            autoplay: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
         });
         $('.hero__slide').on(
            'beforeChange',
            function(event, slick, currentSlide, nextSlide) {
               var $heroText = $('.js-hero_txt_image');
               if (nextSlide === 2) {
                  $heroText.fadeOut('400', function() {
                     $(this)
                        .attr('src', '/assets/images/index__hero-text-2.png')
                        .delay(100)
                        .fadeIn();
                  })
               }
               else if (nextSlide === 0) {
                  $heroText.fadeOut('400', function() {
                     $(this)
                        .attr('src', '/assets/images/index__hero-text.png')
                        .delay(100)
                        .fadeIn();
                  })
               }
            });
      });
   </script>