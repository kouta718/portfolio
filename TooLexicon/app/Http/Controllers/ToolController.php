<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreToolRequest;
use App\Models\Tool;
use App\Models\ToolName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');

        // クエリの実行とぺージネーション
        $tools = Tool::search($keyword)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // ビューに変数を渡して表示
        return view('tools.index', compact('tools', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolRequest $request)
    {
        $validated = $request->validated();

        // トランザクション内でToolとToolNameを同時保存
        DB::transaction(function () use ($validated) {
            // Toolテーブルのデータを抽出
            $toolData = [
                'user_id'       => Auth::id(),
                'official_name' => $validated['official_name'],
                'category' => $validated['category'] ?? null,
                'image_url' => $validated['image_url'] ?? null,
                'amazon_url' => $validated['amazon_url'] ?? null,
                'monotaro_url' => $validated['monotaro_url'] ?? null,
                'usage' => $validated['usage'] ?? null,
                'safety_notes' => $validated['safety_notes'] ?? null,
            ];

            // Toolを作成
            $tool = Tool::create($toolData);

            // ToolNameを複数保存
            if (isset($validated['tool_names']) && is_array($validated['tool_names'])) {
                foreach ($validated['tool_names'] as $toolNameData) {
                    ToolName::create([
                        'user_id' => Auth::id(),
                        'tool_id' => $tool->id,
                        'name' => $toolNameData['name'],
                        'is_primary' => $toolNameData['is_primary'] ?? false,
                    ]);
                }
            }
        });

        return redirect()->route('tools.index')
            ->with('success', '工具を登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Tool $tool)
    {
        $tool->load('toolNames');

        return view('tools.show', compact('tool'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        $tool->load('toolNames');

        return view('tools.edit', compact('tool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreToolRequest $request, Tool $tool)
    {
        $validated = $request->validated();

        // トランザクション内でToolとToolNameを同時更新
        DB::transaction(function () use ($validated, $tool) {
            // Toolテーブルのデータを更新
            $toolData = [
                'user_id'       => Auth::id(),
                'official_name' => $validated['official_name'],
                'category' => $validated['category'] ?? null,
                'image_url' => $validated['image_url'] ?? null,
                'amazon_url' => $validated['amazon_url'] ?? null,
                'monotaro_url' => $validated['monotaro_url'] ?? null,
                'usage' => $validated['usage'] ?? null,
                'safety_notes' => $validated['safety_notes'] ?? null,
            ];

            $tool->update($toolData);

            // 既存のToolNameを削除
            $tool->toolNames()->delete();

            // ToolNameを複数保存
            if (isset($validated['tool_names']) && is_array($validated['tool_names'])) {
                foreach ($validated['tool_names'] as $toolNameData) {
                    ToolName::create([
                        'user_id' => Auth::id(),
                        'tool_id' => $tool->id,
                        'name' => $toolNameData['name'],
                        'is_primary' => $toolNameData['is_primary'] ?? false,
                    ]);
                }
            }
        });

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
}
