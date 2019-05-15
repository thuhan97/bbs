<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function listSuggestions(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('page_size', DEFAULT_PAGE_SIZE);

        $list_suggestions = Suggestion::search($search)
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return view('end_user.suggestion.list_suggestion', compact('list_suggestions', 'search', 'perPage'));
    }

    public function addSuggestions(request $request)
    {
        $contentSuggestion = $request->suggestions;
        if (!empty($contentSuggestion)) {
            $suggestion = new Suggestion;
            $suggestion->content = $contentSuggestion;
            $suggestion->creator_id = Auth::user()->id;
            $status = $suggestion->save();
        }
        if ($status) {
            flash()->success(__l('suggestion_successully'));
        } else {
            flash()->error(__l('suggestion_error'));
        }
        return redirect()->route('default');
    }

    public function approveSuggestion(request $request)
    {
        if (!empty($request)) {
            $suggestion = Suggestion::findOrFail($request->data);
            if ($request->data_status == 0) {
                $suggestion->status = 1;
            } else {
                $suggestion->status = 0;
            }
            if($suggestion->update()){
                return $suggestion->status; 
            }
        }
    }    
}
