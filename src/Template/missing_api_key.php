<!DOCTYPE html>
<html lang="da">
    <head>
        <link href='http://fonts.googleapis.com/css?family=Belleza' rel='stylesheet' type='text/css'>
        <link href='/style/style.css' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="da">
        <title>Er det kaffetid???</title>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            <?php if (!self::read('Debug') && self::read('Keys.GoogleAnalyticsId') != '') { ?>
            _gaq.push(['_setAccount', <?php print self::read('Keys.GoogleAnalyticsId');?>]);
            _gaq.push(['_setDomainName', 'erdetkaffetid.dk']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
            <?php } ?>
        </script>

    </head>
    <body>
        <img src="/img/bg.jpg" id="bg" alt="" />
        <section id="text">
            <h1>Fejl</h1>

            <p>Der mangler at blive indtastet en Google Maps API nøgle.</p>

            <p>Hvis du endnu ikke har en sådan, så kig <a href="https://developers.google.com/maps/signup">her</a>.</p>
        </section>

        <section id="footer">
            <p><img src="/img/bean-30.png" alt="Kaffebønne" class="bean40" /> Copyright 2012-<?php print date('Y');?> &copy; <a href="mailto:jesper@skytte.it">Jesper Skytte Hansen</a> - <a class="infoOpen" href="info">Info</a></p>
        </section>

        <!-- <?php print date('Y-m-d H:i:s'); ?>-->
    </body>
</html>