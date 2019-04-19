<div class="row margin-t-40 ">
    <div class="col-lg-2 first_chart mr-15">
        <div id="canvas-holder" class="doughnut">
            <canvas id="chart-area"></canvas>
        </div>
    </div>
    @include($resourceAlias.'.note')
</div>

@if(!empty($chart['months']))
    <script>
        var config1 = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        @isset($chart['months'][app\Models\Statistics::TYPES['normal']])
                        {{$chart['months'][app\Models\Statistics::TYPES['normal']]}},
                        @endisset
                        @isset($chart['months'][app\Models\Statistics::TYPES['latey_early']])
                        {{$chart['months'][app\Models\Statistics::TYPES['latey_early']]}},
                        @endisset
                        @isset($chart['months'][app\Models\Statistics::TYPES['ot']])
                        {{$chart['months'][app\Models\Statistics::TYPES['ot']]}},
                        @endisset
                        @isset($chart['months'][app\Models\Statistics::TYPES['lately_ot']])
                        {{$chart['months'][app\Models\Statistics::TYPES['lately_ot']]}},
                        @endisset
                        @isset($chart['months'][app\Models\Statistics::TYPES['leave']])
                        {{$chart['months'][app\Models\Statistics::TYPES['leave']]}},
                        @endisset
                    ],
                    backgroundColor: [
                        @isset($chart['months'][app\Models\Statistics::TYPES['normal']])
                            window.chartColors.purple,
                        @endisset
                                @isset($chart['months'][app\Models\Statistics::TYPES['latey_early']])
                            window.chartColors.red,
                        @endisset
                                @isset($chart['months'][app\Models\Statistics::TYPES['ot']])
                            window.chartColors.blue,
                        @endisset
                                @isset($chart['months'][app\Models\Statistics::TYPES['lately_ot']])
                            window.chartColors.green,
                        @endisset
                                @isset($chart['months'][app\Models\Statistics::TYPES['leave']])
                            window.chartColors.yellow,
                        @endisset
                    ],
                }],
            },
            options: options
        };
    </script>
@endif
<script>
    window.onload = function() {
        var ctx = document.getElementById('chart-area').getContext('2d');
        if (typeof config1 !== 'undefined') {
            window.myDoughnut = new Chart(ctx, config1);
        }
    };
</script>
