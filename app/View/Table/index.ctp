<?php ?>
<style>

    #trash {width:950px; height:25px; background:#000; float:left; margin:10px;}
    #listHolder {width:300px; float:left;}
    #teamHolder {width:300px; float:left;}
    #bigHolder ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
    #bigHolder li { margin: 5px; padding: 5px; width: 250px; border: thin solid blue;}
    .teams {width:500px; float:left;}
    .box {width:280px; min-height:150px; border: thin solid green;}

</style>
<script>
    $(function(){
        
        $('#team1Holder').sortable({
            revert: true
        });

        $('#team1Holder').draggable();

        $('.draggable').draggable({
            connectToSortable: '#team1Holder',
            helper: 'clone',
            revert: 'invalid'
        });
        $('ul, li').disableSelection();
    });
</script>

<div id="bigHolder">
    <div id="listHolder">
        <div id="metroList"><h1>Metros</h1>
            <ul>
                <li class="draggable  " >Las Vegas, NV</li>
                <li class="draggable">Phoenix, AZ</li>
                <li class="draggable">St. George, UT</li>
            </ul>
        </div>
    </div>


        <div id="team1" class="teams" >
            <h1>Team 1</h1>
            <div id="team1Holder" class="box ui-widget-content">
            </div>
        </div>
    </div>
</div>
