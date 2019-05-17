<?php echo $header; ?>
<script>
    var regions = [];
</script>
<section>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $content_top ?>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="contacts_title"><?= $heading_title ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="mapCover">
                    <div class="row">
                        <div id="map2"></div>
                        <div id="map3"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <!-- Get from contact page -->
                <div class="contacts_description">
                    <ul class="contacts_description_block">
                        <li class="contacts_description_list" ><?= $text_address; ?> <span itemprop="address"><?= $config_address; ?></span></li>
                        <li class="contacts_description_list "><?= $text_telephone; ?> <a href="tel:<?= $store_telephone; ?>" class="contacts_description_a"><span itemprop="telephone"><?= $store_telephone; ?></span></a></li>
                        <li class="contacts_description_list"><?= $text_our_email; ?> <a href="mailto:<?= $config_email; ?>" class="contacts_description_a"><span itemprop="email"><?= $config_email; ?></span></a></li>
                        <li class="contacts_description_list"><?= $text_our_site; ?> <a href="<?= $site_address; ?>" class="contacts_description_a"><span itemprop="url"><?= $config_comment; ?></span></a></li>
                    </ul>
                </div>
                <!-- End block -->
                <h2 class="contacts_title"><?= $heading_representatives_title; ?></h2>
                <?php if (isset($cities) && count($cities) >= 1) { ?>
                    <div class="representativesCityOtion">
                        <ul class="representativesCityOtion_block" id="region">
                            <?php $first = 1; foreach ($cities as $city) { ?>
                                <?php if ($first++ == 1) { ?>
                                    <li class="representativesCityOtion_list loc" id="defaultOpenRepresentative" data-alias="<?= $city['alias']; ?>" data-city="<?= $city['name']; ?>"><?= $city['name']; ?></li>
                                <?php } else { ?>
                                    <li class="representativesCityOtion_list loc" data-alias="<?= $city['alias']; ?>" data-city="<?= $city['name']; ?>"><?= $city['name']; ?></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="representativesAdress" style="display: none">
                        <?php foreach ($cities as $city) { ?>
                            <div class="representativesAdress_c" id="<?= $city['alias'] ?>">
                                <?php if (isset($city['representatives'])) { ?>
                                    <?php foreach ($city['representatives'] as $representative) { ?>
                                        <div class="representativesAdress_block1_cover">
                                        <?php if (isset($representative['addresses'])) { ?>
<script>
    regions["<?= $representative['representative_id']?>"] =
        {
            "zoom":12,
            "lat":"<?= $representative['lat']?>",
            "lng":"<?= $representative['lng']?>"
        };
</script>
                                            <ul class="representativesAdress_block1">
                                                <?php foreach ($representative['addresses'] as $address) { ?>
                                                    <li class="representativesAdress_list1"><?= $address ?></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="container contacts_background">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="writeUs_cover">
                        <form action="#" id="contact_us_form" method="post" enctype="multipart/form-data" class="writeUs_description_form">
                            <p class="writeUs_title"><?= $text_write_us; ?></p>
                            <p class="writeUs_description"><?= $text_phone_us_full; ?></p>
                            <div class="input-field">
                                <input type="text" name="name" autocomplete="name" id="input-name" placeholder="<?= $entry_name; ?>" class="writeUs_description_input">
                            </div>
                            <div class="input-field">
                                <input type="tel" name="telephone" autocomplete="tel-national" id="input-telephone" placeholder="<?= $entry_telephone; ?>" class="writeUs_description_input">
                            </div>
                            <div class="input-field">
                                <input type="email" name="email" autocomplete="email" id="input-email" placeholder="<?= $entry_email; ?>" class="writeUs_description_input">
                            </div>
                            <div class="input-field contact-us-textarea-field">
                                <textarea rows="5" name="question" id="input-question" placeholder="<?= $entry_question; ?>" class="writeUs_description_input writeUsTextArea"></textarea>
                            </div>
                            <button type="submit" id="submit_contact_us" class="writeUs_description_button"><?= $button_contact_us; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $content_bottom ?>
        </div>
    </div>
</section>
<?php echo $footer; ?>

<script>

    $(function () {
        initRepresentativeMap();
        document.getElementById("defaultOpenRepresentative").click();
        $('#map3').css('display', 'none');
//        $('#map2').attr('overflow', false);
        initMapContact();
        $('.loc').one('click', function () {
            console.log('Click one');
            $('#map2').css('display', 'none');
            $('#map3').css('display', '');
            $('.representativesAdress').css('display', '');
        });

        $(document).on('click', '#submit_contact_us', function (e) {
            e.preventDefault();
            contactUsAction();
        });
    });

    function contactUsAction() {
        let data = $('#contact_us_form').serialize();
        $.ajax({
            url: '<?= $contact_us_url; ?>',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (json) {
                $('.text-danger').remove();
                $('.has-error').toggleClass('has-error');
                if (json['errors']) {
                    for (i in json['errors']) {
                        var $element = $('#input-' + i);
                        if (i === 'question') {
                            $element.after('<span class="text-danger error-contact-us-form error-message-bottom-4">' + json['errors'][i] + '</span>');
                        } else {
                            $element.after('<span class="text-danger error-contact-us-form">' + json['errors'][i] + '</span>');
                        }
                        if (!$element.hasClass('has-error')) $element.toggleClass('has-error');
                    }
                } else if (json['success']) {
                    location.assign(json['redirect']);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    
    var initRepresentativeMap = function() {
        var style = [
            {
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                ]
            },
            {
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#616161"
                    }
                ]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#bdbdbd"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#757575"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#757575"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#dadada"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#616161"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c9c9c9"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            }
        ];

        regions = regions.filter(function (item) {
            return item !== undefined;
        });

        let first_reg;
        for (i in regions) {
            first_reg = i;
            break;
        }

        var myLatlng = new google.maps.LatLng(regions[first_reg].lat,regions[first_reg].lng);

        var mapOptions = {
            zoom: 11,
            center: myLatlng,
            scrollwheel:  false,
            styles: style
        };
        var image = {
            url: "catalog/view/theme/robinzone/img/marker.png",
            size: new google.maps.Size(60, 60),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(10, 100),
            scaledSize: new google.maps.Size(60, 60)
        };

        var map = new google.maps.Map(document.getElementById("map3"), mapOptions);

        var marker;
        $.each(regions, function(index, val) {
            var centerpoint = new google.maps.LatLng(regions[index].lat,regions[index].lng);
            marker = new google.maps.Marker({
                position: centerpoint,
                icon: image
            });
            marker.setMap(map);

            google.maps.event.addListener(marker, 'click', function () {
                var marker = this;
                map.setZoom(18);
                map.setCenter(marker.getPosition());
            });
        });
        function city(el){
            geocoder = new google.maps.Geocoder();
            geocoder.geocode( { 'address' : el }, function( results, status ) {
                if( status === google.maps.GeocoderStatus.OK ) {
                    map.setCenter( results[0].geometry.location );
                    map.setZoom(10.7);

                } else {
                    alert( 'Geocode was not successful for the following reason: ' + status );
                }
            });
        }

        $('.loc').on('click', function(){
            city($(this).data('city'));
        });
    };

    var initMapContact = function () {
        var uluru = {lat: <?= explode(',', $geocode)[0]; ?>, lng: <?= explode(',', $geocode)[1]; ?>};
        var style = [
            {
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                ]
            },
            {
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#616161"
                    }
                ]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#bdbdbd"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#757575"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#757575"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#dadada"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#616161"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c9c9c9"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            }
        ];
        var myOptions = {
            zoom: 12,
            center: uluru,
            scrollwheel:  false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: style
        }
        var image = {
            url: "catalog/view/theme/robinzone/img/marker.png",
            size: new google.maps.Size(60, 60),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(60, 60)
        };
        var map2 = new google.maps.Map(document.getElementById('map2'), myOptions);
        var marker = new google.maps.Marker({
            position: uluru,
            icon:image,
            map: map2
        });
        marker.addListener('click', function() {
            map2.setZoom(17);
            map2.setCenter(marker.getPosition());
        });
    };
</script>
