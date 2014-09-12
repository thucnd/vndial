var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            //Init Date Picker
            displayDatePicker('#start_at','#stop_at',0);
            // Init Time Picker
            $('#start_time').timepicker();
            $('#end_time').timepicker();
            
            //Param store infomation
            var params ='';
            // click save
            $('#campaign-save').click(function(){
                params = 1;
                save(params);
                return false;
            });

            $('#campaign-back').click(function(){
                location.href='/campaign';
                return false;
            });

            $('#campaign-save-continue').click(function(){
                params = 2;
                save(params);
                return false;
            });
            
            $('#camp_type_id').change(function(){
                update();
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
    var errorCallBack = function(data) {
        $('div#alert-msg').empty();
        var _msg = '<p class="ng-message" style="color: red;">'+data.statusText+'</p>';
        $('div#alert-msg').append(_msg);
        $("div#alert-msg").fadeIn("fast", function() {
            return $(this).fadeOut(10000);
        });
    }
    
    var successCallBack = function(json) {
        var result = jQuery.parseJSON(json);
        
        $('div#msg').empty();
        var _msg = '';
        if(result.status == 1) {
            _msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Save sucess</div>';
            if(params === 1) {
                location.href='/campaign';
            }
        }else{
            if(typeof(result.errors)!=='undefined'){
                $('#msg').empty();
                $("#msg").append('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'+result.errors[0].message+'</div>');
            }
            window.scrollTo(0,0);
            return;
        }
        $('div#msg').append(_msg);
    }
    ajaxSendTxt($('form#campaign-form').serialize(), successCallBack, errorCallBack, "/"+controller+"/save", "POST", false);
}

/**
 * Get data follow campaign type
 */
function update() {
    var data = {
        'campaign_type_id' : $('#camp_type_id').val()
    };
    
    var errorCallBack = function(data) {
        $('div#alert-msg').empty();
        var _msg = '<p class="ng-message" style="color: red;">'+data.statusText+'</p>';
        $('div#alert-msg').append(_msg);
        $("div#alert-msg").fadeIn("fast", function() {
            return $(this).fadeOut(10000);
        });
    }
    
    var successCallBack = function(json) {
        var data = jQuery.parseJSON(json);
        if(data.status == 1) {
            $('#app_type_id').empty();
            for (var i = 0; i < data.results.length; i++) {
                if(parseInt($('#camp_type_id').val()) === 1) {
                    $("#app_type_id").append('<option value="' + data.results[i]['Recording']['recording_id'] + '">' + data.results[i]['Recording']['name']+ '</option>');
                } else if(parseInt($('#camp_type_id').val()) === 2) {
                    $("#app_type_id").append('<option value="' + data.results[i]['Survey']['survey_id'] + '">' + data.results[i]['Survey']['question']+ '</option>');
                } else {
                    $("#app_type_id").append('<option value="' + data.results[i]['Tts']['tts_id'] + '">' + data.results[i]['Tts']['name']+ '</option>');
                }
            }
        }    
    }
    ajaxSendTxt(data, successCallBack, errorCallBack, "/"+controller+"/update", "POST", false);
}



