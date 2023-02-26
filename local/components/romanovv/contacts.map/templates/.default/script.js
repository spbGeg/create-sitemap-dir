jQuery(document).ready(function($) {
    /* ======= ContactMap ======= */


        var $offices = document.querySelectorAll('.map-contact__item');
        //console.log('$offices map-contact__item',$offices );
        if ($offices) {
            const appendYaMaps = () => {
                let $contacts = document.querySelector('.js-map')
                if ($contacts) {
                    let contactsTop = $contacts.getBoundingClientRect().top;

                    if (contactsTop <= 1000) {
                        const key = '2315cab9-5a02-4018-a868-1baea0c875bf';
                        const script = document.createElement('script')
                        script.setAttribute('type', 'text/javascript')
                        script.src = `https://api-maps.yandex.ru/2.1/?apikey=${key}&lang=ru_RU&onload=initYaMaps`

                        if (!document.body.classList.contains('ya-maps-added')) {
                            document.head.appendChild(script)
                            document.body.classList.add('ya-maps-added')
                        }
                    }
                }
            }

            window.initYaMaps = function initYaMaps() {
                if ($offices.length > 0) {
                        function init() {

                            var myMap = new ymaps.Map('map', {
                                center: [50.443705, 30.530946],
                                zoom: 16,
                            });

                            $offices.forEach(function (office) {
                                var coordsString = office.dataset.coords;
                                var coords = coordsString.split(',');
                                var name = office.dataset.name;
                                var city = office.dataset.city;
                                var phone = office.dataset.phone;
                                var email = office.dataset.email;
                                myMap.geoObjects.add(new ymaps.Placemark(coords, {
                                    balloonContentHeader: name,
                                    balloonContentBody: city,
                                    balloonContentFooter: 'тел: ' + phone + '<br>' + 'email: ' + email,

                                    hintContent: name
                                }, {
                                    iconLayout: 'default#image',
                                    iconImageHref: '/local/sources/img/gazprom-pin.svg',
                                    iconImageSize: [50, 50],
                                    iconImageOffset: [-25, -45]
                                }))

                               // myMap.behaviors.disable('scrollZoom');
                                // Выставляем масштаб карты чтобы были видны все группы.
                                myMap.setBounds(myMap.geoObjects.getBounds());
                            });

                        }

                    ymaps.ready(init);
                }
            }

            window.addEventListener("scroll", function () {
                appendYaMaps();
            });
            appendYaMaps();

        }


});