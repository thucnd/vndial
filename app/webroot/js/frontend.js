var thisName = location.pathname.split('/')[1];

$(function() {
    $(document).ready(
            function() {
                displayDatePicker('#start_at', '#stop_at');
                $('#report-search').click(function() {
                    var data = {
                         'start_at': $('#start_date').val()
                        ,'stop_at': $('#stop_date').val()
                    };
                    var errorCallBack = function(data) {
                        $('div#alert-msg').empty();
                        var _msg = '<p class="ng-message" style="color: red;">' + data.statusText + '</p>';
                        $('div#alert-msg').append(_msg);
                        $("div#alert-msg").fadeIn("fast", function() {
                            return $(this).fadeOut(10000);
                        });
                    }

                    var successCallBack = function(json) {
                        var result = jQuery.parseJSON(json);
                        var _msg = '';
                        if (result.status == 1) {
                            var callReport = $.jqplot('callReport',
                                    [[
                                            ['ANSWER', result.data.ANSWER],
                                            [' BUSY', result.data.BUSY],
                                            [' NOANSWER', result.data.NOANSWER],
                                            [' REJECTED', result.data.REJECTED],
                                            [' CONGESTION', result.data.CONGESTION],
                                            [' OTHER', result.data.OTHER]
                                ]], {
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
                        } 
                    }
                    ajaxSendTxt(data, successCallBack, errorCallBack, "/frontend/exec", "POST", false);
                });
            });
});