var url = '';
var datatype = 'json';
var tableHeader = [];
var searchItems = [];
var tblTitle = '';
var controller = '';

/**
 * Common js function
 */
function ajaxSendTxt(objData, successCallback, errorCallback, url, method, async) {
    $.ajax({
        'url': url,
        'type': method,
        'async': async,
        'data': objData,
        'timeout': 120000,
        'error': errorCallback,
        'success': successCallback
                //        'complete': completeCallback
    });
}

function parseHeader() {
    var data = {
        header: "header"
    };
    var successCallBack = function(json) {
        var result = eval("(" + json + ")");
        if (result.status == 1) {
            $.each(result.results, function(key, value) {
                var sortable = false;
                if (value.sorting != 'undefined') {
                    sortable = value.sorting;
                }
                var _col = {
                    display: value.name,
                    name: key,
                    width: value.width,
                    sortable: sortable,
                    align: value.align
                };
                var _sItem = {
                    display: value.name,
                    name: key
                };
                tableHeader.push(_col);
                searchItems.push(_sItem);
            });
            _displayTable(controller + '/process', 'table.vndial-table', tableHeader, searchItems);
        }
    }

    var errorCallBack = function() {
        alert('failed');
    }

    ajaxSendTxt(data, successCallBack, errorCallBack, controller + "/exec", "GET", false);
}

/**
 * Display table with inital configuration: show/hide, button actions, searched items
 * @param string Posted url
 * @param string clzName Class name
 * @param array tableHeader Table header
 * @param array btns Buttons action
 * @param array searchItems Searched items
 */
function _displayTable(url, clzName, tableHeader, searchItems) {
    var tbWidth = '';
    var tbHeight = '';
    if ($('input[type=hidden]#default-width').val() != '100%') {
        tbWidth = parseInt($('input[type=hidden]#default-width').val());
    } else {
        tbWidth = $('input[type=hidden]#default-width').val();
    }

    if ($('input[type=hidden]#default-height').val() != '100%') {
        tbHeight = parseInt($('input[type=hidden]#default-height').val());
    } else {
        tbHeight = $('input[type=hidden]#default-height').val();
    }

    var wizard = $('.bTable').btable({
        url: url,
        dataType: datatype,
        colModel: tableHeader,
        //  searchitems : searchItems,
        sortname: $('input[type=hidden]#default-sort').val(),
        sortorder: "asc",
        usepager: true,
        showToggleBtn: false,
        title: tblTitle,
        useRp: true,
        rp: 15,
        showTableToggleBtn: false,
        resizable: false,
        dblClickResize: true,
        tblClass: 'table-bordered table-hover table-responsive',
        showTableToggleBtn: true,
                width: 700,
        height: 200
    });
}

/**
 * Get date time
 * @param {type} dateType
 * @returns {String}
 */
function getDatePicker(dateType) {
    var today = new Date();
    var day = today.getDate();
    var month = today.getMonth() + 1; //January is 0!
    var year = today.getFullYear();
    switch (dateType) {
        case 'today':
            return {
                'start' : month + '/' + day + '/' + year
               ,'end' : month + '/' + day + '/' + year
            };
            break;
        case 'yesterday':
            var dateEnd = new Date(today.setDate(today.getDate() - 1));
            if ((day - 1) <= 0) {
                month = month - 1;
                if (month == 0) {
                    month = 12;
                    year = year - 1;
                }
            }
            return {
                'start' : month + '/' + dateEnd.getDate() + '/' + year
               ,'end' : month + '/' + day + '/' + year
            };
            break;
        case 'month':
            return {
                'start' : month + '/1/' + year
               ,'end' : month + '/' + day + '/' + year
            };
            break;
        case 'preMonth':
            month = month - 1;
            if(month == 0) {
                month = 12;
                year = year - 1;
            }
            var lastDateofTheMonth = new Date(year, month, 0);
            var lastDay = lastDateofTheMonth.getDate();
            return month + "/" + day + "/" + year;
            return {
                'start' : month + '/1/' + year
               ,'end' : month + "/" + lastDay + "/" + year
            };
            break;
        case 'lastWeek':
            var dateEnd = new Date(today.setDate(today.getDate()-7));
            if( (day - 7)<= 0) {
                month = month - 1;
                if(month == 0) {
                    month = 12;
                    year = year - 1;
                }
            }
            return {
                'start' : month + "/" + dateEnd.getDate() + "/" + year
               ,'end' : month + "/" + day + "/" + year
            };
            break;
        default:
            return {'error': 'invalid'};
            break;
    }
    return {'error': 'invalid'};
}

/**
 * init datePicker
 * @param {string} startDate
 * @param {string} endDate
 * @param {int} disDate - Disable Date from today
 * @returns {undefined}
 */
function displayDatePicker(startDate, endDate, disDate) {
    // Set start_time and end_time
    var nowTemp = new Date();
    var now = new Date();
    if (typeof(disDate) != "undefined") {
        now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate() - disDate, 0, 0, 0, 0);
    }

    var checkin = $(startDate).datepicker({
        onRender: function(date) {
            return ((typeof(disDate) != "undefined") && (date.valueOf() < now.valueOf())) ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $(endDate)[0].focus();
    }).data('datepicker');
    var checkout = $(endDate).datepicker({
        onRender: function(date) {
            return ((typeof(disDate) != "undefined") && (date.valueOf() <= checkin.date.valueOf())) ? 'disabled' : '';
        }
    }).on('changeDate', function() {
        checkout.hide();
    }).data('datepicker');
}

/**
* Get Id list

 * @returns {Array} */
function _getIdList() {
    var ids = [];
    $('input.child-tickbox').each(function(index, element) {
        if ($(this).is(':checked')) {
            ids.push($(this).attr('name'));
        }

    });

    return ids;
}

function reloadDataTable() {
    _displayTable(controller + '/process', 'table.vndial-table', tableHeader, buttons, searchItems);
}

$(function() {
    $(document).ready(
            function() {
                if (typeof $('.message_box').val() !== 'undefined') {
                    setTimeout(function() {
                        $('.message_box').hide();
                    }, 5000);
                }

                $('#tool-btn-new').click(function() {
                    handleAdd();
                });

                $('#tool-btn-delete').click(function() {
                    if (confirm('Are you sure?')) {
                        handleDelete();
                    }
                });

                function handleDelete() {
                    var ids = _getIdList();

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
                        $('div#alert-msg').empty();
                        var _msg = '';
                        if (result.status == 1) { // delete ok
                            _msg = '<p class="ok-message" style="color: green;">' + result.message + '</p>';

                            // reload table after delete successfully
                            reloadDataTable();
                        } else { // failed to delete
                            _msg = '<p class="ng-message" style="color: red;">' + result.message + '</p>';
                        }
                        $('div#alert-msg').append(_msg);
                        $("div#alert-msg").fadeIn("fast", function() {
                            return $(this).fadeOut(10000);
                        });
                    }
                    ajaxSendTxt({
                        'ids': ids
                    }, successCallBack, errorCallBack, controller + "/delete", "POST", false);
                }

                function handleAdd() {
                    location.href = location.pathname + '/add';
                }

                // handle click tick-box
                $('input.thead-tickbox').on('change', function() {
                    var _isTicked = false;
                    if ($('input.thead-tickbox').is(':checked')) {
                        _isTicked = true;
                    }

                    $('.vndial-table > tbody > tr').each(function() {
                        if (_isTicked) {
                            $(this).addClass('trSelected');
                        } else {
                            $(this).removeClass('trSelected');
                        }
                    });

                    $('input.child-tickbox').each(function(index, element) {
                        if (_isTicked) {
                            $(this).attr('checked', 'checked');
                        } else {
                            $(this).removeAttr('checked');
                        }

                    });

                });
            });
});