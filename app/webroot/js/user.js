var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
             var params ='';
            $('#user-save').click(function(){
                params = 1;
                save(params);
                return false;
            });

            $('#user-back').click(function(){
                location.href='/user';
                return false;
            });

            $('#user-save-continue').click(function(){
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
                location.href='/user';
            }
        }else{ 
            _msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'+result.errors[0].message+'</div>';
        }
        
        $('div#msg').append(_msg);
        window.scrollTo(0,0);
        
    }
    ajaxSendTxt($('form#user-form').serialize(), successCallBack, errorCallBack, "/"+controller+"/save", "POST", false);
}
