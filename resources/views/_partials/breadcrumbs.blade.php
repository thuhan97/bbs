@if ($breadcrumbs)
    <ul class="breadcrumb mt-1 mt-md-5 md-sm-3">
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
