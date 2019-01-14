@extends('layouts.end_user')
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
            <input name="search" value="{{old('search', $search)}}" class="form-control" type="text"
                   placeholder="{{__l('Search')}}" aria-label="Search">
            <input type="hidden" name="page_size" value="{{$perPage}}">
        </div>
    </form>
    @if($events->isNotEmpty())
        <div class="row mb-3">
            <div class="col-sm-6"></div>
            <div class="col-sm-6 text-right">
                <a href="{{route('event_list')}}" class="btn btn-primary waves-effect">
                    <i class="fas fa-calendar"></i> Xem danh sách
                </a>
            </div>
        </div>
        <div id="calendar">
        </div>

        <br/>
        <br/>
    @else
        <h2>{{__l('list_empty', ['name'=>'sự kiện'])}}</h2>
    @endif

@endsection

@push('extend-js')
    <link href="{{ asset('fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>

    <script>
        $(function () {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
                defaultDate: '{{date('Y-m-d')}}',
                locale: 'vi',
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
                eventClick: function (calEvent, jsEvent, view) {
                    window.open('/su-kien/' + calEvent.id);
                },
                events: [
                        @foreach($events as $event)
                    {
                        id: '{{$event->id}}',
                        title: '{{$event->name}}',
                        description: '{{$event->introduction}}',
                        start: '{{$event->event_date}}',
                        end: '{{$event->event_end_date}}'
                    },
                    @endforeach
                ]
            });
        })
        ;
    </script>
@endpush