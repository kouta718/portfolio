# TooLexicon

製造業・建設現場で使用される工具の

**正式名称・通称・略称を一元管理し、検索できるWebアプリケーション**です。

工具が別名で呼ばれることによる認識齟齬を防ぎ、

画像と検索機能によって直感的に工具を特定できることを目的としています。

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
- 本名・別名を対象とした検索機能
- ページネーション対応
- 外部リンク（Amazon / モノタロウ）登録
- レスポンシブデザイン（スマホレイアウト）

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

---

## 画面イメージ（Screenshots）

※ 後日追加予定

- 一覧画面
- 詳細画面
- 登録 / 編集画面

---

## 環境構築（Setup）

### 前提条件

- Docker Desktop
- Git

### インストール手順（Laravel Sail）

```bash
git clone <https://github.com/kouta718/portfolio.git>
cd TooLexicon

cp .env.example .env
composer install

./vendor/bin/sail up -d
./vendor/bin/sail npm install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
```

### アクセス

- アプリケーション: [http://localhost](http://localhost/)
- Vite開発サーバー: [http://localhost:5173](http://localhost:5173/)

---

## 設計・実装の工夫

- 検索ロジックはModelスコープとして定義し、Controllerを簡潔に保っています
- 本名・別名検索を1つの条件グループにまとめ、拡張しやすい構造にしています
- 画像はDBにパスのみ保存し、責務を分離しています
- バリデーションはFormRequestに集約しています

---

## 今後の実装予定（Future Plans）

- 検索条件の拡張（カテゴリ・タグ）
- 検索履歴機能
- PDF出力
- UI / UX改善