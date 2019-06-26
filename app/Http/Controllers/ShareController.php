<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareExperienceRequest;
use App\Http\Requests\ShareRequest;
use App\Models\Comment;
use App\Models\Share;
use App\Services\NotificationService;
use App\Services\ShareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public $notificationService;
    /**
     * @var ShareService
     */
    private $service;

    public function __construct(ShareService $service, NotificationService $notificationService)
    {
        $this->service = $service;
        $this->notificationService = $notificationService;
    }

    public function listShareDocument(Request $request)
    {
        $list_document = $this->service->documentList($request, $search, $perPage);

        return view('end_user.share.index', compact('list_document', 'search', 'perPage'));
    }

    public function downloadFileShare($id)
    {
        $list_document = Share::find($id);
        $pathBase = base_path();
        $fileurl = $pathBase . $list_document->file;
        $name = explode('/', $list_document->file);
        header('Content-Disposition: attachment; filename="' . basename(end($name)) . '"');
        @readfile($fileurl);
        exit;
    }

    public function addDocument(ShareRequest $request)
    {
        $status = false;
        $file = $request->file('fileDocument');
        $pathBase = base_path();
        $newNameFile = '/storage/share' . '/' . time() . '_' . $file->getClientOriginalName();
        if ($file->move($pathBase . '/storage/share', $newNameFile)) {
            $share = new Share;
            $share->name = $request->titleDocument;
            $share->file = $newNameFile;
            $share->creator_id = Auth::user()->id;
            $share->type = SHARE_DOCUMENT;
            $status = $share->save();
        }
        if ($status) {
            flash()->success(__l('share_document_successully'));
        } else {
            flash()->error(__l('share_document_error'));
        }
        return redirect()->route('list_share_document');
    }

    public function shareExperience(Request $request)
    {
        $list_experience = $this->service->experienceList($request, $search, $perPage);

        return view('end_user.share.share_experience', compact('list_experience', 'search', 'perPage'));
    }

    public function addExperience(ShareExperienceRequest $request)
    {
        $content = $request->get('content');
        $introduction = $request->get('introduction');
        if (!empty($content) && !empty($introduction)) {
            $share = new Share;
            $share->content = $content;
            $share->introduction = $introduction;
            $share->creator_id = Auth::user()->id;
            $share->type = SHARE_EXPERIENCE;
            if ($share->save()) {
                $this->notificationService->sendWorkExperience($share);
                flash()->success(__l('share_experience_successully'));
            } else {
                flash()->error(__l('share_experience_error'));
            }
        } else {
            flash()->error(__l('share_experience_error_empty'));
        }
        return redirect()->route('share_experience');
    }

    public function deletedExperience($id)
    {
        $experience = Share::find($id);
        if (isset($experience->creator_id) && $experience->creator_id == Auth::user()->id) {
            $experience->delete();
            flash()->success(__l('share_experience_successully_deleted'));
        } else {
            flash()->error(__l('share_experience_error_deleted'));
        }
        return redirect()->route('share_experience');
    }

    public function editExperience($id)
    {
        $experience = Share::find($id);
        if (isset($experience->creator_id) && $experience->creator_id == Auth::user()->id) {
            return view('end_user.share.edit_experience', compact('experience'));
        } else {
            flash()->error(__l('share_experience_error_edit'));
            return redirect()->route('share_experience');
        }
    }

    public function saveEditExperience(ShareExperienceRequest $request)
    {
        $content = $request->get('content');
        $introduction = $request->get('introduction');
        if (!empty($content) && !empty($introduction)) {
            $share = Share::findOrFail($request->id);
            $share->content = $content;
            $share->introduction = $introduction;
            if ($share->update()) {
                flash()->success(__l('share_experience_successully_edit'));
            } else {
                flash()->error(__l('share_experience_error_edit'));
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

    public function viewExperience($id)
    {
        $experience = Share::find($id);
        if ($experience) {
            return view('end_user.share.view_experience', compact('experience'));
        } else {
            flash()->error(__l('share_experience_error_edit'));
            return redirect()->route('share_experience');
        }
    }

}
