var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            //Param store infomation
            var params ='';
            // click save
            $('#tts-save').click(function(){
                params = 1;
                save(params);
                return false;
            });

            $('#tts-back').click(function(){
                location.href='/tts';
                return false;
            });

            $('#tts-save-continue').click(function(){
                params = 2;
                save(params);
                return false;
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
        $('div#msg').empty();
        var _msg = '<p class="ng-message" style="color: red;">'+data.statusText+'</p>';
        $('div#msg').append(_msg);
        $("div#msg").fadeIn("fast", function() {
            return $(this).fadeOut(10000);
        });
    }
    
    var successCallBack = function(json) {
        var result = jQuery.parseJSON(json);
        
        $('div#msg').empty();
        var _msg = '';
        if(result.status == 1) {
            _msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Save sucess</div>';
            if(params == 1) {
                location.href='/tts';
            } 
        }else{ // failed to delete
            if(typeof(result.errors)!=='undefined'){
                $('#msg').empty();
                $("#msg").append('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'+result.errors[0].message+'</div>');
            }
            window.scrollTo(0,0);
            return;
        }
        $('#msg').append(_msg);
    }
    ajaxSendTxt($('form#tts-form').serialize(), successCallBack, errorCallBack, "/"+controller+"/save", "POST", false);
}




