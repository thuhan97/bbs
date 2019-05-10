<br/>
<hr/>
<br/>
<div class="mb-4 wow fadeIn">
    <!-- Card -->
    <div class="card">

    {{--        <div class="view overlay">--}}
    {{--            <img class="card-img-top"--}}
    {{--                 src="http://jvb-corp.com/img/homepage/u_home_bg.jpg"--}}
    {{--                 alt="Đề xuất, góp ý">--}}
    {{--            <a href="#!">--}}
    {{--                <div class="mask rgba-white-slight"></div>--}}
    {{--            </a>--}}
    {{--        </div>--}}

    <!-- Card content -->
        <div class="card-body">
            <h4 class="card-title text-uppercase">Góp ý công ty</h4>

            <!-- Card -->
            <form action="{{ route('add_suggestions') }}" method="post">
                @csrf
                <div class="md-form">
                                            <textarea id="feedback" class="md-textarea form-control" name="suggestions"
                                                      rows="5"
                                                      style="width: 100%"
                                                      required></textarea>
                    <label for="feedback">Rất mong nhận được ý kiến đóng góp hoặc đề xuất của bạn đến công ty!</label>
                </div>
                <div class="pt-3 pb-4 d-flex border-top-0 rounded mb-0">
                    <button type="submit" class="btn btn-warning">Gửi ngay
                    </button>
                </div>
            </form>

        </div>

    </div>

</div>