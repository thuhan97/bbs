<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareRequest;
use App\Models\Comment;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function listShareDocument(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('page_size', DEFAULT_PAGE_SIZE);

        $list_document = Share::where('type', '=', SHARE_DUCOMMENT)
            ->search($search)
            ->orderBy('created_at', 'desc')->paginate($perPage);

        return view('end_user.share.index', compact('list_document', 'search', 'perPage'));
    }

    public function downloadFileShare($id)
    {
        $list_document = Share::find($id);
        $pathBase = base_path();
        $fileurl = $pathBase . $list_document->file;
        $name = explode('/', $list_document->file);
        header('Content-Disposition: attachment; filename=' . end($name));
        readfile($fileurl);
    }

    public function addDocument(ShareRequest $request)
    {
        $status = false;
        $file = $request->file('fileDocoment');
        $pathBase = base_path();
        $newNameFile = '/storage/share' . '/' . time() . '_' . $file->getClientOriginalName();
        if ($file->move($pathBase . '/storage/share', $newNameFile)) {
            $share = new Share;
            $share->name = $request->titleDocoment;
            $share->file = $newNameFile;
            $share->creator_id = Auth::user()->id;
            $share->type = SHARE_DUCOMMENT;
            $status = $share->save();
        }
        if ($status) {
            flash()->success(__l('share_document_successully'));
        } else {
            flash()->error(__l('share_document_error'));
        }
        return redirect()->route('list_share_document');
    }

    public function shareExperience()
    {
        $list_experience = Share::where('type', '=', SHARE_EXPERIENCE)->orderBy('created_at', 'desc')->paginate(15);
        // dd($list_experience);
        return view('end_user.share.share_experience', compact('list_experience'));
    }

    public function addExperience(Request $request)
    {
        $content = $request->get('content');
        if (!empty($content)) {
            $share = new Share;
            $share->content = $content;
            $share->creator_id = Auth::user()->id;
            $share->type = SHARE_EXPERIENCE;
            if ($share->save()) {
                flash()->success(__l('share_experience_successully'));
            } else {
                flash()->error(__l('share_experience_error'));
            }
        } else {
            flash()->error(__l('share_experience_error_empty'));
        }
        return redirect()->route('share_experience');
    }

    public function addComment(request $request)
    {
        if (!empty($request)) {
            $commnent = new Comment;
            $commnent->content = $request->contentComment;
            $commnent->share_id = $request->share_id;
            $commnent->creator_id = Auth::user()->id;
            if ($commnent->save()) {
                return view('end_user.share.add_comment', compact('commnent'));
            }
        }
    }

}
