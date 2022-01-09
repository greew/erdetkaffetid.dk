$(function () {

    // ----- CREATE HELPER FUNCTIONS ----- //

    /**
     * Get random number between 0 and list.length - 1
     *
     * @param {Array} list
     * @returns {number}
     */
    function r(list) {
        return list[Math.floor(Math.random() * (list.length - 1))];
    }

    /**
     * Show popup function
     * @param {string} id Id of the element to show as a popup.
     */
    function showPopup(id) {
        const windowHeight = document.documentElement.clientHeight;
        const el = $("#" + id);
        const fadeout = $("#fadeout");
        el.css({
            "position": "absolute",
            "top": (windowHeight / 2) - (el.height() / 2),
            "left": (document.documentElement.clientWidth / 2) - (el.width() / 2)
        });
        fadeout.css({
            "opacity": "0.6",
            "height": windowHeight
        });
        fadeout.fadeIn("slow");
        el.fadeIn("slow");
    }

    /**
     * Hide popup function
     * @param {string} id Id of the element to hide.
     */
    function hidePopup(id) {
        $("#fadeout").fadeOut("slow");
        $("#" + id).fadeOut("slow");
    }

    // ----- SETUP PAGE CONTENTS ----- //

    // Setup variables, reasons, coffees and such
    let doIt = true;
    let reasons = [];
    const hour = (new Date()).getHours();
    let coffee = [
        'Espresso',
        'dobbelt Espresso',
        'Café Latte',
        'Cappuccino',
        'Filterkaffe',
        'Stempelkaffe',
        'Café au Lait',
        'Cortado'
    ];
    let fetch = [
        'Snup straks en',
        'Hent en',
        'Tag dig en',
        'Skynd dig at hente en',
        'Få fat i en',
        'Bestil en',
        'Bryg straks en'
    ];
    switch (hour) {
        case 6:
        case 7:
        case 8:
        case 9:
        case 10:
        case 11:
            reasons = [
                'Du ser træt ud!',
                'Godmorgen!',
                'Morgenstund har guld i mund!',
                'Er du kaffelysten?',
                'Lidt koffein før frokosten?'
            ];
            break;
        case 12:
        case 13:
        case 14:
        case 15:
        case 16:
        case 17:
            reasons = [
                'Du bliver frisk!',
                'Forkæl dig selv nu!',
                'Perfekt til en lang eftermiddag!',
                'Måske lidt gulerodskage!?',
                'Er det blevet fyraften?'
            ];
            break;
        case 18:
        case 19:
        case 20:
        case 21:
        case 22:
        case 23:
            reasons = [
                'Pas på du ikke falder i søvn for tidligt!',
                'Trænger du ikke til lidt koffein?',
                'Bruger du mælk og sukker?',
                'En kop efter middagen er godt!'
            ];
            break;
        case 0:
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
            if ((new Date()).getSeconds() % 2) {
                reasons = [
                    'Måske er det en ide at tage koffeinfri?',
                    'Men begrænsede mængder så sent!',
                    'Det bør nok være koffeinfri?'
                ];
            } else {
                doIt = false;
                reasons = [
                    'Det er over din sengetid!',
                    'Kaffen er sort som natten!',
                    'Koffein kvikker altså!',
                    'Kaffen holder dig bare vågen!'
                ];
                fetch = [
                    'Sengen kalder på dig!',
                    'Sov, for pokker!',
                    'Burde du ikke sove??',
                    'Ole Lukøje venter på dig!'
                ];
                coffee = [''];
            }
            break;
    }

    let map = null;
    let infoWindow = null;

    // Setup findCoffee button and click listener for it
    const findCoffeeBtn = $('<a href="#">').append('Find nærmeste café');
    $(findCoffeeBtn).click(function (event) {
        event.preventDefault();

        // Position was found - we can commence with the drawing
        function success(position) {
            if ($('#mapcanvas').length > 0) {
                // not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back
                showPopup('map');
                return;
            }

            $('#status').addClass('success').empty().append("found you!");

            const mapcanvas = $('<div>').attr('id', 'mapcanvas').height('400px').width('500px')[0];
            $('#mapContainer').append(mapcanvas);
            showPopup('map');

            const latlng = new google.maps.LatLng(
                position.coords.latitude,
                position.coords.longitude
            );
            const myOptions = {
                language: 'da',
                zoom: 14,
                center: latlng,
                mapTypeControl: false,
                navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(mapcanvas, myOptions);

            const marker = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                position: latlng,
                map: map,
                title: "Du er her! (Usikkerhed på " + position.coords.accuracy + " meter)"
            });

            infoWindow = new google.maps.InfoWindow({});
            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.setContent($('<div>').append($('<h1>').append('Du er her')).html());
                infoWindow.open(map, this);
            });


            $.ajax({
                url: '/places',
                data: {
                    lat: latlng.lat(),
                    lng: latlng.lng()
                },
                success: findCoffee,
                dataType: 'json'
            });
        }

        // For each found coffee location, add a new marker to the map
        function findCoffee(data) {
            for (let i = 0; i < Math.min(10, data.data.results.length); i++) {
                const c = data.data.results[i];
                const pos = new google.maps.LatLng(c.geometry.location.lat, c.geometry.location.lng);
                const html = '<div>' +
                    '<h3>' + c.name + '</h3>' +
                    '<p>' + c.vicinity + '</p>' +
                    '</div>';
                const coffeeIcon = new google.maps.Marker({
                    animation: google.maps.Animation.DROP,
                    position: pos,
                    map: map,
                    title: decodeURIComponent(c.name),
                    icon: 'http://erdetkaffetid.dk/img/bean-30.png',
                    html: html
                });
                google.maps.event.addListener(coffeeIcon, 'click', function () {
                    infoWindow.setContent(this.html);
                    infoWindow.open(map, this);
                });
            }
        }

        // Error handling if we couldn't get the position
        function error() {
            $('#mapContainer').append(
                $('<p>').append('Det er desværre ikke muligt at få fat i din position lige nu. Dette kan bl.a. skyldes følgende ting:'),
                $('<ul>').append(
                    $('<li>').append('Din browser understøtter ikke muligheden for at se din position.'),
                    $('<li>').append('Du har valgt at blokere, at https://erdetkaffetid.dk kan tilgå din position.')
                ),
                $('<p>').append('Hvis du får fat i en browser, der tillader muligheden for at se din position, og du aktiverer at vi kan se det, så genindlæs siden her. Så kan du får kortet frem.')
            );
            showPopup('map');
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, error);
        } else {
            error();
        }
    });

    // Setup coffee texts
    $('#text').append(
        $('<h1>').append(doIt ? 'Ja!' : 'Nej!'),
        $('<p>').append(r(reasons)),
        $('<p>').append(r(fetch) + (doIt ? ' ' + r(coffee) : '')),
        $('<p>').attr('class', 'small').append(doIt ? findCoffeeBtn : '')
    );

    // ----- SETUP GLOBAL LISTENERS ----- //

    // Click listener on infoOpen button
    $("a.infoOpen").click(function (event) {
        event.preventDefault();
        showPopup('info');
    });

    // Click listener on infoClose button
    $("a.infoClose").click(function (event) {
        event.preventDefault();
        hidePopup('info');
    });

    // Click listener on mapClose button
    $('a.mapClose').click(function (event) {
        event.preventDefault();
        hidePopup('map');
    });

    // Setup listener to resize the background if window is resized
    $(window).on('resize', function () {
        const $bg = $("#bg");
        $bg.removeClass('bgheight bgwidth');
        if (($(window).width() / $(window).height()) < ($bg.width() / $bg.height())) {
            $bg.addClass('bgheight');
        } else {
            $bg.addClass('bgwidth');
        }
    }).trigger("resize");
});
