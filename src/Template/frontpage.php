<!DOCTYPE html>
<html lang="da">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Belleza&display=swap" rel="stylesheet">
    <link href='/style/style.css' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="da">
    <title>Er det kaffetid???</title>
    <meta property="og:title" content="Er det kaffetid?"/>
    <meta property="og:description"
          content="Har du lyst til en rigtig god kop kaffe, men ved ikke helt om det er det rigtige tidspunkt til kaffe? Tjek det her på 'Er det kaffetid?'"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://erdetkaffetid.dk"/>
    <meta property="og:image" content="https://erdetkaffetid.dk/img/logo-800.jpg"/>
    <meta property="og:site_name" content="Er det kaffetid?"/>
    <meta property="fb:admins" content="522077624"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script src="/js/html5.js" type="text/javascript"></script>
    <script src="/js/script.js" type="text/javascript"></script>
    <script src="https://maps.google.com/maps/api/js" type="text/javascript"></script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        <?php if (!self::read('Debug') && !empty(self::read('Keys.GoogleAnalyticsId'))) { ?>
        _gaq.push(['_setAccount', '<?php print self::read('Keys.GoogleAnalyticsId');?>']);
        _gaq.push(['_setDomainName', 'erdetkaffetid.dk']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = 'https://ssl.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
        <?php } ?>
    </script>
</head>
<body>
<img src="/img/bg.jpg" id="bg" alt=""/>
<section id="text"></section>
<section id="fadeout"></section>
<section id="info" class="popup">
    <h2><img src="/img/bean-30.png" alt="Kaffebønne" class="bean40"/> Er det kaffetid? - erdetkaffetid.dk</h2>
    <p>Dette er et lille hobbyprojekt lavet af en kaffeglad mand, nemlig jeg <a href="https://greew.dk/" target="_new">Jesper</a>.
    </p>
    <p>Send siden rundt, som du har lyst til!</p>
    <p>
        <a href="https://twitter.com/share" class="twitter-share-button fRight"
           data-text="Er du kaffetørstig, men ved ikke om du bør drikke kaffe nu? Check" data-related="greew"
           data-lang="da" data-size="normal">Tweet</a>
        <script>!function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");</script>
    </p>
    <div class="fb-like" data-href="https://erdetkaffetid.dk" data-send="false" data-width="350" data-show-faces="false"
         data-font="lucida grande"></div>
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <p>Billedet har jeg taget selv, teksten er forfattet af undertegnede og koden er skrevet selv, dog med hjælp fra
        tredjepartsbiblioteker. Oversat: Alt der ligger PÅ dette domæne er mit, og jeg giver dig hermed ret til at
        kopiere det og bruge det, som du har lyst til.</p>
    <p>Tak til <a href="https://znegl.dk/" target="_new">Thomas Grinderslev</a> for inspirationen til at lave siden.</p>
    <p>Kan du lide siden og vil støtte den? Så giv en kop kaffe ved lejlighed! :)</p>
    <div class="btn fRight"><a href="#" class="infoClose">Luk</a></div>
</section>
<section id="map" class="popup">
    <h2><img src="/img/bean-30.png" alt="Kaffebønne" class="bean40"/> Find nærmeste café</h2>
    <div id="mapContainer"></div>
    <div class="btn fRight"><a href="#" class="mapClose">Luk</a></div>
</section>
<!-- <?php
print date('Y-m-d H:i:s'); ?>-->
</body>
</html>
