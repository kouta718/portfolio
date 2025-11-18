<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ToolStoreRequest;
use App\Models\Tool;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools=Tool::paginate(10);
        return view('tool.index', compact('tools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tool.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // if ($post->locked) {
        //     $request->session()->flash('message', 'ロックされています');
        //     return redirect()->back();
        // }
    }

    // ロック操作
    public function lock()
    {
        // $post->locked = !$post->locked;
        // $post->save();
        // $message = $post->locked ? '投稿をロックしました。' : '投稿のロックを解除しました。';
        // $request->session()->flash('message', $message);
        // return redirect()->back();
    }
}
