<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Yo</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
        $(function(){
            $("#draggable").draggable();
            $("#droppable").droppable({
                drop: function (event, ui) {
                    alert('dropped');
                }
            });
        })
    </script>
</head>
<body>
<div id="draggable" class="ui-widget-content" style="width: 200; height: 100; background-color: black">Yes</div>
<div id="droppable" class="ui-widget-content"> Drop here</div>
</body>
</html>