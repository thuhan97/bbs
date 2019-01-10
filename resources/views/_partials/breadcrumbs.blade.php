@if ($breadcrumbs)
    <ul class="breadcrumb mb-4">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->first)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">
                        <i class="fa fa-dashboard"></i>{{ $breadcrumb->title }}</a>
                </li>
            @elseif (!$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                </li>
            @else
                <li class="breadcrumb-item">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
@endif
