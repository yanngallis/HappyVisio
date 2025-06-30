import 'jquery-sparkline';

$(function () {
    let options = {
        lineColor: 'rgba(255, 255, 255, 0.6)',
        lineWidth: 2,
        spotColor: false,
        minSpotColor: false,
        maxSpotColor: false,
        highlightSpotColor: null,
        highlightLineColor: null,
        fillColor: 'rgba(255, 255, 255, 0.2)',
        chartRangeMin: 0,
        chartRangeMax: 20,
        width: '100%',
        height: 30,
        disableTooltips: true
    }

    $('#compositeline').sparkline('html', options);
    $('#compositeline2').sparkline('html', options);
    $('#compositeline3').sparkline('html', options);
    $('#compositeline4').sparkline('html', options);
});