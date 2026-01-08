<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreToolRequest;
use App\Models\Tool;
use App\Models\ToolName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // 画像の保存
        $imagePath = null;
        if (isset($validated['image_path'])) {
            try {
                $file = $validated['image_path'];

                // ファイル名をサニタイズ（安全なファイル名を生成）
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // ストレージパスを検証
                $imagePath = $file->storeAs('tools', $filename, 'public');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['image_path' => '画像のアップロードに失敗しました。'])
                    ->withInput();
            }
        }

        // トランザクション内でToolとToolNameを同時保存
        try {
            DB::transaction(function () use ($validated, $imagePath) {
                // Toolテーブルのデータを抽出
                $toolData = [
                    'user_id'       => Auth::id(),
                    'official_name' => $validated['official_name'],
                    'category' => $validated['category'] ?? null,
                    'image_path' => $imagePath,
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
        } catch (\Exception $e) {
            // トランザクション失敗時、アップロードした画像があれば削除
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                ->withErrors(['error' => '登録に失敗しました。もう一度お試しください。'])
                ->withInput();
        }

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

        // 古い画像パスを保存
        $oldImagePath = $tool->image_path;
        $newImagePath = $oldImagePath; // デフォルトは既存のパス

        // 新しい画像がアップロードされた場合のみ処理
        if (isset($validated['image_path'])) {
            try {
                $file = $validated['image_path'];

                // ファイル名をサニタイズ（安全なファイル名を生成）
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // ストレージパスを検証
                $newImagePath = $file->storeAs('tools', $filename, 'public');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['image_path' => '画像のアップロードに失敗しました。'])
                    ->withInput();
            }
        }

        // トランザクション内でToolとToolNameを同時更新
        try{
            DB::transaction(function () use ($validated, $newImagePath, $tool) {
                // Toolテーブルのデータを更新
                $toolData = [
                    'user_id'       => Auth::id(),
                    'official_name' => $validated['official_name'],
                    'category' => $validated['category'] ?? null,
                    'image_path' => $newImagePath,
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

            // 新しい画像がアップロードされた場合のみ、古い画像を削除
            if (isset($validated['image_path']) && $oldImagePath && $oldImagePath !== $newImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }
        } catch (\Exception $e) {
            // トランザクション失敗時、新しくアップロードした画像があれば削除
            if (isset($validated['image_path']) && $newImagePath !== $oldImagePath && $newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            return redirect()->back()
                ->withErrors(['error' => '更新に失敗しました。もう一度お試しください。'])
                ->withInput();
        }

        return redirect()->route('tools.show', $tool)
            ->with('success', '工具のデータを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        // 削除前に画像パスを保存
        $imagePath = $tool->image_path;

        // ツールを削除
        $tool->delete();

        // 画像ファイルを削除（nullチェックとパス重複を回避）
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('tools.index')
            ->with('success', '削除しました');
    }
}
