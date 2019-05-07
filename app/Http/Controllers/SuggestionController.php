<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuggestionController extends Controller
{
    public function listSuggestions(){
        $list_suggestions = Suggestion::where('deleted_at','=', null)->orderBy('created_at','desc')->paginate(15);
        return view('end_user.suggestion.list_suggestion', compact('list_suggestions'));
    }    

    public function addSuggestions(request $request){
        $contentSuggestion = $request->suggestions;
        if(!empty($contentSuggestion)){
            $suggestion = new Suggestion;
            $suggestion->content = $contentSuggestion;
            $suggestion->creator_id = Auth::user()->id;
            $status = $suggestion->save();
        }
        if($status){
            flash()->success(__l('suggestion_successully'));
        }else{
            flash()->error(__l('suggestion_error'));
        }     
        return redirect()->route('default');             
    }           
}
