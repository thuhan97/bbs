@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('list_share_document') !!}
@endsection
@section('content')
    <div class="createReport fixed-action-btn">
        <a href="#" class="btn-floating btn-lg red waves-effect waves-light text-white"
           title="Chia sẻ" data-target="#feedback" data-toggle="modal">
            <i class="fa fa-plus"  aria-hidden="true"></i>
        </a>
    </div>
	<div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Nội dung tài liệu chia sẻ
                </th>
                <th>
                    Người đăng
                </th>
                <th>
                    Ngày tải lên
                </th>
                <th>
                    Định dạng
                </th>
                <th>
                	Tải ngay
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($list_document as $document)
            	<?php 
            		$ext = pathinfo($document->file, PATHINFO_EXTENSION);
            	?>
                <tr>
                    <td>
                        {{$document->name}}
                    </td>
                    <td>
                    	<?php echo isset($document->user->name) ? $document->user->name : ''; ?>
                    </td>
                    <td>
                        {{$document->created_at}}
                    </td>
                    <?php 
                        $ext = pathinfo($document->file, PATHINFO_EXTENSION);
                    ?>                    
                    <td class="center">
                        <i class="<?php echo isset(ICONS_TYPES_FILES[$ext]) ? ICONS_TYPES_FILES[$ext] : ''; ?>" aria-hidden="true"></i>
                    </td>
                    <td class="center">
                    	<a href="/download_file_share/{{$document->id}}" target="_blank">
                        	<i class="fa fa-download" aria-hidden="true" style="color: #4285f4;"></i>
                        </a>	
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
        	{{ $list_document->links() }}
        </div>        
    </div>

    <!-- Modal -->
    <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/background_share.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<div class="background-close-icon">
                        	<span class="btn-close-icon" aria-hidden="true">&times;</span>
                    	</div>
                    </button>
                </div>
                <form action="{{ route('add_document') }}" method="post" id="formDocument" enctype="multipart/form-data">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="modal-body">
    	                <div id="contentCreateForm">
    		                <label class="ml-3 text-w-400" for="titleDocoment">Tiêu đề tài liệu *</label>
    		                <input type="text" required id="titleDocoment" class="form-control mb-3" name="titleDocoment"
    		                       placeholder="Tiêu liệu bạn muốn chia sẻ " autocomplete="off">
    		                <label class="ml-3 text-w-400" for="titleForm">Upload file và chia sẻ file *</label>
                            <div class="inputDnD">
                                <input type="file" required name="fileDocoment" class="form-control-file text-primary font-weight-bold" id="inputFile" onchange="readUrl(this)" data-title="NHẤP CHUỘT HOẶC KÉO THẢ FILE VÀO ĐÂY">
                            </div>
                            <div class="card bg-danger text-white" id="ErrorMessaging"> 
    		            </div>
    		        </div>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button type="button" class="btn btn-primary" onclick="sendAbsenceForm()">CHIA SẺ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<style>
    .modal-header{
        background-image: url('img/header-popup-share.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        height: 250px;
    }
	th, .center{
		text-align: center;
	}
	.pagination{
		margin: 0 auto;
	}
	.background-close-icon{
	    background: rgba(0,0,0,0.3);
	    border-radius: 50%;
	    width: 24px;
	    height: 24px;
	}
	.modal-center{
	    display: flex;
	    flex-direction: column;
	    justify-content: center;
	    overflow-y: auto;
	    min-height: calc(100vh - 60px);
	}
    .inputDnD .form-control-file { 
      position: relative; 
      width: 100%; 
      height: 100%; 
      min-height: 6em; 
      outline: none; 
      visibility: hidden; 
      cursor: pointer; 
      background-color: #c61c23; 
    } 
    .inputDnD .form-control-file:before { 
      content: attr(data-title); 
      position: absolute; 
      width: 100%; 
      min-height: 6em; 
      line-height: 2em; 
      padding-top: 1.5em; 
      opacity: 1; 
      visibility: visible; 
      text-align: center; 
      border: 1px solid #ced4da;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); 
      overflow: hidden;
      color: #ced4da;  
    }
    #ErrorMessaging{
        margin: 5px 0px 0px 0px;
    }     	    	
</style>
<script>
function sendAbsenceForm() {
    var name = $("#titleDocoment").val();
    var file = $("#inputFile").val();
    if(name != '' && file != ''){
        $("#formDocument").submit();
    }else{
        let errorBox = document.getElementById('ErrorMessaging');
        errorBox.innerHTML = "<div class='card-body'>Tiêu đề và file không được để trống!</div>";        
    }
}
function readUrl(input) { 
  if (input.files && input.files[0]) { 
    let reader = new FileReader(); 
    reader.onload = e => { 
      let imgData = e.target.result; 
      let imgName = input.files[0].name; 
      console.log(imgName);
      input.setAttribute("data-title", imgName); 
      console.log(e.target.result); 
    }; 
    reader.readAsDataURL(input.files[0]); 
  }
}       
</script>
@endsection