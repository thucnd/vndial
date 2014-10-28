var thisName = location.pathname.split('/')[1];

$(function() {
    $(document).ready(
            function() {
                //init datePicker
                displayDatePicker('#start_at', '#stop_at');
                setDatePicker("lastWeek");
                //Display today
                $("#report-today").click(function(){setDatePicker("today");});
                //Display yesterday
                $("#report-yesterday").click(function(){setDatePicker("yesterday");});
                //Display this month
                $("#report-this-month").click(function(){setDatePicker("month");});                
                /**
                 * Set Date Picker
                 * @param {type} dateType
                 * @returns {undefined}
                 */
                function setDatePicker(dateType){
                    var datePicker = getDatePicker(dateType);
                    $("#start_date").val(datePicker["start"]);
                    $("#stop_date").val(datePicker["end"]);
                }
                /*Display Report information*/
                $("#report-search").click(function() {
                    var params = {
                        'start' : $('#start_date').val()
                       ,'end': $('#stop_date').val()
                    };

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
});