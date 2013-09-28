var url = '';
var datatype = '';
var tableHeader = [];
var test = function(com, grid) {
    if (com == 'Delete') {
        confirm('Delete ' + $('.trSelected', grid).length + ' items?')
    } else if (com == 'Add') {
        alert('Add New Item');
    }
};
var buttons = [ {
    name : 'Add',
    bclass : 'add',
    onpress : test
}, {
    name : 'Delete',
    bclass : 'delete',
    onpress : test
}, {
    separator : true
} ];
var searchItems = [];
var tblTitle = 'VN Dial Table';

/**
 * Common js function
 */
function ajaxSendTxt(objData, successCallback, errorCallback, url, method, async){
    $.ajax({
        'url': url,
        'type': method,
        'async':async,
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
        var result = jQuery.parseJSON(json);
        $.each(result, function(key, value){
            $.each(value, function(key, value){
                
                var _col = {
                    display : value,
                    name : key,
                    width : 80,
                    sortable : true,
                    align : 'center'
                };
                var _sItem = {
                    display : value,
                    name : key
                };
                tableHeader.push(_col);
                searchItems.push(_sItem);
            });
        });
        
        _displayTable('', 'table.vndial-table', tableHeader, buttons, searchItems);
    }
    
    var errorCallBack = function() {
        alert('failed');
    }
    
    ajaxSendTxt(data, successCallBack, errorCallBack, "exec", "POST", false);
}

/**
 * Display table with inital configuration: show/hide, button actions, searched items
 * @param string Posted url
 * @param string clzName Class name
 * @param array tableHeader Table header
 * @param array btns Buttons action
 * @param array searchItems Searched items
 */
function _displayTable(url, clzName, tableHeader, btns, searchItems) {
    $(clzName).flexigrid({
        url : url,
        dataType : 'xml',
        colModel : tableHeader,
        buttons : btns,
        searchitems : searchItems,
        sortname : "iso",
        sortorder : "asc",
        usepager : true,
        title : 'Countries',
        useRp : true,
        rp : 15,
        showTableToggleBtn : true,
        width : '100%',
        height : 300
    });

    
}