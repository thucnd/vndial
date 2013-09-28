var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            //Param store infomation
            var params ='';
            
            $('#setting-save').click(function(){
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
    }
    
    var successCallBack = function(json) {
        var result = jQuery.parseJSON(json);
        var _msg = '';
        if(result.status == 1) { 
            $('#msg').empty();
            _msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+result.message+'</div>';
             $("#msg").append(_msg);
        }else{ 
            if(typeof(result.errors)!=='undefined'){
                $('#msg').empty();
                $("#msg").append("<div class=\"err_box\"><ul id=\"errmsg\"></ul></div>");
                for (var i = 0; i < result.errors.length; i++) {
                    $("#errmsg").append("<li>"+result.errors[i].message+"</li>");
                }
            }
            window.scrollTo(0,0);
            return;
        }
    }
    
    ajaxSendTxt($('form#setting-form').serialize(), successCallBack, errorCallBack, "/setting/plivo_save", "POST", false);
}




