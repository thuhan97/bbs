@if ($breadcrumbs)
    <ul class="breadcrumb mb-2 mb-lg-4">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->first)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">
                        <i class="fas fa fa-dashboard fa-home"></i> &nbsp;{{ $breadcrumb->title }}</a>
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
