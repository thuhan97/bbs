<?php
$punishMonth = date('m', strtotime('last week'));
$totalPunish = App\Models\Punishes::whereMonth('infringe_date', $punishMonth)->sum('total_money');

?>

<div class="mb-4 wow fadeIn">
    <!-- Card -->
    <div class="border border-light card text-center animated fadeInRight" id="punish">
        <!-- Card content -->
        <div class="card-body blue lighten-5">
            <div class="text-center white">
                <img src="{{get_punish_image($totalPunish)}}" class="image my-5"/>
            </div>
            <h4 class="card-title text-uppercase mt-4 mb-0">Tiền phạt cả công ty tháng {{$punishMonth}}</h4>
            <div class="bold punish-counter animated fadeIn" data-count="{{$totalPunish}}">0</div>
        </div>
    </div>
</div>

@push('extend-js')
    <script>
        $(function () {
            function formatNumber(number) {
                return (number + '').toGeneralConcurency('.');
            }

            $('.punish-counter').each(function () {
                var $this = $(this),
                    countTo = $this.attr('data-count');

                $({countNum: $this.text()}).animate({
                        countNum: countTo
                    },
                    {
                        duration: 3000,
                        easing: 'linear',
                        step: function () {
                            $this.text(formatNumber(Math.floor(this.countNum)));
                        },
                        complete: function () {
                            $this.text(formatNumber(this.countNum));
                            //alert('finished');
                        }

                    });
            });
        });

    </script>

@endpush
