<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Share;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{
    public function listShareDocument(){
        $list_document = Share::where('type','=', SHARE_DUCOMMENT)->orderBy('created_at','desc')->paginate(15);
    	return view('end_user.share.list_share_document', compact('list_document'));
    }

    public function downloadFileShare($id){
    	$list_document = Share::find($id);
    	$path = base_path();
    	$fileurl = $path . $list_document->file;
		header('Content-Disposition: attachment; filename=' . $fileurl);
		readfile( $fileurl );
    }

    public function addDocument(request $request){
        $status = false;
        if($request->hasFile('fileDucoment') && $request->titleDucoment != null){
            $file = $request->file('fileDucoment');
            $result = $this->uploadPublicFile($file,'uploads/share',2);
            if(!$result['error']){
                $share = new Share;
                $share->name = $request->titleDucoment;
                $share->file = $result['path'];
                $share->creator_id = Auth::user()->id;
                $share->type = SHARE_DUCOMMENT;
                $share->save();
                session()->flash('share','Lưu thành công');
                $status = true;
                return redirect()->route('list_share_document'); 
            }
        }
        if(!$status){
            session()->flash('share','Lưu thất bại');
            return redirect()->route('list_share_document');
        }
    }

    public function uploadPublicFile($file,$path,$allowMaxSize){
        $result = array(
            'error'         => true,
            'errorMessage'  => 'Upload file không thành công!',
            'path'          => ''
        );
        if($file->getSize()){
                if($file->getSize() > $allowMaxSize*1024*1024){
                $result['errorMessage'] = 'Vượt quá dung lượng cho phép!';
                return $result;
            }
        }
        $newNameFile = $path.'/' . time() . '_' . $file->getClientOriginalName();
        if($file->move($path,$newNameFile)){
            $result['error'] = false;
            $result['path']  = '/public/'.$newNameFile;
            $result['errorMessage'] = 'Upload file thành công';
        }
        return $result;
    }            
}
