/*
 * QrCdr - jQuery Plugin
 * version: 5.0.0
 * @requires jQuery >= 1.7.0
 *
 * Copyright 2020-2021 Nicola Franchini - @nicolafranchini
 *
 */

/* global jQuery */
(function($){
    "use strict";   
    $.fn.extend({
        //plugin name - venobox
        qrcdr: function(options) {
            var plugin = this;
            var $myForm, formInputs, submitform, linksholder, qrcolorpicker, colorpickerback, preloader, alert_placeholder, transparent_bg, resultholder, generate_qrcode_btn, holdresult;
            var collapse_control, collapse_control_reverse, upmarker, isSvg, event, map, timer, setvalue, yesdonation, nodonation, init_lat, init_lng, btcInput, settings;

            // default options
            // var defaults = {
            //     saveCode: function(){}
            // };

            // var option = $.extend(defaults, options);

            return this.each(function() {

                var obj = $(this);

                if (obj.data('qrcdr')) {
                    return true;
                }

                $myForm = obj.find('.qrcdr-form');
                submitform = $myForm.find(':submit');
                formInputs = obj.find('.qrcdr-form :input');
                linksholder = obj.find('.linksholder');
                qrcolorpicker = obj.find('.qrcolorpicker');
                colorpickerback = obj.find('.colorpickerback');

                preloader = obj.find('.preloader');
                alert_placeholder = obj.find('.alert_placeholder');
                transparent_bg = obj.find('#trans-bg');
                resultholder = obj.find('.resultholder');
                generate_qrcode_btn = obj.find('.generate_qrcode'); // #submitsave
                holdresult = obj.find('.holdresult');
                setvalue = obj.find('.setvalue');
                yesdonation = obj.find('.yesdonation');
                nodonation = obj.find('.nodonation');
                collapse_control = obj.find('.collapse-control');
                collapse_control_reverse = obj.find('.collapse-control-reverse');
                btcInput = obj.find('input[name=btc_account]');
                upmarker = obj.find('#upmarker');
                event = obj.find('#event');
                settings = obj.find('#collapseSettings :input');

                var inputactive = formInputs.filter(function(index, element) {
                    return ! $(element).hasClass('nopreview') && ! $(element).hasClass('pac-input');
                });

                isSvg = 'no';

                obj.data('qrcdr', true);

                // methods to be used outside the plugin
                plugin.getSettings = function() {
                    return getsettings();
                };
                plugin.updateCode = function() {
                    return updateCode();
                };

                // Colorpicker
                qrcolorpicker.colorpicker({
                    autoInputFallback: false
                });

                // Custom Collpase
                collapse_control.on('change', function(){
                    var target = $(this).data('target');
                    if ($(this).prop('checked')) {
                        $(target).collapse('show');
                    } else {
                        $(target).collapse('hide');
                    }
                });
                collapse_control_reverse.on('change', function(){
                    var target = $(this).data('target');
                    if ($(this).prop('checked')) {
                        $(target).collapse('hide');
                    } else {
                        $(target).collapse('show');
                    }
                });

                collapse_control_reverse.each(function(){
                    var target = $(this).data('target');
                    if ($(this).prop('checked')) {
                        $(target).collapse('hide');
                    } else {
                        $(target).collapse('show');
                    }
                });
            
                // Transparent background
                transparent_bg.on('change', function(){
                    if ($(this).prop('checked')) {
                        colorpickerback.colorpicker('setValue', 'transparent');
                        colorpickerback.colorpicker('disable');
                    } else {
                        colorpickerback.colorpicker('enable');
                    }
                });

                if (transparent_bg.prop('checked')) {
                    colorpickerback.colorpicker('setValue', 'transparent');
                    colorpickerback.colorpicker('disable')
                } else {
                    colorpickerback.colorpicker('enable');
                }

                /*
                 * Validate form
                 */
                var validateforms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(validateforms, function(form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                    }, false);
                });

                /*
                 * Update QR code preview
                 */
                function updateCode() {

                    clearTimeout(timer);
                    
                    //generate_qrcode_btn.addClass('d-none');
                    generate_qrcode_btn.attr('disabled', true);
                    linksholder.html('');

                    timer = setTimeout(function(){

                        if (!$myForm[0].checkValidity()) {
                            submitform.click();
                        }

                        colorpickerback.colorpicker('enable');

                        preloader.fadeIn(100,function(){
                            var sendata = formInputs.filter(function(index, element) {
                                return $(element).val() != "";
                            }).serialize();

                            $.ajax({
                                type: "POST",
                                url: "ajax/process.php",
                                cache: false,
                                data: sendata
                            })
                            .fail(function(error) {
                                alert_placeholder.html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="error-response">'+error.statusText+'</span></div>');
                            })
                            .done(function(msg) {
                                if (transparent_bg.prop('checked')) {
                                    colorpickerback.colorpicker('disable');
                                }
                                var result = JSON.parse(msg);
                                if (result.hasOwnProperty('errore')) {
                                    alert_placeholder.html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="error-response">'+result.errore+'</span></div>');
                                    resultholder.html('<img src="' + result.placeholder + '">');
                                    preloader.fadeOut('slow');
                                } else {
                                    alert_placeholder.html('');
                                    // generate_qrcode_btn.removeClass('d-none');
                                    generate_qrcode_btn.attr('disabled', false);
                                    resultholder.html(result.content);
                                    preloader.fadeOut('slow');
                                    holdresult.val(msg);
                                }
                            });
                        });
                    }, 1000);
                }

                // Update preview
                formInputs.on('change', function() {
                    if (!$(this).hasClass('nopreview') && !$(this).hasClass('pac-input')) {
                        updateCode();
                    }
                });

                // Hide save preview button
                formInputs.on('input', function() {
                    // generate_qrcode_btn.addClass('d-none');
                    generate_qrcode_btn.attr('disabled', true);
                    linksholder.html('');
                });

                // Print QRCODE
                function printIt(printThis) {

                    var infopanel = "";
                    /*
                    // Print data
                    var thisdata = $("#create").find(".tab-pane.active :input").filter(function(index, element) {
                        return $(element).val() != "";
                    }).serializeArray();
                    var formData = JSON.stringify(thisdata);
                    var dede = $.parseJSON( formData );
                    $.each(dede, function(i, item) {
                        var dato = item.name + ": " + item.value;
                        infopanel += "<br>" + dato;
                    });
                    */
                    var src = $(printThis).attr('href');
                    var win = window.open('about:blank', "_new");
                    win.document.open();
                    win.document.write('<html><head></head><body onload="window.print()" onafterprint="window.close()"><img src="' + src + '"/>'+infopanel + '</body></html>');
                    win.document.close();
                }

                function getsettings(){
                    var settingInputs = settings.filter(function(index, element) {
                        return $(element).val() != "";
                    }).serializeArray();

                    var datasettings = {};
                    $(settingInputs).each(function(index, obj){
                        datasettings[obj.name] = obj.value;
                    });
                    return datasettings;
                }

                /*
                 * Generate SVG and dowload buttons
                 */
                function saveCode(){
                    var sendata = holdresult.val();
                    $.ajax({
                        type: "POST",
                        url: "ajax/create.php",
                        cache: false,
                        data: {
                            create: sendata
                        }
                    })
                    .fail(function(error) {
                        alert_placeholder.html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="error-response">'+error.statusText+'</span></div>');
                    })
                    .done(function(msg) {
                        if (msg.length) {
                            var getdata = JSON.parse(msg);
                            if (getdata.error) {
                                bootbox.alert({
                                    message: getdata.error,
                                    size: 'small'
                                });
                            } else {
                                var filepath = getdata.filedir+'/'+getdata.basename;

                                var downloadlinks = '<button class="btn btn-default svgtopng" data-path="'+filepath+'"><i class="fa fa-download"></i> PNG</button><a href="#" class="btn btn-default d-none preload-png"><i class="fa fa-circle-o-notch fa-spin"></i> PNG</a><a class="serve-png d-none" href="'+filepath+'.png" download="'+getdata.basename+'.png" data-path="'+filepath+'">PNG</a>';
                                downloadlinks = downloadlinks + '<a class="btn btn-default serve-svg" href="'+filepath+'.svg" download="'+getdata.basename+'.svg"><i class="fa fa-download"></i> SVG</a>';
                                downloadlinks = downloadlinks + '<button class="btn btn-default print"><i class="fa fa-print"></i></button>';

                                linksholder.html(downloadlinks);
                                generate_qrcode_btn.attr('disabled', true);

                                obj.find('.print').on('click', function(){
                                    printIt('.serve-svg');
                                });
                            }
                        }
                        // Callback
                        // option.saveCode(getdata);
                    });
                }

                // Save SVG
                generate_qrcode_btn.on('click', function(){
                    saveCode();
                });

                /*
                 * Generate PNG and dowload it
                 */
                function createPng() {

                    var newImg, canva, ctx, form, filename, fake, imgSrc, link, servePng;
                    link = $('.svgtopng');
                    servePng = link.parent().find('.serve-png')
                    fake = link.parent().find('.preload-png');
                    link.addClass('d-none');
                    fake.removeClass('d-none');

                    filename = servePng.attr('download');
                    imgSrc = link.data('path')+'.svg';

                    newImg = new Image();
                    canva = document.createElement("canvas"); 
                    ctx = canva.getContext("2d");   
                    form = $('#svgtopng');

                    newImg.onload = function() {
                        var newImgW = (newImg.width*2);
                        var newImgH = (newImg.height*2);
                        canva.width  = newImgW;
                        canva.height = newImgH;
                        ctx.drawImage(newImg, 0, 0, newImgW, newImgH);
                        var dataURL = canva.toDataURL();
                        $.ajax({
                            type: "POST",
                            url: "ajax/png.php",
                            cache: false,
                            data: {imgdata: dataURL, filename: filename}
                        })
                        .fail(function(error) {
                            bootbox.alert(error.statusText);
                        })
                        .done(function(msg) {
                            if (msg == 'error') {
                                bootbox.alert({
                                    message: "File not found",
                                    size: 'small'
                                });
                            } else {
                                fake.addClass('d-none');
                                link.removeClass('d-none');
                                servePng[0].click();
                            }
                        });
                    }
                    newImg.src = imgSrc; // this must be done AFTER setting onload
                }

                // Save PNG
                $(document).on('click', '.svgtopng', createPng);

                /*
                 * Upload custom marker
                 */
                upmarker.on('change', function(e){
                    $(this).removeClass('is-invalid');
                    if (this.files[0].type.match('image.*')) {
                        var file = this.files[0];
                        var newimg = new Image();
                        newimg.crossOrigin = "Anonymous";
                        var reader = new FileReader();

                        if (file.type.indexOf('svg') > 0) {
                            isSvg = 'svg';
                        }

                        reader.onload = function (e) {
                            $('.logoselecta label').removeClass('active').find('input').removeAttr('checked');
                            var out = '<img src="'+e.target.result+'" class="user_watermark">';

                            // Update custom watermark option
                            newimg.src = $('.logoselecta .btn-group-toggle label' ).last().find('img').attr('src');
                            $('.custom-watermark .hold-custom-watermark').html(out);
                            $('.custom-watermark').addClass('active');
                            $('.custom-watermark input').val(e.target.result).prop("checked", true);
                        };

                        reader.readAsDataURL(file);

                        newimg.onload = function () {
                            var canvas = document.createElement("canvas");

                            // resize thumb
                            var MAX_WIDTH = 400;
                            var MAX_HEIGHT = 400;
                            var width = this.width;
                            var height = this.height;
                        
                            if (isSvg !== 'svg') {
                                if (width == 0 || height == 0) {
                                    $('#upmarker').addClass('is-invalid');
                                    $('.logoselecta .btn-group-toggle label' ).last().remove();
                                    return false;
                                }
                                var ctx = canvas.getContext("2d");
                                ctx.drawImage(newimg, 0, 0);

                                if (width > height) {
                                    height *= MAX_WIDTH / width;
                                    width = MAX_WIDTH;
                                } else {
                                    width *= MAX_HEIGHT / height;
                                    height = MAX_HEIGHT;
                                }
                                canvas.width = width;
                                canvas.height = height;

                                var ctx = canvas.getContext("2d");
                                ctx.drawImage(newimg, 0, 0, width, height);
                                var dataurl = canvas.toDataURL();

                                $('.logoselecta .btn-group-toggle label' ).last().find('img').attr('src', dataurl);
                                $('.logoselecta .btn-group-toggle label' ).last().find( "input[name='optionlogo']" ).val(dataurl);
                            }
                        } // img.onload
                    } else {
                        $(this).addClass('is-invalid');
                    }
                });

                /**
                 * Events Calendar
                 */
                if (event.length) {
                    $('.datetimepicker-input').datetimepicker({
                        format: 'LLL'
                    });
                    $('.datetimepicker-input').on("change.datetimepicker", function(e) {
                        var getinput = $(this).data('timestamp');
                        $(getinput).attr('value', e.date.unix());
                    });
                }

                /**
                 * GoogleMaps
                 */
                function initializeMap() {

                    if ( $( "#map-canvas" ).length ) {
                        // Google MAP
                        init_lat = $( "#map-canvas" ).data('lat');
                        init_lng = $( "#map-canvas" ).data('lng');
                        var start = new google.maps.LatLng(init_lat, init_lng);
                        var marker;
                        var input = (document.getElementById('pac-input'));
                        var getdata = (document.getElementById('latlong'));
                        var latbox = document.getElementById('latbox');
                        var lngbox = document.getElementById('lngbox');

                        var searchBox;

                        var mapOptions = {
                            zoom: 10,
                            center: start
                        };

                        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                        searchBox = new google.maps.places.SearchBox((input));
                        marker = new google.maps.Marker({
                            map:map,
                            draggable:true,
                            animation: google.maps.Animation.DROP,
                            position: start
                        });

                        google.maps.event.addListener(marker, 'dragend', function(event) {
                            var latlang = marker.getPosition().lat()+","+marker.getPosition().lng();
                            updateposition(latlang);
                        });

                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(getdata);

                        if ((latbox.value.length > 0 ) && (lngbox.value.length > 0)) {
                            setPosition(Number(latbox.value), Number(lngbox.value));
                        }

                        google.maps.event.addListener(searchBox, 'places_changed', function() {
                            var places = searchBox.getPlaces();

                            if (places.length == 0) {
                              return;
                            }

                            for (var i = 0, place; place = places[i]; i++) {
                                marker.setPosition(place.geometry.location);
                                map.setCenter(place.geometry.location);
                                updateposition();
                            }
                        });
                    }

                    function updateposition(){
                        latbox.value = marker.getPosition().lat();
                        lngbox.value = marker.getPosition().lng();
                        // Update code preview
                        updateCode();
                    }

                    function setPosition(latvar, lngvar){
                        map.setCenter({lat: latvar, lng: lngvar});
                        marker.setPosition({lat: latvar, lng: lngvar});
                        updateposition();
                    }

                    $('#latbox, #lngbox').on('input', function(){
                        if ((latbox.value.length > 0 ) && (lngbox.value.length > 0)) {
                            setPosition(Number(latbox.value), Number(lngbox.value));
                        }
                    });
                }

                /*
                 * OpenMaps
                 */
                function loadGeolocator(geomap_id, geomarker_id) {

                    if ( $( "#wpol-admin-map" ).length ) {
                        init_lat = $( "#wpol-admin-map" ).data('lat');
                        init_lng = $( "#wpol-admin-map" ).data('lng');

                        if (typeof ol === 'undefined' || ol === null) {
                          console.log('WARNING: OpenLayers Library not loaded');
                          return false;
                        }

                        var om_map_pos = ol.proj.fromLonLat([init_lng, init_lat]);
                        var view = new ol.View({
                            center: om_map_pos,
                            zoom: 4
                        });

                        // Init map
                        map = new ol.Map({
                            target: 'wpol-admin-map',
                            view: view,
                            layers: [
                              new ol.layer.Tile({
                                source: new ol.source.OSM()
                              })
                            ],
                            controls: ol.control.defaults({ attributionOptions: { collapsible: true } }),
                            interactions: ol.interaction.defaults({mouseWheelZoom:false})
                        });

                        // Add Marker
                        var marker_el = document.getElementById(geomarker_id);
                        var infomarker = new ol.Overlay({
                            position: om_map_pos,
                            positioning: 'center-center',
                            // offset: [0, -20],
                            element: marker_el,
                            stopEvent: false,
                            dragging: false
                        });
                        map.addOverlay(infomarker);

                        var dragPan;
                        map.getInteractions().forEach(function(interaction){
                            if (interaction instanceof ol.interaction.DragPan) {
                                dragPan = interaction;  
                          }
                        });

                        marker_el.addEventListener('mousedown', function(evt) {
                          dragPan.setActive(false);
                          infomarker.set('dragging', true);
                        });

                        map.on('pointermove', function(evt) {
                            if (infomarker.get('dragging') === true) {
                            infomarker.setPosition(evt.coordinate);
                          }
                        });

                        map.on('pointerup', function(evt) {
                            if (infomarker.get('dragging') === true) {
                                dragPan.setActive(true);
                                infomarker.set('dragging', false);
                                var coordinate = evt.coordinate;
                                var lonlat = ol.proj.toLonLat(coordinate);
                                $('.venomaps-get-lat').val(lonlat[1]);
                                $('.venomaps-get-lon').val(lonlat[0]);
                                // Update code preview
                                updateCode();
                            }
                        });

                        // Update lat lon fields
                        function georesponse(response){
                            var lat = response[0].lat;
                            var lon = response[0].lon;
                            var newcoord = ol.proj.fromLonLat([lon, lat]);
                            infomarker.setPosition(newcoord);
                            view.setCenter(newcoord);
                            view.setZoom(6);
                            $('.venomaps-get-lat').val(lat);
                            $('.venomaps-get-lon').val(lon);
                            // Update code preview
                            updateCode();
                        }

                        // Get coordinates from Address.
                        $('.venomaps-get-coordinates').on('click', function(){

                            var button = $(this);
                            var address = $('.venomaps-set-address').val()

                            if ( address.length > 3 ) {
                                button.hide();
                                var encoded = encodeURIComponent(address);
                                $.ajax({
                                    url: 'https://nominatim.openstreetmap.org/search?q='+encoded+'&format=json',
                                    type: 'GET',
                                }).done(function(res) {
                                    georesponse(res);
                                })
                                .always(function() {
                                    button.fadeIn();
                                });
                            }
                        });

                        function updateMap(lat, lon){
                            var newcoord = ol.proj.fromLonLat([lon, lat]);
                            infomarker.setPosition(newcoord);
                            view.setCenter(newcoord);
                            //view.setZoom(6);
                        }

                        $('.setinput-latlon').on('input', function(){
                            var lat = $('.venomaps-get-lat').val();
                            var lon = $('.venomaps-get-lon').val();
                            updateMap(lat, lon);
                        });
                    }
                }

                // Load OpenMaps
                loadGeolocator( 'wpol-admin-map', 'infomarker_admin' );


                // Load GoogleMaps
                initializeMap();

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var dest = $(e.target).attr('href');
                    $("#getsec").val(dest);

                    if (dest == "#location") {
                        // ReLoad GoogleMaps
                        initializeMap();

                        // Update Openlayers map
                        if ( $('#wpol-admin-map').length ) {
                            map.updateSize();
                        }
                    }
                });

                /**
                 * PayPal
                 */
                 // Set currency
                setvalue.on('change', function(){
                    var value = $(this).val();
                    var getvalue = $(this).data('target');
                    getvalue.html(value);
                });

                // PayPal button type
                $("#pp_type").on('change', function(){
                    var value = $(this).val();
                    if (value === '_donations') {
                        nodonation.addClass('d-none');
                        yesdonation.removeClass('col-sm-3');
                    } else {
                        nodonation.removeClass('d-none');
                        yesdonation.addClass('col-sm-3');
                    }
                }); 

                /**
                 * BitCoin
                 */
                btcInput.on('input', function(){
                    var address = btcInput.val();
                    $.ajax({
                      method: "POST",
                      url: "ajax/btc-check.php",
                      data: { btc_account: address }
                    })
                    .done(function( msg ) {
                        if (msg) {
                            btcInput.removeClass('is-invalid').addClass('is-valid');
                        } else {
                            btcInput.removeClass('is-valid').addClass('is-invalid');
                        }
                    });
                });

            }); // each
        } // qrcdr
    }); // extend
})(jQuery);

var QRcdr;

$(document).ready(function(){
    QRcdr = $('.qrcdr').qrcdr();
});
