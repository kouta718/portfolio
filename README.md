# TooLexicon

製造業・建設現場で使用される工具の
**正式名称・通称・略称を一元管理し、検索できるWebアプリケーション**です。

工具が別名で呼ばれることによる認識齟齬を防ぎ、
画像と検索機能によって直感的に工具を特定できることを目的としています。
新人や異動者、非作業者でも迅速に工具を特定できるようにし、作業効率と安全性を向上させる。
※ ゲストユーザーでも一覧・検索・詳細閲覧が可能

---

## 概要（Overview）

現場や個人環境で、

- 工具の正式名称が分からない
- 人によって呼び方が違う
- 名前は分からないが見た目は分かる

といった課題を解決するために作成しました。

### 特徴

- 正式名称・通称・略称を紐づけて管理
- 画像による視覚的な判別
- 本名・別名を横断した部分一致検索

---

## 主な機能（Features）

- 工具データのCRUD（作成・編集・削除・表示）
- 通称・略称（エイリアス）の複数登録
- 画像アップロード（プレビュー表示）
- 本名・別名を対象とした部分一致対応の検索機能
- ページネーション対応
- 外部リンク（Amazon / モノタロウ）登録
- レスポンシブデザイン（スマホ対応）

---

## 使用技術（Tech Stack）

### バックエンド

- PHP 8.4
- Laravel 12
- PostgreSQL

### フロントエンド

- Blade
- Tailwind CSS
- JavaScript（Vanilla）
- Vite

### 開発環境

- Docker / Laravel Sail
- Laravel Breeze（認証）
- Pest（テストフレームワーク）

---

## 画面イメージ（Screenshots）

- 一覧画面
  <img width="1920" height="1080" alt="index" src="https://github.com/user-attachments/assets/a59a7e7b-f999-44e3-b3a2-4d28f3bb6a00" />
- 詳細画面
  <img width="1920" height="1080" alt="show" src="https://github.com/user-attachments/assets/44642489-809b-476b-96dd-49bf72dba23c" />
- 登録 / 編集画面
  <img width="1920" height="1080" alt="create-edit" src="https://github.com/user-attachments/assets/8e0051db-3888-481f-b3cb-d44cac9d5026" />


---

## 環境構築（Setup）

### 前提条件

- Docker Desktop
- Git

### インストール手順（Laravel Sail）

```bash
git clone https://github.com/kouta718/portfolio.git
cd TooLexicon

# .envファイルの作成と設定
cp .env.example .env
# .envファイルのDB設定を確認・編集（必要に応じて）

# 依存関係のインストール
composer install

# Dockerコンテナの起動
./vendor/bin/sail up -d

# アプリケーションキーの生成
./vendor/bin/sail artisan key:generate

# データベースのマイグレーション
./vendor/bin/sail artisan migrate

# 工具のダーミーデータ用のシーディング
./vendor/bin/sail artisan db:seed --class=ToolSeeder

# ストレージリンクの作成（画像アップロード用）
./vendor/bin/sail artisan storage:link

# フロントエンド依存関係のインストール
./vendor/bin/sail npm install

# 開発環境：Vite開発サーバー起動（別ターミナルで実行）
./vendor/bin/sail npm run dev
```

### 注意事項

- 初回起動時は、コンテナの起動に数分かかる場合があります
- Vite開発サーバーは別ターミナルで `./vendor/bin/sail npm run dev` を実行してください
- `.env`ファイルの`DB_*`設定は、PostgreSQLのデフォルト設定で動作します

### アクセス

- アプリケーション: [http://localhost](http://localhost/)
- Vite開発サーバー: [http://localhost:5173](http://localhost:5173/)

---

## テスト（Testing）

- フレームワーク: Pest
- 実行方法:
```bash
# Laravel Sail環境でのテスト実行
./vendor/bin/sail artisan test

# 基本機能のテストファイルのみ実行
./vendor/bin/sail artisan test tests/Feature/ToolTest.php
```

- ToolTest.php: 工具機能の主要操作をゲスト／認証ユーザー両方でテスト
- テストデータ: テスト実行時に作成されるデータは一時的なもので、各テスト終了後に自動的に破棄されます（`RefreshDatabase` トレイト使用）

---

## 設計・実装の工夫

- 工具の呼び方は現場や人によって大きく異なるため、
  データの正確性よりも網羅性を優先し、Wiki的な運用を想定しています。
  そのため、登録ユーザー以外でも名称情報を追加・編集できる設計としています。
- 検索ロジックはModelスコープとして定義し、Controllerを簡潔に保っています
- 本名・別名検索を1つの条件グループにまとめ、拡張しやすい構造にしています
- 画像はDBにパスのみ保存し、責務を分離しています
- 画像アップロードは public storage に保存し、ファイル名を安全に生成しています
- バリデーションはFormRequestに集約し、Controllerの責務を最小限にしています

---

## 今後の実装予定（Future Plans）

- 検索条件の拡張（カテゴリ・タグ）
- 検索履歴機能
- PDF出力
- UI / UX改善
