<?php
// Update these values only if your local XAMPP MySQL account differs.
define('DB_HOST', '127.0.0.1'); define('DB_NAME', 'studio_portal');
define('DB_USER', 'root'); define('DB_PASS', '');
define('APP_NAME', 'FrameForge Studio'); define('UPLOAD_DIR', __DIR__ . '/uploads');
session_name('studio_portal_session'); session_start();
function db(): PDO { static $pdo; if (!$pdo) { $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); } return $pdo; }
function setting(string $key, string $fallback=''): string { try { $s=db()->prepare('SELECT setting_value FROM settings WHERE setting_key=?'); $s->execute([$key]); return $s->fetchColumn() ?: $fallback; } catch(Throwable $e){ return $fallback; } }
date_default_timezone_set(setting('timezone','Asia/Karachi'));
