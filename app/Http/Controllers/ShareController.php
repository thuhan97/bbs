<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Share;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ShareRequest;

class ShareController extends Controller
{
    public function listShareDocument(){
        $list_document = Share::where('type','=', SHARE_DUCOMMENT)->orderBy('created_at','desc')->paginate(15);
    	return view('end_user.share.list_share_document', compact('list_document'));
    }

    public function downloadFileShare($id){
    	$list_document = Share::find($id);
        $pathBase = base_path();
        $fileurl = $pathBase . $list_document->file;
		header('Content-Disposition: attachment; filename=' . $fileurl);
		readfile( $fileurl );
    }

    public function addDocument(ShareRequest $request){
        $status = false;
        $file = $request->file('fileDocoment');
        $pathBase = base_path();
        $newNameFile = '/storage/share' . '/' . time() . '_' . $file->getClientOriginalName();
        if($file->move($pathBase . '/storage/share',$newNameFile)){
            $path = $newNameFile;
        }
        if(isset($path)){
            $share = new Share;
            $share->name = $request->titleDocoment;
            $share->file = $path;
            $share->creator_id = Auth::user()->id;
            $share->type = SHARE_DUCOMMENT;
            if($share->save()){
                $status = true;                
            }else{
                $status = false;               
            }     
        }else{
            $status = false;
        }
        if($status){
            flash()->success(__l('share_document_successully'));
        }else{
            flash()->error(__l('share_document_error'));
        }
        return redirect()->route('list_share_document');             
    }           
}
