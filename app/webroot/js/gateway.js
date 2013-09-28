var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            //Param store infomation
            var params ='';
            // click save
            $('#gateway-save').click(function(){
                console.log('saving...');
                params = 1;
                save(params);
                return false;
            });

            $('#gateway-back').click(function(){
                location.href='/gateway';
                return false;
            });

            $('#gateway-save-continue').click(function(){
                console.log('saving...');
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
        $('div#alert-msg').empty();
        var _msg = '<p class="ng-message" style="color: red;">'+data.statusText+'</p>';
        $('div#alert-msg').append(_msg);
        $("div#alert-msg").fadeIn("fast", function() {
            return $(this).fadeOut(10000);
        });
    }
    
    var successCallBack = function(json) {
        var result = jQuery.parseJSON(json);
        
        $('div#alert-msg').empty();
        var _msg = '';
        if(result.status == 1) {
            if(params == 1) {
                location.href='/gateway';
            } else {
                location.href='/gateway/add';
            }
        }else{ // failed to delete
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
        $('div#alert-msg').append(_msg);
        $("div#alert-msg").fadeIn("fast", function() {
            return $(this).fadeOut(10000);
        });
    }
    ajaxSendTxt($('form#gateway-form').serialize(), successCallBack, errorCallBack, "/"+controller+"/save", "POST", false);
}




