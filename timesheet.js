$(function() {
    function launchCalendar(data){

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            events: data,
            eventClick: function(calEvent, jsEvent, view) {

                $( "#detailid" ).html( calEvent.id );
                $('#modalDetailid').modal();
            }
        });
    }

    function check(username){
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            data: {'action': 'check', 'username': username},
            success: function (data, status) {
                console.log(data);
                if(data==0){
                    $('#startdateid').prop('disabled', false);
                    $('#enddateid').prop('disabled', true);
                }
                if(data==1){
                    $('#startdateid').prop('disabled', true);
                    $('#enddateid').prop('disabled', false);
                }
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }

    function searchData(username) {
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            data: {'action': 'search', 'username': username},
            success: function (data, status) {
                console.log(data);
                launchCalendar(data);
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }

    function init(username){
        check(username);
        searchData(username);
    }

    $( document ).ready(function() {

        $('#startdateid').on('click', function (e) {
            e.preventDefault();
            $('#startdateid').prop('disabled', true);
            $('#enddateid').prop('disabled', false);
            $.ajax({
                url: 'ajax.php',
                type: 'post',
                data: {'action': 'start', 'username': $('#usernameid').val()},
                success: function (data, status) {
                    console.log(data);

                },
                error: function (xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
            });
            $( "#detailid" ).html( "Vous venez de commencer!!! notez que vous ne" +
                " pouvez terminez dans au moins une heure, merci. " );
            $('#modalDetailid').modal();

        });

        $('#enddateid').on('click', function (e) {
            e.preventDefault();
            if(confirm("Etes vous sur de vouloir terminer?")){
                $('#startdateid').prop('disabled', false);
                $('#enddateid').prop('disabled', true);
                $.ajax({
                    url: 'ajax.php',
                    type: 'post',
                    data: {'action': 'end', 'username': $('#usernameid').val()},
                    success: function (data, status) {
                        console.log(data);
                        if(data=1){
                            $( "#detailid" ).html( "Ne peut etre terminez, car vous n'avez pas encore fait 1 heure!" );
                            $('#modalDetailid').modal();
                        }else{
                            $( "#detailid" ).html( "Vous avez terminez, merci!" );
                            $('#modalDetailid').modal();
                        }
                    },
                    error: function (xhr, desc, err) {
                        console.log(xhr);
                        console.log("Details: " + desc + "\nError:" + err);
                    }
                });

            }
        });

        $('#searchid').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: 'ajax.php',
                type: 'post',
                data: {'action': 'search', 'username': $('#usernameid').val()},
                success: function (data, status) {
                    console.log(data);
                    $('#calendar').fullCalendar( 'removeEvents');
                    $('#calendar').fullCalendar( 'addEventSource', data );
                    $('#calendar').fullCalendar( 'rerenderEvents')
                },
                error: function (xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
            });
        });

        init('guymoyo');
    });


});