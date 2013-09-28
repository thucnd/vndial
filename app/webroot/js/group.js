var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            //Param store infomation
            var params ='';
            
            $('#group-save').click(function(){
                console.log('saving...');
                params.type = 'save';
                save(params);
                location.href='/contact_group';
                return false;
            });
                
            $('#group-back').click(function(){
                location.href='/contact_group';
                return false;
            });
                
            $('#group-save-continue').click(function(){
                console.log('saving...');
                params.type = 'save';
                save(params);
                location.href='/contact_group/add';
                return false;
            });
            
            $('#group-update-continue').click(function(){
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
    
    ajaxSendTxt($('form#group-form').serialize(), successCallBack, errorCallBack, "/"+controller+"/save", "POST", false);
}




