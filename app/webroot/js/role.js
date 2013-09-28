var thisName = location.pathname.split('/')[1];

$(function(){
    $(document).ready(
        function() {
            var params ='';
            $('#role-save').click(function(){
                params = 1;
                save(params);
                return false;
            });

            $('#role-back').click(function(){
                location.href='/role';
                return false;
            });

            $('#role-save-continue').click(function(){
                params = 2;
                save(params);
                return false;
            });
            
            // check all
            $('#role_check_all').click(function(){
                $("input[name='chkRole[]']").each(function ()
                {
                    $(this).attr('checked','checked');
                });
            });
            
            // uncheck all
            $('#role_uncheck_all').click(function(){
                $("input[name='chkRole[]']").each(function ()
                {
                    $(this).removeAttr('checked','checked');
                });
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
                location.href='/role';
            }
        }else{ 
            _msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'+result.errors[0].message+'</div>';
        }
        
        $('div#msg').append(_msg);
        window.scrollTo(0,0);
        
    }
    ajaxSendTxt($('form#role-form').serialize(), successCallBack, errorCallBack, "/"+controller+"/save", "POST", false);
}
