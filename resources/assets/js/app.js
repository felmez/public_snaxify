/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.js-add-image').click(function (ev) {
        ev.preventDefault();
        $('.js-product-images-holder').append($('.js-product-image').first().clone())
    });

    $('.js-delete-product-image').click(function (ev) {
        ev.preventDefault();
        var id = $(this).data('id');
        $.post('/product_image/' + id + '/delete', function () {
            $('.js-product-image-' + id).remove();
        });
    });

    if ($('#delivery_area_map').length > 0) {
        var latlng = new google.maps.LatLng(41.0146233,28.9415103),
            myOptions = {
                zoom: 11,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: latlng
            },
            map = new google.maps.Map(document.getElementById("delivery_area_map"), myOptions),
            initDrawManager = true;
        if ($('.js-area-coords').val() != '') {
            var points = $.parseJSON($('.js-area-coords').val()),
                ll_points = [];
            points.forEach(function (itm, ind) {
                ll_points.push(new google.maps.LatLng(itm.lat, itm.lng));
            });
            var l_polygon = new google.maps.Polygon({
                paths: [ll_points],
                map: map,
                editable: true,
                draggable: true
            });
            initDrawManager = false;
        }
        var drawn_polygon = null,
            polygon = null,
            coordsStr = '';
        setCoordsStr = function (path) {
            var data = [];
            path.getPath().getArray().forEach(function (point, i) {
                data.push({lat: point.lat(), lng: point.lng()});
            });
            coordsStr = JSON.stringify(data);
            $('.js-area-coords').val(coordsStr);
            return data;
        };

        if (initDrawManager) {
            var drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: false,
                polygonOptions: {
                    editable: true,
                    draggable: true
                },
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
                drawingManager.setDrawingMode(null);
            });
            google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
                drawn_polygon = polygon;
                setCoordsStr(polygon);
                google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
                    setCoordsStr(polygon);
                });
                google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
                    setCoordsStr(polygon);
                });
                google.maps.event.addListener(polygon.getPath(), 'remove_at', function () {
                    setCoordsStr(polygon);
                });
                google.maps.event.addListener(polygon.getPath(), 'dragend', function () {
                    setCoordsStr(polygon);
                });
            });
        } else {
            drawn_polygon = l_polygon;
            polygon = l_polygon;
            google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
                setCoordsStr(polygon);
            });
            google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
                setCoordsStr(polygon);
            });
            google.maps.event.addListener(polygon.getPath(), 'remove_at', function () {
                setCoordsStr(polygon);
            });
            google.maps.event.addListener(polygon.getPath(), 'dragend', function () {
                setCoordsStr(polygon);
            });
        }
    }

    $('form button.btn-danger[type=submit]').click(function (ev) {
        ev.preventDefault();
        if (confirm(window.locale.confirm)) {
            $(this).parents('form').submit();
        }
    });

    $('.js-delivery-boy').change(function () {
        $(this).parents('form').submit();
    });
});