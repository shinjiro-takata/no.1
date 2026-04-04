## ファイル名

no.1

## 環境構築

git clone git@github.com:shinjiro-takata/no.1.git  
docker-compose up -d --build  
docker-compose exec php composer install  
docker-compose exec php php artisan migrate --seed

※ `composer install` と `php artisan` は、ホストではなく `php` コンテナ内で実行してください。

## 使用技術（実行環境）

PHP 8.1  
Laravel 8.83.8  
Laravel Fortify  
MySQL 8.0.26  
nginx 1.21.1  
Docker / Docker Compose  
phpMyAdmin  
Laravel Mix  
maatwebsite/excel

## ER図

<img width="691" height="681" alt="ER drawio" src="https://github.com/user-attachments/assets/7da04b7d-3ee5-42b4-b774-85ca26928f61" />

## URL

- 開発環境: http://localhost/
- 会員登録画面: http://localhost/register
- ログイン画面: http://localhost/login
- 管理画面: http://localhost/admin
- phpMyAdmin: http://localhost:8080/

※ 確認画面・送信完了画面はフォーム送信後に遷移します。
