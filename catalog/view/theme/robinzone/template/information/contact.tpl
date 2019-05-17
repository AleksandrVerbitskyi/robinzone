<?= $header; ?>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="contacts_title"><?= $heading_title; ?></h1>
                <div id="map2"></div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="container">
            <div class="row"><?= $content_top; ?></div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="contacts_description">
                        <ul class="contacts_description_block">
                            <li class="contacts_description_list"><?= $text_address; ?> <span itemprop="address"><?= $config_address; ?></span></li>
                            <li class="contacts_description_list "><?= $text_telephone; ?> <a href="tel:<?= $store_telephone; ?>" class="contacts_description_a"><span itemprop="telephone"><?= $store_telephone; ?></span></a></li>
                            <li class="contacts_description_list"><?= $text_our_email; ?> <a href="mailto:<?= $config_email; ?>" class="contacts_description_a"><span itemprop="email"><?= $config_email; ?></span></a></li>
                            <li class="contacts_description_list"><?= $text_our_site; ?> <a href="<?= $site_address; ?>" class="contacts_description_a"><span itemprop="url"><?= $config_comment; ?></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container contacts_background">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="writeUs_cover">
                        <form action="<?= $action; ?>" id="contact-us-form" method="post" enctype="multipart/form-data" class="writeUs_description_form">
                            <p class="writeUs_title"><?= $text_write_us; ?></p>
                            <p class="writeUs_description"><?= $text_phone_us_full; ?></p>
                            <div class="input-field">
                                <input type="text" name="name" autocomplete='name' value="<?= $name ?>" id="input-name" placeholder="<?= $entry_name; ?>" class="writeUs_description_input <?= $error_name ? 'has-error' : '' ?>">
                                <?php if ($error_name) { ?>
                                    <span class="text-danger error-contact-us-form"><?= $error_name; ?></span>
                                <?php } ?>
                            </div>
                            <div class="input-field">
                                <input type="tel" name="telephone" autocomplete='tel-national' value="<?= $telephone ?>" id="input-telephone" placeholder="<?= $entry_telephone; ?>" class="writeUs_description_input <?= $error_telephone ? 'has-error' : '' ?>">
                                <?php if ($error_telephone) { ?>
                                    <span class="text-danger error-contact-us-form"><?= $error_telephone; ?></span>
                                <?php } ?>
                            </div>
                            <div class="input-field">
                                <input type="email" name="email" autocomplete='email' value="<?= $email ?>" id="input-email" placeholder="<?= $entry_email; ?>" class="writeUs_description_input <?= $error_email ? 'has-error' : '' ?>">
                                <?php if ($error_email) { ?>
                                    <span class="text-danger error-contact-us-form"><?= $error_email; ?></span>
                                <?php } ?>
                            </div>
                            <div class="input-field contact-us-textarea-field">
                                <textarea rows="5" name="question" id="input-question" placeholder="<?= $entry_question; ?>" class="writeUs_description_input writeUsTextArea <?= $error_question ? 'has-error' : '' ?>"><?= $question ?></textarea>
                                <?php if ($error_question) { ?>
                                    <span class="text-danger error-contact-us-form error-message-bottom-4"><?= $error_question; ?></span>
                                <?php } ?>
                            </div>
                            <button type="submit" id="submit-contact-us" class="writeUs_description_button"><?= $button_submit; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><?= $content_bottom; ?></div>
</section>
<!-- MAP START -->
<script>

    function contactUsAction() {
        let data = $('#contact-us-form').serialize();
        $.ajax({
            url: '<?= $contact_us_url; ?>',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (json) {
                $('.text-danger').remove();
                $('.has-error').toggleClass('has-error');
                if (json['errors']) {
                    console.log(json['errors']);
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

    $(function () {
        $(document).on('click', '#submit-contact-us', function (e) {
            e.preventDefault();
            contactUsAction();
        });

        initMapContact();
    });

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
        var map3 = new google.maps.Map(document.getElementById('map'), myOptions);
        var marker = new google.maps.Marker({
            position: uluru,
            icon:image,
            map: map3
        });
        marker.addListener('click', function() {
            map3.setZoom(17);
            map3.setCenter(marker.getPosition());
        });
        var map2 = new google.maps.Map(document.getElementById('map2'), myOptions);
        var marker2 = new google.maps.Marker({
            position: uluru,
            icon:image,
            map: map2
        });
        marker2.addListener('click', function() {
            map2.setZoom(17);
            map2.setCenter(marker2.getPosition());
        });
    };
</script>
<!-- MAP END -->
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ1_cdQG3Atty5ofNEqC5lY65juMzruDM&callback=initMap">-->
</script>
<?= $footer; ?>
