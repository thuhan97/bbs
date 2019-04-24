<div class="row margin-t-40">
    <div class="col-lg-2 first_chart">
        <div id="canvas-holder" class="doughnut">
            <canvas id="chart-area"></canvas>
        </div>
    </div>
    <div class="col-lg-2 mr-15">
        <div id="canvas-holder1" class="doughnut">
            <canvas id="chart-area1"></canvas>
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
@if(!empty($chart['weeks']))
    <script>
        var config2 = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        @isset($chart['weeks'][app\Models\Statistics::TYPES['normal']])
                        {{$chart['weeks'][app\Models\Statistics::TYPES['normal']]}},
                        @endisset
                        @isset($chart['weeks'][app\Models\Statistics::TYPES['latey_early']])
                        {{$chart['weeks'][app\Models\Statistics::TYPES['latey_early']]}},
                        @endisset
                        @isset($chart['weeks'][app\Models\Statistics::TYPES['ot']])
                        {{$chart['weeks'][app\Models\Statistics::TYPES['ot']]}},
                        @endisset
                        @isset($chart['weeks'][app\Models\Statistics::TYPES['lately_ot']])
                        {{$chart['weeks'][app\Models\Statistics::TYPES['lately_ot']]}},
                        @endisset
                        @isset($chart['weeks'][app\Models\Statistics::TYPES['leave']])
                        {{$chart['weeks'][app\Models\Statistics::TYPES['leave']]}},
                        @endisset
                    ],
                    backgroundColor: [
                        @isset($chart['weeks'][app\Models\Statistics::TYPES['normal']])
                            window.chartColors.purple,
                        @endisset
                                @isset($chart['weeks'][app\Models\Statistics::TYPES['latey_early']])
                            window.chartColors.red,
                        @endisset
                                @isset($chart['weeks'][app\Models\Statistics::TYPES['ot']])
                            window.chartColors.blue,
                        @endisset
                                @isset($chart['weeks'][app\Models\Statistics::TYPES['lately_ot']])
                            window.chartColors.green,
                        @endisset
                                @isset($chart['weeks'][app\Models\Statistics::TYPES['leave']])
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
    var config_default = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    100,
                ],
                backgroundColor: [
                    window.chartColors.purple,
                    window.chartColors.red,
                    window.chartColors.blue,
                    window.chartColors.green,
                    window.chartColors.yellow,
                ],
            }],
        },
        options: options
    };
    window.onload = function() {
        var ctx = document.getElementById('chart-area').getContext('2d');
        var ctx1 = document.getElementById('chart-area1').getContext('2d');
        if (typeof config1 !== 'undefined') {
            window.myDoughnut = new Chart(ctx, config1);
        } else {
            //window.myDoughnut = new Chart(ctx, config_default);
        }
        if (typeof config2 !== 'undefined') {
            window.myDoughnut = new Chart(ctx1, config2);
        } else {
            //window.myDoughnut = new Chart(ctx1, config_default);
        }
    };
</script>
