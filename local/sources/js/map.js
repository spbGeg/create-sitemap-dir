function JSMapContacts(wrap) {
    var $curapp = this;
    $curapp.wrap = wrap;
    $curapp.errorField = '';
    $curapp.offices = {};

    $curapp.init();
}

JSMapContacts.prototype.init =  function () {
    let $curapp = this;

    $curapp.errorField = $curapp.wrap.find('.error');
     $curapp.showMap();

    console.log('$curapp.offices', $curapp.offices);

}

JSMapContacts.prototype.insertYmapScript = function (){
    $curapp = this;

        let $contacts = document.querySelector('.js-map')
    console.log('$contacts',$contacts );
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



JSMapContacts.prototype.createMap = function () {

    window.offices = $curapp.offices;
    window.initYaMaps = function initYaMaps() {


        if ($.isEmptyObject(window.offices) !== 'false') {

            function init() {

                var myMap = new ymaps.Map('map', {
                    center: [50.443705, 30.530946],
                    zoom: 16,
                });
                console.log('window.offices in inity yamap2', window.offices);

                window.offices.forEach(function (office) {
                    console.log('office in foreach', office);

                    let coords = office.coords.split(',');
                    let name = office.coords.name;
                    let city = office.coords.city;
                    let phone = office.coords.phone;
                    let email = office.coords.email;
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

                    // set size map that be see all elements on map
                    myMap.setBounds(myMap.geoObjects.getBounds());
                });

            }

            ymaps.ready(init);
        }
    }

}



JSMapContacts.prototype.setError = function ($error){
    $('.map-contact__msg').text($error);
}
JSMapContacts.prototype.showMap = async function () {
    var $curapp = this;

    let promiseGetOffice = new Promise((resolve, reject) => {

        $.ajax({
            type: "get",
            url: '/local/ajax/get-contacts.php',
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    console.log('data', data);
                    resolve(data.items);
                } else {
                    reject(data.error);

                }

            }
        });
    });
    promiseGetOffice.then(
        value => {
            console.log('value', value);
            $curapp.offices = value
            if (!$.isEmptyObject(value)) {
                console.log('start add elem', value);

                window.addEventListener("scroll", function () {
                    $curapp.insertYmapScript();
                });
                $curapp.insertYmapScript();
            }
            $curapp.createMap()
        },

    ).catch( value =>{
        $curapp.setError(value)
    })
}










