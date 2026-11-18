<?php
declare(strict_types=1);
function h(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csrf(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(24)); return $_SESSION['csrf']; }
function verifyCsrf(): void { if (!hash_equals(csrf(), (string)($_POST['csrf'] ?? ''))) { http_response_code(403); exit('Invalid CSRF token'); } }
function redirectTo(string $page, array $params=[]): never { header('Location: index.php?'.http_build_query(array_merge(['page'=>$page],$params))); exit; }
