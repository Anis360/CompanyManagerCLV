@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

                    <h1 align="center">
                        Bienvenue {{ Auth::user()->name }} ({{ Auth::user()->role }})
                    </h1>
    </div>
</div>
    <div id='calendar'></div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {


                eventClick: function(info) {
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    alert('Thème de la session : ' + info.event.title + '\nDate de début : ' + info.event.start.toLocaleDateString(undefined, options) + '\nDate de fin : ' + info.event.end.toLocaleDateString(undefined, options) );


                    // change the border color just for fun
                    //info.el.style.borderColor = 'red';
                },

                weekends: false,
                editable: true,
                selectable: true,
                businessHours: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [

                        @foreach($sessions as $session)
                    {
                        title : '{{ $session->Theme_Session }}',
                        start : '{{ $session->Date_Debut }}',
                        end : '{{ $session->Date_Fin }}'
                    },
                @endforeach

                ]
            });

            calendar.render();
        });

    </script>




@endsection
