var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            //Param store infomation
            var params ='';
            
            $('#contact-save').click(function(){
                console.log('saving...');
                params.type = 'save';
                save(params);
                location.href='/' + controller;
                return false;
            });
                
            $('#contact-back').click(function(){
                location.href='/' + controller;
                return false;
            });
                
            $('#contact-save-continue').click(function(){
                console.log('saving...');
                params.type = 'save';
                save(params);
                location.href='/' + controller + '/add';
                return false;
            });
            
            $('#contact-update-continue').click(function(){
                console.log('saving...');
                params.type = 'save';
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
            _msg = '<p class="ok-message" style="color: green;">'+result.message+'</p>';
        }else{ 
            _msg = '<p class="ng-message" style="color: red;">'+result.message+'</p>';
        }
        $('div#alert-msg').append(_msg);
        $("div#alert-msg").fadeIn("fast", function() {
            return $(this).fadeOut(10000);
        });
    }
    
    ajaxSendTxt($('form#contact-form').serialize(), successCallBack, errorCallBack, "/" + controller + "/save", "POST", false);
}




