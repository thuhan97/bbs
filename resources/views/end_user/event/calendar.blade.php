@extends('layouts.end_user')
@section('page-title', __l('Event'))

@section('breadcrumbs')
    @if(empty($search))
        {!! Breadcrumbs::render('event') !!}
    @else
        {!! Breadcrumbs::render('event_search', $search) !!}
    @endif
@endsection
@section('content')
    <form class="mb-4">
        <div class="md-form active-cyan-2 mb-3">
            <input id="txtSearch" name="search" class="form-control" type="text"
                   placeholder="{{__l('Search')}}" aria-label="Search">
        </div>
    </form>
    <div class="row mb-3">
        <div class="col-sm-6"></div>
        <div class="col-sm-6 text-right">
            <a href="{{route('event')}}" class="btn btn-primary waves-effect">
                <i class="fas fa-list"></i> Xem danh sách
            </a>
        </div>
    </div>
    <div id="calendar-event">
    </div>

@endsection

@push('extend-js')
    <link href="{{ asset_ver('fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset_ver('fullcalendar/fullcalendar.min.js') }}"></script>

    <script>
        $(function () {

            window.start_date = null;
            window.end_date = null;
            var $calendar = $('#calendar-event');
            var $search = $('#txtSearch');

            function renderCalendar() {
                var data = {
                    start: window.start_date,
                    end: window.end_date,
                }, search = $search.val();

                if (search) {
                    data.search = search;
                }
                $.ajax({
                    url: '{{route('getCalendar')}}',
                    method: 'GET',
                    dataType: 'JSON',
                    data: data,
                    success: function (response) {
                        if (response.code == 200 && response.data.events) {
                            $calendar.fullCalendar('removeEvents');
                            var events = response.data.events;
                            $calendar.fullCalendar('addEventSource', events);
                            $calendar.fullCalendar('rerenderEvents');
                        }
                    }
                });
            }

            $search.change(function () {
                renderCalendar();
            });

            $calendar.fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
                defaultDate: '{{date('Y-m-d')}}',
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                height: 650,
                eventRender: function (eventObj, $el) {
                    $el.popover({
                        title: eventObj.title,
                        content: eventObj.description,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                    });
                },
                viewRender: function (newView, oldView) {
                    window.start_date = newView.start.format('Y/M/D');
                    window.end_date = newView.end.format('Y/M/D');

                    renderCalendar();
                },
                eventClick: function (calEvent, jsEvent, view) {
                    window.open('/su-kien/' + calEvent.id);
                }
            });
        });
    </script>
@endpush
