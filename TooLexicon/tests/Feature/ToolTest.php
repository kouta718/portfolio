<?php

use App\Models\User;
use App\Models\Tool;
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

        $response = $this->post('/tools', $toolData);
        $response->assertRedirect('/tools');
        $this->assertDatabaseHas('tools', [
            'official_name' => $toolData['official_name'],
        ]);
    });

    // 登録したデータを編集・更新
    it('edit and update tool data', function () {
        $toolData = Tool::factory()->create();

        $response = $this->put("/tools/{$toolData->id}", [
            'official_name' => '変更後',
        ]);

        $this->assertDatabaseHas('tools', [
            'id' => $toolData->id,
            'official_name' => '変更後',
        ]);

        $response = $this->post("/tools/{$toolData->id}/names", [
            'tool_id' => $toolData->id,
            'name' => '追加名',
        ]);

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
