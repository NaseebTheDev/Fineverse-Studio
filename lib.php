<?php require_once __DIR__.'/config.php';
function esc($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function csrf(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void { if(!hash_equals($_SESSION['csrf']??'', $_POST['csrf']??'')) { http_response_code(403); exit('Invalid security token. Please return and try again.'); } }
function me(): ?array { if(empty($_SESSION['user_id'])) return null; $s=db()->prepare('SELECT e.*,u.role,u.email AS login_email,d.name department_name,j.title job_title FROM employees e JOIN users u ON u.employee_id=e.id LEFT JOIN departments d ON d.id=e.department_id LEFT JOIN job_titles j ON j.id=e.job_title_id WHERE e.id=? AND u.active=1'); $s->execute([$_SESSION['user_id']]); return $s->fetch() ?: null; }
function require_login(): array { $u=me(); if(!$u){ header('Location: index.php?page=login'); exit; } return $u; }
function admin(): array { $u=require_login(); if($u['role']!=='admin'){ http_response_code(403); exit('Admin access required.'); } return $u; }
function log_action(string $action, string $entity='', ?int $entityId=null): void { $u=me(); if($u) { $s=db()->prepare('INSERT INTO audit_logs(user_id,action,entity,entity_id,ip_address) VALUES(?,?,?,?,?)'); $s->execute([$u['id'],$action,$entity,$entityId,$_SERVER['REMOTE_ADDR']??'']); } }
function flash(string $msg, string $type='success'): void { $_SESSION['flash']=[$msg,$type]; }
function pull_flash(): ?array { $v=$_SESSION['flash']??null; unset($_SESSION['flash']); return $v; }
function fmt_money($n): string { return esc(setting('currency','PKR')).' '.number_format((float)$n,0); }
function duration($seconds): string { $seconds=(int)$seconds; return floor($seconds/3600).'h '.floor(($seconds%3600)/60).'m'; }
function upload_file(string $field, string $folder, array $types, int $max=5242880): ?string { if(empty($_FILES[$field]['name'])) return null; $f=$_FILES[$field]; if($f['error']!==UPLOAD_ERR_OK || $f['size']>$max) throw new RuntimeException('Upload failed or exceeds 5 MB.'); $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']); if(!in_array($mime,$types,true)) throw new RuntimeException('Unsupported file type.'); $ext=pathinfo($f['name'],PATHINFO_EXTENSION); $dir=UPLOAD_DIR.'/'.$folder; if(!is_dir($dir)) mkdir($dir,0755,true); $name=bin2hex(random_bytes(16)).'.'.strtolower($ext); if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$name)) throw new RuntimeException('Could not save upload.'); return 'uploads/'.$folder.'/'.$name; }
function nav(string $page,string $label,string $icon=''): string { global $current; return '<a class="nav-link '.($current===$page?'active':'').'" href="index.php?page='.$page.'"><span>'.$icon.'</span>'.$label.'</a>'; }
