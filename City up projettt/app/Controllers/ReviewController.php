<?php
declare(strict_types=1);
class ReviewController extends Controller {
 private Review $model;
 public function __construct(){ $this->model=new Review(); }
 private function owner(): string {if(empty($_SESSION['visitor_token']))$_SESSION['visitor_token']=bin2hex(random_bytes(16));return $_SESSION['visitor_token'];}
 public function index(): void {
  $items=$this->model->all(true);$all=$this->model->all();$targets=$this->model->targets();
  $editId=(int)($_GET['edit']??0);$edit=$editId?$this->model->one($editId):null;
  if($edit&&$edit['owner']!==$this->owner())$edit=null;
  $mine=array_values(array_filter($all,fn($r)=>$r['owner']===$this->owner()));
  $this->render('reviews',compact('items','targets','edit','mine')+['title'=>'CityUp | Reviews','currentPage'=>'reviews']);
 }
 private function validReview(): array {
  $targetId=(int)($_POST['targetId']??0);$rating=(int)($_POST['rating']??0);
  $author=trim((string)($_POST['author']??'Anonymous'));$comment=trim((string)($_POST['comment']??''));
  if(!$this->model->target($targetId)||$rating<1||$rating>5||mbLen($author)>70||$author===''||mbLen($comment)>1200||$comment===''){
    http_response_code(422);exit('Invalid input: choose a target, rate 1–5 and provide a short comment.');
  }
  return compact('targetId','rating','author','comment');
 }
 public function save(): void {
  verifyCsrf();$input=$this->validReview();$id=(int)($_POST['id']??0);
  if($id){if(!$this->model->update($id,$input,$this->owner())){http_response_code(403);exit('Not your review');}}
  else $this->model->add($input,$this->owner());
  redirectTo('reviews',['notice'=>'pending']);
 }
 public function remove(): void {
  verifyCsrf();if(!$this->model->delete((int)($_POST['id']??0),$this->owner())){http_response_code(403);exit('Not your review');}
  redirectTo('reviews',['notice'=>'deleted']);
 }
 public function moderate(): void {
  verifyCsrf(); // DEMO ONLY. Add real authenticated role checking before production.
  $id=(int)($_POST['id']??0);$action=(string)($_POST['action']??'');
  if($action==='delete')$this->model->delete($id,'',true);
  elseif(in_array($action,['approved','rejected'],true))$this->model->moderate($id,$action);
  redirectTo('moderation');
 }
 public function addTarget(): void {
  verifyCsrf();$name=trim((string)($_POST['name']??''));$type=(string)($_POST['type']??'');
  if($name===''||mbLen($name)>90||!in_array($type,['Commerce','Événement','Lieu'],true)){http_response_code(422);exit('Invalid target');}
  $this->model->addTarget($name,$type);redirectTo('moderation');
 }
 public function admin(): void {
  $items=$this->model->all();$targets=$this->model->targets();
  $pending=count(array_filter($items,fn($r)=>$r['status']==='pending'));
  $approved=count(array_filter($items,fn($r)=>$r['status']==='approved'));
  $this->render('moderation',compact('items','targets','pending','approved')+['title'=>'CityUp | Moderation','currentPage'=>'moderation'],true);
 }
}
function mbLen(string $s): int {return function_exists('mb_strlen')?mb_strlen($s):strlen($s);}
