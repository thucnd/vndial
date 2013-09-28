var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            //Param store infomation
            var params ='';
            
            $('#recording-save').click(function(){
                $("#recording-form").submit();
                return false;
            });
                
            $('#recording-back').click(function(){
                location.href='/' + controller;
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
            _msg = '<p class="ok-message" style="color: green;">'+result.message+'</p>';
        }else{ 
            _msg = '<p class="ng-message" style="color: red;">'+result.message+'</p>';
        }
        $('div#alert-msg').append(_msg);
        $("div#alert-msg").fadeIn("fast", function() {
            return $(this).fadeOut(10000);
        });
    }
    
    ajaxSendTxt($('form#recording-form').serialize(), successCallBack, errorCallBack, "/" + controller + "/save", "POST", false);
}

function startCallback() {
    // viết code khi click nút upload và bắt đầu upload.
    
    return true;
}
 
function completeCallback(json) {
    var output = json.replace(/<\/?[^>]+(>|$)/g, "");
    var jsondata = eval("(" + output + ")");
    $('div#msg').empty();
    var _msg = '';
    if (jsondata.status == "1") {
        _msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Save sucess</div>';
        location.href='/recording';
    } else {
        if(typeof(jsondata.errors)!=='undefined'){
            $('#msg').empty();
            $("#msg").append('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'+jsondata.errors[0].message+'</div>');
        }
        window.scrollTo(0,0);
        return;
        
    }
    $('#msg').append(_msg);
}


