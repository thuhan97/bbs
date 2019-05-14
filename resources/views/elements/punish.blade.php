<div class="mb-4 wow fadeIn">
    <!-- Card -->
    <div class="card text-center" id="punish">
        <!-- Card content -->
        <div class="card-body red lighten-5">
            <h4 class="card-title text-uppercase">Tổng tiền phạt công ty tháng {{date('m')}}</h4>
            <div class="bold punish-counter" data-count="{{$totalPunish}}">0</div>
        </div>
    </div>
</div>

@push('extend-js')
    <script>
        $(function () {
            var strToNum = function (str) {
                //Find 1-3 digits followed by exactly 3 digits & a comma or end of string
                let regx = /(\d{1,3})(\d{3}(?:,|$))/;
                let currStr;

                do {
                    currStr = (currStr || str.split(`.`)[0])
                        .replace(regx, `$1,$2`)
                } while (currStr.match(regx)) //Stop when there's no match & null's returned

                return (str.split(`.`)[1]) ?
                    currStr.concat(`.`, str.split(`.`)[1]) :
                    currStr;

            };

            function formatNumber(number) {
                return strToNum(number + '');
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