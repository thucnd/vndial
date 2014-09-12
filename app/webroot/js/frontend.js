var thisName = location.pathname.split('/')[1];

$(function() {
    $(document).ready(
            function() {
                displayDatePicker('#start_at','#stop_at');
                var callReport = $.jqplot('callReport', [[['ANSWER', 25], [' BUSY', 14], [' NOANSWER', 7], ['CANCEL', 7], [' CONGESTION', 7], ['FAILED', 7]]], {
                    gridPadding: {top: 0, bottom: 38, left: 0, right: 0},
                    seriesDefaults: {
                        renderer: $.jqplot.PieRenderer,
                        trendline: {show: true},
                        rendererOptions: {padding: 8, showDataLabels: true}
                    },
                    legend: {
                        show: true,
                        placement: 'outside',
                        marginTop: '15px'
                    }
                });
                
            });
});