<html>
<head>
    <title>TimeSheet</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link rel='stylesheet' href='bower_components/fullcalendar/dist/fullcalendar.css' />

    <script src='bower_components/moment/moment.js'></script>
    <script src='bower_components/jquery/dist/jquery.min.js'></script>
    <script src='bower_components/bootstrap/dist/js/bootstrap.min.js'></script>
    <script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
    <script src="timesheet.js"></script>
</head>
<body class="container">
<br/>
<br/>
        <form class="form-inline">
            <div class="form-group">
                <input type="text" class="form-control" id="usernameid" placeholder="username">
            </div>
            <button class="btn btn-info" id="startdateid">
                <i class="glyphicon glyphicon-play"></i> Start Datime
            </button>
            <button class="btn btn-danger" id="enddateid">
                <i class="glyphicon glyphicon-stop"></i> End Datime
            </button>
            <button class="btn btn-default" id="searchid">
                <i class="glyphicon glyphicon-search"></i> Search
            </button>
        </form>

        <div id='calendar' class="col-lg-8"></div>
</body>
<div class="modal fade" tabindex="-1" role="dialog" id="modalDetailid" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Info</h4>
            </div>
            <div class="modal-body">
                <p id="detailid"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>