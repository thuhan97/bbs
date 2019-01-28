<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" lang="en" content="jQuery multiselect plugin with two sides. The user can select one or more items and send them to the other side."/>
    <meta name="keywords" lang="en" content="jQuery multiselect plugin" />

    <base href="http://crlcu.github.io/multiselect/" />

    <title>jQuery multiselect plugin with two sides</title>

    <link rel="icon" type="image/x-icon" href="https://github.com/favicon.ico" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/google-code-prettify/prettify.css" />
    <link rel="stylesheet" href="{{ cdn_asset('/adminlte/css/style.css') }}" />
</head>
<body>

<div id="wrap" class="container">
    <div class="row">
        <div class="col-xs-5">
            <select name="from[]" id="undo_redo" class="form-control" size="13" multiple="multiple">
                @foreach($members_other as $member_other)
                <option value="{{$member_other->id}}">{{$member_other->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-xs-2">
            <button type="button" id="undo_redo_undo" class="btn btn-primary btn-block">undo</button>
            <button type="button" id="undo_redo_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
            <button type="button" id="undo_redo_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button type="button" id="undo_redo_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
            <button type="button" id="undo_redo_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
            <button type="button" id="undo_redo_redo" class="btn btn-warning btn-block">redo</button>
        </div>

        <div class="col-xs-5">
            <select name="to[]" id="undo_redo_to" class="form-control" size="13" multiple="multiple"></select>
        </div>
    </div>


</div>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
<script type="text/javascript" src="{{ cdn_asset('/adminlte/js/multiselect.min.js') }}"></script>

<script>

</script>

<script type="text/javascript">
    $(document).ready(function() {
        // make code pretty
        window.prettyPrint && prettyPrint();

        $('#undo_redo').multiselect();
    });
</script>
</body>
</html>
