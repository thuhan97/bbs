<div class="mb-4 wow fadeIn">
    <!-- Card -->
    <div class="border border-light card z-depth-0">

    {{--        <div class="view overlay">--}}
    {{--            <img class="card-img-top"--}}
    {{--                 src="http://jvb-corp.com/img/homepage/u_home_bg.jpg"--}}
    {{--                 alt="Đề xuất, góp ý">--}}
    {{--            <a href="#!">--}}
    {{--                <div class="mask rgba-white-slight"></div>--}}
    {{--            </a>--}}
    {{--        </div>--}}

    <!-- Card content -->
        <div class="card-body pt-3">
            <h4 class="card-title text-uppercase mb-2">Góp ý công ty</h4>

            <!-- Card -->
            <form action="{{ route('add_suggestions') }}" method="post">
                @csrf
                <div class="md-form mt-0 mb-0">
                    <textarea id="feedback" class="md-textarea form-control no-border mb-0" name="suggestions" rows="5" style="width: 100%" required></textarea>
                    <label for="feedback" class="mb-0">Rất mong nhận được ý kiến đóng góp hoặc đề xuất của bạn đến công
                        ty!</label>
                </div>
                <div class="d-flex border-top-0 rounded mb-0 float-right">
                    <button type="submit" class="btn btn-primary">Gửi ngay
                    </button>
                </div>
            </form>

        </div>

    </div>

</div>
