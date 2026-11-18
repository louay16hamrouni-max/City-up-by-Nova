<?php
class HomeController extends Controller {
 public function index(): void { $this->render('home',['title'=>'CityUp | Explore Your City','currentPage'=>'home']); }
 public function dashboard(): void { $this->render('dashboard',['title'=>'CityUp | Dashboard','currentPage'=>'dashboard'],true); }
}
