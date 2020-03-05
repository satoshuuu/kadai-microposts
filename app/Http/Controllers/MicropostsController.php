<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Micropost;

class MicropostsController extends Controller
{
    public function index() {
        $data =[];
        if(\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
                ];
        }
        return view('welcome', $data);
    }
    
    public function store(Request $request) {
        $this->validate($request, [
                'content' => 'required|max:191',
            ]);
            
        $request->user()->microposts()->create([
                'content' => $request->content,
            ]);
            
        return back();
    }
    
    public function destroy($id) {
        $micropost = \App\Micropost::find($id);
        
        if(\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }
        
        return back();
    }
    
    //一覧表示
    public function show() {
        $microposts = Micropost::orderBy('id', 'desc')->paginate(10);
        
        return view('microposts.show', [
            'microposts' => $microposts,
            ]);
    }
    
    //検索機能
    public function search(Request $request) {
        $keyword = $request->keyword;
        
        if(!empty($keyword)) {
            $microposts = Micropost::orderBy('id', 'desc')->where('content','like', '%'.$keyword.'%')->paginate(10);
        }else {
            $microposts = Micropost::orderBy('id', 'desc')->paginate(10);
        }
        
        return view('search.index', [
                'microposts' => $microposts,
            ]);
    }
    
}
