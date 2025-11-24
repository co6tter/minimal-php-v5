# minimal-php-v5

## Overview

シンプルなPHP製Todoアプリケーションです。Docker環境で動作し、基本的なCRUD操作とCSRF対策を実装しています。

A simple Todo application built with PHP, running in a Docker environment with basic CRUD operations and CSRF protection.

## Tech Stack

- **PHP**: 8.4.6 (FPM Alpine)
- **Database**: MySQL 8.4
- **Web Server**: Nginx 1.26 Alpine
- **Container**: Docker & Docker Compose
- **Dependency Manager**: Composer 2.8.8
- **Frontend**: Vanilla JavaScript
- **Timezone**: Asia/Tokyo

## Setup

1. `.env`ファイルを作成します：
```bash
cp .env.sample .env
```

2. `.env`ファイルにデータベース情報を設定します：
```env
DB_HOST=db
DB_PORT=3306
DB_ROOT_PASS=your_root_password
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
DB_CHARSET=utf8mb4
```

3. Dockerコンテナを起動します：
```bash
docker compose config
docker compose up -d
```

4. 依存関係をインストールします：
```bash
docker exec -it php composer install
```

## Usage

1. ブラウザで `http://localhost:8080` にアクセスします
2. 新しいTodoを追加するには、入力フォームにタイトルを入力します
3. チェックボックスをクリックして完了状態を切り替えます
4. 「x」ボタンをクリックしてTodoを削除します
5. 「Purge」ボタンをクリックして完了済みのTodoをすべて削除します

## Directory Structure

```
.
├── README.md
├── docker-compose.yml
├── .env.sample              # 環境変数のサンプル
├── nginx/
│   └── default.conf        # Nginx設定ファイル
├── php/
│   ├── Dockerfile          # PHPコンテナのDockerfile
│   └── php.ini             # PHP設定ファイル
└── src/
    ├── app/
    │   ├── config.php      # アプリケーション設定
    │   ├── Database.php    # データベース接続
    │   ├── Todo.php        # Todoロジック
    │   ├── Token.php       # CSRFトークン管理
    │   └── Utils.php       # ユーティリティ関数
    ├── public/
    │   ├── index.php       # エントリーポイント
    │   ├── css/            # スタイルシート
    │   └── js/             # JavaScriptファイル
    ├── composer.json       # Composer設定
    └── composer.lock       # Composer依存関係ロック
```

## License

This repository is for personal/private use only.
