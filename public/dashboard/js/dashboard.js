(function ($) {
    'use strict';
    $(function () {
        if ($('#product-area-chart').length) {
            let lineChartCanvas = $("#product-area-chart").get(0).getContext("2d");
            let data = {
                labels: ["2013", "2014", "2014", "2015", "2016", "2017", "2018"],
                datasets: [
                    {
                        label: 'Support',
                        data: [150, 200, 150, 200, 350, 320, 400],
                        backgroundColor: 'rgba(70, 77, 228, 0.3)',
                        borderColor: [
                            'rgba(70, 77, 228, 1)'
                        ],
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Product',
                        data: [300, 400, 300, 440, 700, 550, 730],
                        backgroundColor: 'rgba(217, 225 ,253, 1)',
                        borderColor: [
                            'rgba(70, 77, 228, 1)'
                        ],
                        borderWidth: 1,
                        fill: true
                    }
                ]
            };
            let options = {
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 3
                    }
                },
                stepsize: 1
            };
            let lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: data,
                options: options
            });
        }
        if ($('#morris-line-example').length) {
            Morris.Line({
                element: 'morris-line-example',
                lineColors: ['rgba(70, 77, 228, 0.8)', 'rgba(217, 225 ,253, 1)'],
                data: [{
                    y: '2006',
                    a: 50,
                    b: 0
                },
                    {
                        y: '2007',
                        a: 75,
                        b: 78
                    },
                    {
                        y: '2008',
                        a: 30,
                        b: 12
                    },
                    {
                        y: '2009',
                        a: 35,
                        b: 50
                    },
                    {
                        y: '2010',
                        a: 70,
                        b: 100
                    },
                    {
                        y: '2011',
                        a: 78,
                        b: 65
                    }
                ],
                grid: false,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Series A', 'Series B'],
                hideHover: "always"
            });
        }
        if ($("#current-chart").length) {
            let CurrentChartCanvas = $("#current-chart").get(0).getContext("2d");
            let CurrentChart = new Chart(CurrentChartCanvas, {
                type: 'bar',
                data: {
                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                    datasets: [{
                        label: 'Profit',
                        data: [330, 380, 230, 400, 309, 530, 340, 200],
                        backgroundColor: 'rgba(70, 77, 228, 1)'
                    },
                        {
                            label: 'Target',
                            data: [600, 600, 600, 600, 600, 600, 600],
                            backgroundColor: 'rgba(238, 242, 245, 1)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 0
                        }
                    },
                    scales: {
                        yAxes: [{
                            display: false,
                            gridLines: {
                                display: false
                            }
                        }],
                        xAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#354168"
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                display: false
                            },
                            barPercentage: 0.4
                        }]
                    },
                    legend: {
                        display: false
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        }
    });
})(jQuery);

$(document).ready(function ($) {
    'use strict';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.App.csrfToken
        }
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    $('.dropify').dropify();

    $(".validate").validate({
        lang: window.App.locale,
        errorPlacement: function (label, element) {
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        },
        highlight: function (element, errorClass) {
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
        }
    });

    let $editor = $(".editor");
    if ($editor.length) {
        let quill = new Quill('.editor', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image'],
                    [
                        {'direction': window.App.dir},
                        {'align': window.App.align},
                    ],
                ]
            },
            placeholder: 'Compose an epic...',
            theme: 'snow',
        });

        quill.format('direction', window.App.dir);
        quill.format('align', window.App.align);

        let $form = $editor.parents('form');
        $form.submit(function () {
            let input = $(this).find('[name=' + $editor.data('name') + ']');
            input.val($editor.find('.ql-editor').html());

            // console.log(JSON.stringify(quill.getContents()));
        });
    }

    $('[data-destroy]').click(function (e) {
        e.preventDefault();

        let $trigger = $(this);
        if (confirm(window.locale.confirm)) {
            $.ajax({
                url: $trigger.attr('href'),
                method: 'post',
                data: {_method: 'delete'},
            }).done(function () {
                let $parent;
                if ($trigger.attr('data-destroy')) {
                    $parent = $trigger.parents($trigger.attr('data-destroy'));
                } else {
                    $parent = $trigger.parents('tr');
                }

                $parent.fadeOut('fast', function () {
                    $parent.parents('tr').remove();
                });
            });
        }
    });

    if ($(".datepicker").length) {
        $(".datepicker").datepicker({
            enableOnReadonly: true,
            todayHighlight: true,
        });
    }

    // delivery area map
    if ($('#delivery_area_map').length > 0) {
        let latlng = new google.maps.LatLng(41.0146233, 28.9415103),
            myOptions = {
                zoom: 11,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: latlng
            },
            map = new google.maps.Map(document.getElementById("delivery_area_map"), myOptions),
            initDrawManager = true;
        if ($('.js-area-coords').val() != '') {
            let points = $.parseJSON($('.js-area-coords').val()),
                ll_points = [];
            points.forEach(function (itm, ind) {
                ll_points.push(new google.maps.LatLng(itm.lat, itm.lng));
            });
            let l_polygon = new google.maps.Polygon({
                paths: [ll_points],
                map: map,
                editable: true,
                draggable: true
            });
            initDrawManager = false;
        }
        let drawn_polygon = null,
            polygon = null,
            coordsStr = '';

        let setCoordsStr = function (path) {
            let data = [];
            path.getPath().getArray().forEach(function (point, i) {
                data.push({lat: point.lat(), lng: point.lng()});
            });
            coordsStr = JSON.stringify(data);
            $('.js-area-coords').val(coordsStr);
            return data;
        };

        if (initDrawManager) {
            let drawingManager = new google.maps.drawing.DrawingManager({
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
});

$(document).ready(function () {
    // enable fileuploader plugin
    $('input[fileuploader]').fileuploader({
        limit: 15,
        fileMaxSize: 7,
        // extensions: ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
        changeInput: ' ',
        theme: 'thumbnails',
        enableApi: true,
        addMore: true,
        editor: {
            cropper: {
                ratio: '16:9',
                minWidth: 1280,
                minHeight: 720,
                showGrid: true
            }
        },
        thumbnails: {
            box: '<div class="fileuploader-items">' +
            '<ul class="fileuploader-items-list">' +
            '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
            '</ul>' +
            '</div>',
            item: '<li class="fileuploader-item file-has-popup">' +
            '<div class="fileuploader-item-inner">' +
            '<div class="type-holder">${extension}</div>' +
            '<div class="actions-holder">' +
            '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i></i></a>' +
            '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
            '</div>' +
            '<div class="thumbnail-holder">' +
            '${image}' +
            '<span class="fileuploader-action-popup"></span>' +
            '</div>' +
            '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
            '<div class="progress-holder">${progressBar}</div>' +
            '</div>' +
            '</li>',
            item2: '<li class="fileuploader-item file-has-popup">' +
            '<div class="fileuploader-item-inner">' +
            '<div class="type-holder">${extension}</div>' +
            '<div class="actions-holder">' +
            '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="${captions.download}" download><i></i></a>' +
            '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i></i></a>' +
            '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
            '</div>' +
            '<div class="thumbnail-holder">' +
            '${image}' +
            '<span class="fileuploader-action-popup"></span>' +
            '</div>' +
            '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
            '<div class="progress-holder">${progressBar}</div>' +
            '</div>' +
            '</li>',
            startImageRenderer: true,
            canvasImage: false,
            _selectors: {
                list: '.fileuploader-items-list',
                item: '.fileuploader-item',
                start: '.fileuploader-action-start',
                retry: '.fileuploader-action-retry',
                remove: '.fileuploader-action-remove'
            },
            onItemShow: function (item, listEl, parentEl, newInputEl, inputEl) {
                let plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                plusInput.insertAfter(item.html)[api.getOptions().limit && api.getChoosedFiles().length >= api.getOptions().limit ? 'hide' : 'show']();

                if (item.format == 'image') {
                    item.html.find('.fileuploader-item-icon').hide();
                }
            }
        },
        dragDrop: {
            container: '.fileuploader-thumbnails-input'
        },
        afterRender: function (listEl, parentEl, newInputEl, inputEl) {
            let plusInput = listEl.find('.fileuploader-thumbnails-input'),
                api = $.fileuploader.getInstance(inputEl.get(0));

            plusInput.on('click', function () {
                api.open();
            });
        },
        onRemove: function (item, listEl, parentEl, newInputEl, inputEl) {
            let plusInput = listEl.find('.fileuploader-thumbnails-input'),
                api = $.fileuploader.getInstance(inputEl.get(0));

            if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
                plusInput.show();
        },
        sorter: {
            selectorExclude: null,
            placeholder: null,
            scrollContainer: window,
            onSort: function (list, listEl, parentEl, newInputEl, inputEl) {
                let api = $.fileuploader.getInstance(inputEl.get(0)),
                    fileList = api.getFileList(),
                    _list = [];

                $.each(fileList, function (i, item) {
                    _list.push({
                        name: item.name,
                        index: item.index
                    });
                });

                // $.post('php/ajax_sort_files.php', {
                //     _list: JSON.stringify(_list)
                // });
            }
        },
    });
});