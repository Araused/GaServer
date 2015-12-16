$(document).ready(function () {
    var url = $('#site-index').attr('data-charturl');
    var useInterval = $('#site-index').attr('data-useinterval');
    var updateInterval = $('#site-index').attr('data-updateinterval');
    var plotData = [];
    var legends = [];
    if (url) {
        function interval() {
            console.log('tick');
            var dateObj = new Date();
            var currentTime = dateObj.getHours() + ":" + dateObj.getMinutes() + ":" + dateObj.getSeconds();

            $.getJSON(url, {
                browserTime: currentTime
            }, function (data) {
                plotData = [];
                $.each(data['data'], function (key, val) {
                    plotData.push({
                        data: val['data'],
                        label: key + ' (' + val['labelSuffix'] + ') = ' + val['lastValue'],
                        yaxis: val['type'] == 'ppm' ? 1 : 2,
                        roundTo: val['roundTo']
                    });
                });
                if (data['ppmMax'] != 0 && data['percentMax'] != 0) {
                    var plot = $.plot(".chart", plotData, {
                        xaxes: [
                            {
                                mode: 'time',
                                ticks: data['ticks'],
                                min: data['xMin'],
                                max: data['xMax'],
                                panRange: [plotData[0].data[0][0], plotData[0].data[plotData[0].data.length - 1][0]],
                                timezone: 'browser',
                                font: {
                                    size: 9,
                                    lineHeight: 13,
                                    family: "sans-serif",
                                    variant: "small-caps",
                                    color: "#545454"
                                }
                            }
                        ],
                        yaxes: [
                            {
                                min: 0,
                                max: data['ppmMax'],
                                panRange: [0, data['ppmMax']],
                                ticks: 10
                            },
                            {
                                min: 0,
                                max: data['percentMax'],
                                alignTicksWithAxis: 1,
                                position: "right",
                                panRange: [0, data['percentMax']],
                                ticks: 10
                            }],
                        legend: {
                            position: "sw"
                        },
                        pan: {
                            interactive: true
                        },
                        series: {
                            lines: {
                                show: true
                            }
                        },
                        crosshair: {
                            mode: "x"
                        },
                        grid: {
                            hoverable: true,
                            autoHighlight: false
                        }
                    });

                    legends = $(".chart .legendLabel");
                    var maxWidth = 0;

                    legends.each(function () {
                        var width = $(this).width() + 5;
                        if (width > maxWidth) {
                            maxWidth = width;
                        }
                        $(this).css('width', width);
                    });

                    $(".chart .legend > div:first-child").css('width', maxWidth);

                    var updateLegendTimeout = null;
                    var latestPosition = null;

                    function updateLegend() {
                        legends = $(".chart .legendLabel");

                        updateLegendTimeout = null;

                        var pos = latestPosition;

                        var axes = plot.getAxes();
                        if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max ||
                                pos.y < axes.yaxis.min || pos.y > axes.yaxis.max) {
                            return;
                        }

                        var i, j, dataset = plot.getData();
                        for (i = 0; i < dataset.length; ++i) {

                            var series = dataset[i];

                            for (j = 0; j < series.data.length; ++j) {
                                if (series.data[j][0] > pos.x) {
                                    break;
                                }
                            }

                            var y;
                            var p1 = series.data[j - 1];
                            var p2 = series.data[j];

                            if (p1 == null || p2 == null) {
                                y = 0;
                            } else {
                                y = p1[1] + (p2[1] - p1[1]) * (pos.x - p1[0]) / (p2[0] - p1[0]);
                            }
                            legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(dataset[i].roundTo)));
                        }
                    }

                    $(".chart").bind("plothover", function (event, pos, item) {
                        latestPosition = pos;
                        if (!updateLegendTimeout) {
                            updateLegendTimeout = setTimeout(updateLegend, 50);
                        }
                    });

                    function addHandler(object, event, handler, useCapture) {
                        if (object.addEventListener) {
                            object.addEventListener(event, handler, useCapture ? useCapture : false);
                        } else if (object.attachEvent) {
                            object.attachEvent('on' + event, handler);
                        } else {
                            alert("Add handler is not supported");
                        }
                    }

                    addHandler(window, 'DOMMouseScroll', movePlot);
                    addHandler(window, 'mousewheel', movePlot);
                    addHandler(document, 'mousewheel', movePlot);

                    function wheel(event) {
                        var delta;
                        event = event || window.event;
                        if (event.wheelDelta) {
                            delta = event.wheelDelta / 120;
                            if (window.opera) {
                                delta = -delta;
                            }
                        } else if (event.detail) {
                            delta = -event.detail / 3;
                        }
                        if (event.preventDefault) {
                            event.preventDefault();
                        }
                        event.returnValue = false;
                        return delta;
                    }

                    function movePlot(event) {
                        var delta = wheel(event);
                        plot.pan({
                            left: delta * 100
                        });
                    }
                } else {
                    $(".chart").html('<h1>Нет данных</h1>');
                }
            });
        }

        if (useInterval == '1') {
            setInterval(interval, updateInterval * 60000);
        }

        interval();

    }

    //Уже не актуально, но пусть будет
    var updateLinkUrl = $('.gadata-index').attr('data-charturl');
    if (updateLinkUrl) {
        var gaid = $('select[name="GadataSearch[GAID]"]').val();
        var date = $('input[name="GadataSearch[FDATE]"]').val();

        $('.gadata-index').on('change', 'select[name="GadataSearch[GAID]"]', function () {
            gaid = $(this).val();
            updateLink();
        });

        $('.gadata-index').on('change', 'input[name="GadataSearch[FDATE]"]', function () {
            date = $(this).val();
            updateLink();
        });

        function updateLink() {
            $.ajax({
                url: updateLinkUrl,
                type: 'GET',
                data: {
                    gaid: gaid,
                    date: date
                },
                success: function (data) {
                    $('.menu-chart-url').attr('href', data);
                }
            });
        }
    }
});