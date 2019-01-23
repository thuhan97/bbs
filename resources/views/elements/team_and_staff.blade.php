<?php
$col = $colClass ?? 'col-md-4';

?>

<div class="{{$col}}">
    <input id="txtTeam" name="team_search" class="form-control" type="text"
           placeholder="Chọn team" aria-label="Search">
</div>
<div class="{{$col}}">
    <select class="mdb-select md-form colorful-select dropdown-primary" multiple searchable="Search here..">
        <option value="" disabled selected>Choose your country</option>
        <option value="1">USA</option>
        <option value="2">Germany</option>
        <option value="3">France</option>
        <option value="4">Poland</option>
        <option value="5">Japan</option>
    </select>
    <input id="txtStaff" name="staff_search" class="form-control" type="text"
           placeholder="Chọn nhân viên" aria-label="Search">
</div>