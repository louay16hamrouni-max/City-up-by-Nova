<?php
declare(strict_types=1);
abstract class Controller {
 protected function render(string $view, array $data=[], bool $admin=false): void {
  extract($data, EXTR_SKIP); $title=$data['title']??'CityUp'; $currentPage=$data['currentPage']??'home';
  ob_start(); require __DIR__.'/../Views/pages/'.$view.'.php'; $content=ob_get_clean();
  require __DIR__.'/../Views/'.($admin?'layout.php':'front_layout.php');
 }
}
