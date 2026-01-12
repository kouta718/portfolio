<?php

use App\Models\User;
use App\Models\Tool;
use App\Models\ToolName;
use Database\Seeders\ToolSeeder;

// ゲストでの操作
describe('Tools as guest', function () {

    // ゲストで一覧が表示
    it('can see tools data as guest', function () {
        $this->assertGuest();

        $response = $this->get('/tools');
        $response->assertStatus(200);
    });

    // ゲストで詳細ページが表示
    it('can see tool data as guest', function () {
        $tool = Tool::factory()->create();

        $this->assertGuest();

        $response = $this->get("/tools/{$tool->id}");
        $response->assertStatus(200);
    });
});

// ユーザーでの操作
describe('Tools as authenticated user', function () {
    // ユーザーを作成してログイン
    beforeEach(function () {
        $user = User::factory()->create();
        $this->actingAs($user);
    });

    // 名称（別名）を新規登録
    it('create tool data', function () {
        $toolData = Tool::factory()->make()->toArray();
        $toolNameData = ToolName::factory()->make()->toArray();

        // tool_namesを配列形式で統合
        $requestData = array_merge($toolData, [
            'tool_names' => [
                [
                    'name' => $toolNameData['name'],
                    'is_primary' => $toolNameData['is_primary'] ?? false,
                ]
            ]
        ]);

        $response = $this->post('/tools', $requestData);
        $response->assertRedirect('/tools');    
        $this->assertDatabaseHas('tools', [
            'official_name' => $toolData['official_name'],
        ]);
        $this->assertDatabaseHas('tool_names', [
            'name' => $toolNameData['name'],
        ]);
    });

    // 登録したデータを編集・更新
    it('edit and update tool data', function () {
        $toolData = Tool::factory()->hasToolNames(3)->create();
        
        // 既存のtool_namesを取得して、1つ追加
        $existingToolNames = $toolData->toolNames->take(2)->map(function ($toolName) {
            return [
                'name' => $toolName->name,
                'is_primary' => $toolName->is_primary,
            ];
        })->toArray();
        
        // 新しいtool_nameを追加
        $existingToolNames[] = [
            'name' => '追加名',
            'is_primary' => false,
        ];
        
        $response = $this->put("/tools/{$toolData->id}", [
            'official_name' => '変更後',
            'tool_names' => $existingToolNames,
        ]);

        $response->assertRedirect("/tools/{$toolData->id}");

        $this->assertDatabaseHas('tools', [
            'id' => $toolData->id,
            'official_name' => '変更後',
        ]);
        
        // 追加したtool_nameが存在することを確認
        $this->assertDatabaseHas('tool_names', [
            'tool_id' => $toolData->id,
            'name' => '追加名',
        ]);
        
    });

    // 検索（本名・別名で検索）
    it('search tools data', function () {
        $this->seed(ToolSeeder::class);

        $response =$this->get('/tools?keyword=テスト');

        $response->assertStatus(200);
        $response->assertSee('テスト');
    });
});
