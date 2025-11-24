<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreToolRequest;
use App\Models\Tool;
use Illuminate\Support\Arr;

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
    public function store(StoreToolRequest $request)
    {
        $toolAttributes = $this->extractToolAttributes($request);
        Tool::create($toolAttributes);

        return redirect()->route('tools.index')
            ->with('success', '工具を登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tool $tool)
    {
        return view('tool.show', compact('tool'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        return view('tool.edit', compact('tool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreToolRequest $request, Tool $tool)
    {
        $toolAttributes = $this->extractToolAttributes($request);
        $tool->update($toolAttributes);

        return redirect()->route('tools.show', $tool)
            ->with('success', '工具のデータを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        $tool->delete();

        return redirect()->route('tools.index')
            ->with('success', '削除しました');
    }

    /**
     * toolsテーブルに存在するカラムのみを抽出する。
     */
    private function extractToolAttributes(StoreToolRequest $request): array
    {
        $validated = $request->validated();

        if (isset($validated['offical_name']) && ! isset($validated['official_name'])) {
            $validated['official_name'] = $validated['offical_name'];
        }

        return Arr::only($validated, [
            'official_name',
            'image_url',
            'amazon_url',
            'monotaro_url',
            'usage',
            'safety_notes',
        ]);
    }
}
