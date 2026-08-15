<?php
// Update these values only if your local XAMPP MySQL account differs.
define('DB_HOST', 'sql310.infinityfree.com'); define('DB_NAME', 'if0_42662172_fineverse');
define('DB_USER', 'if0_42662172'); define('DB_PASS', 'HamdanOwais123');
define('APP_NAME', 'FineVerse Studio'); define('UPLOAD_DIR', __DIR__ . '/uploads');
// EmailJS Configuration - Replace these with your actual EmailJS credentials
// Get these from https://dashboard.emailjs.com/admin/account
define('EMAILJS_PUBLIC_KEY', 'wOeHrRYq3921-pZKt');      // e.g., 'user_abc123xyz'
define('EMAILJS_SERVICE_ID', 'service_5detxqp');      // e.g., 'service_abc123'
define('EMAILJS_TEMPLATE_ID', 'template_p05i1rs');    // e.g., 'template_xyz789'
define('ADMIN_EMAIL', 'fineversestudio@gmail.com');            // Change to your actual admin email
session_name('studio_portal_session'); session_start();
function db(): PDO { static $pdo; if (!$pdo) { $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); } return $pdo; }
function setting(string $key, string $fallback=''): string { try { $s=db()->prepare('SELECT setting_value FROM settings WHERE setting_key=?'); $s->execute([$key]); return $s->fetchColumn() ?: $fallback; } catch(Throwable $e){ return $fallback; } }
date_default_timezone_set(setting('timezone','Asia/Karachi'));
