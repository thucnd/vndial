var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            var params ='';
            $('#survey-save').click(function(){
                params = 1;
                save(params);
                return false;
            });

            $('#survey-back').click(function(){
                location.href='/survey';
                return false;
            });

            $('#repone-save').click(function(){
                if($('#edit').length && $('#edit') !== undefined) {
                    respondUpdate();
                } else {
                    if(!checkRespond($('#digit_id').val())) {
                        alert('Digit has exist');
                        return false;
                    } else {
                        respondAdd();
                    }
                }
            });
            
            $('#add_response').click(function(){
                // remove edit status
                $('#edit').remove();
                $('#digit_id').removeAttr('disabled');
                $('#digit_value').val('');
            });
            
            $('#repone-close').click(function(){
                $('#digit_id').removeAttr('disabled');
            });
            
            $('#form-close').click(function(){
                $('#digit_id').removeAttr('disabled');
            });
        });
});

/*
* save: Using Ajax update infomation for Dialer settings
*
* @param params
*
*/
function save(params){
    var response = new Array();
    for (var i=0; i<10; i++) {
        if($('#key_' + i).length && $('#key_' + i) !== undefined) {
            response.push($('#key_' + i).html());
        }
    }
    var data = {
        'question': $('#question').val()
        ,
        'description': $('#description').val()
        ,
        'recording_id': $('#recording_id').val()
        ,
        'response' : response
    };
    
    if($('#survey_id').length && $('#survey_id') !== undefined) {
        data['survey_id'] = $('#survey_id').val();
        data['target'] = 'update';
    } else {
        data['target'] = 'add';
    }
    
    var errorCallBack = function(data) {
        $('div#msg').empty();
        var _msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button> Error</div>';
        $('div#msg').append(_msg);
        window.scrollTo(0,0);
    }
    
    var successCallBack = function(json) {
        var result = jQuery.parseJSON(json);
        $('div#msg').empty();
        var _msg = '';
        if(result.status == 1) { 
            _msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Save sucess</div>';
            if(params === 1) {
                location.href='/' + controller;
            }
        }else{ 
            _msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'+result.errors[0].message+'</div>';
        }
        
        $('div#msg').append(_msg);
        window.scrollTo(0,0);
        
    }
    ajaxSendTxt(data, successCallBack, errorCallBack, "/"+controller+"/save", "POST", false);
}

/**
 * Update param information
 * 
 * @params
 */
function update(data) {
   
    var errorCallBack = function(data) {
        $('div#msg').empty();
        var _msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button> Error</div>';
        $('div#msg').append(_msg);
        window.scrollTo(0,0);
    }
    
    var url = "/"+controller+"/update";
    
    var successCallBack = function(json) {
        var result = jQuery.parseJSON(json);
        $('div#msg').empty();
        var _msg = '';
        if(result.status == 1) { 
            _msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Save sucess</div>';
        }else{ 
            _msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'+result.errors[0].message+'</div>';
        }
        
        $('div#msg').append(_msg);
        window.scrollTo(0,0);
        
    }
    ajaxSendTxt(data, successCallBack, errorCallBack, url, "POST", false);
}

/**
 *  Create new respond
 */
function respondAdd() {
    $('#edit').remove();
    var survey_type = $('#survey_type_id').val();
    var digit = $('#digit_id').val();
    var digitValue = $('#digit_value').val();
    var surveyName = new Array("Get repones", "Transfer call", "Recording");
    
    var jsonData = {
        'survey_type': survey_type
        ,
        'key_digit': digit
        ,
        'key_value' : digitValue
    };
    
    if($('#survey_id').length && $('#survey_id') !== undefined) {
        var respond = jQuery.parseJSON($('#key_' + digit).html());
        jsonData['survey_id'] =  $('#survey_id').val();
        update(jsonData);
    }
    
    var data = ' <div id = "row_' + digit + '" class="line-box"><div style="display:none;" id = "key_' + digit + '">' + JSON.stringify(jsonData) + '</div><strong>Key ' + digit + ':</strong>   Survey type: ' + surveyName[survey_type] + ' , Digit value: ' + digitValue + '   <a href="#myModal" data-toggle="modal" onClick="edit(' + digit + ')"><i class="icon-edit"></i></a><a style="cursor: pointer;" onClick="remove(' + digit + ')"><i class="icon-remove"></i></a></div> ';
    $('#repone-data').append(data);
    $('#digit_id').removeAttr('disabled');
}

/**
 * Update a respond
 *
 */
function respondUpdate() {
    var survey_type = $('#survey_type_id').val();
    var digit = $('#digit_id').val();
    var digitValue = $('#digit_value').val();
    var surveyName = new Array("Get repones", "Transfer call", "Recording");
    
    var jsonData = {
        'survey_type': survey_type
        ,
        'key_digit': digit
        ,
        'key_value' : digitValue
    };
    
    if($('#survey_id').length && $('#survey_id') !== undefined) {
        var respond = jQuery.parseJSON($('#key_' + digit).html());
        jsonData['response_id'] = respond.response_id;
        jsonData['survey_id'] =  $('#survey_id').val();
        update(jsonData);
    }

    var data = ' <div id = "row_' + digit + '" class="line-box"><div style="display:none;" id = "key_' + digit + '">' + JSON.stringify(jsonData) + '</div><strong>Key ' + digit + ':</strong>   Survey type: ' + surveyName[survey_type] + ' , Digit value: ' + digitValue + '   <a href="#myModal" data-toggle="modal" onClick="edit(' + digit + ')"><i class="icon-edit"></i></a><a style="cursor: pointer;" onClick="remove(' + digit + ')"><i class="icon-remove"></i></a></div> ';
    $('#row_' + digit).empty();
    $('#row_' + digit).append(data);
    $('#digit_id').removeAttr('disabled');
    $('#edit').remove();
}

/**
 * check digit exist or not ?
 * 
 */
function checkRespond(digit) {
    if($('#row_' + digit).length && $('#row_' + digit) !== undefined) {
        return false;
    }
    return true;
}

/**
 * Remove respond
 */
function remove(digit) {
    $('#row_' + digit).remove();
}

/**
 *  Edit respond
 */
function edit(digit) {
    var jsonData = jQuery.parseJSON($('#key_' + digit).html());
    $('#digit_id').val(digit);
    $('#survey_type_id').val([jsonData.survey_type]);
    $('#digit_value').val(jsonData.key_value);
    
    $('#digit_id').attr('disabled', 'disabled');
    $('#modal-footer').append('<input type="hidden" name="edit" id="edit"/>');
}