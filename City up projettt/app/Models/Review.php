<?php
declare(strict_types=1);
class Review {
 private string $file;
 public function __construct() { $this->file=__DIR__.'/../../storage/reviews.json'; }
 private function initial(): array {return ['nextId'=>1,'targets'=>[
  ['id'=>1,'type'=>'Commerce','name'=>'Café de Tunis'],
  ['id'=>2,'type'=>'Événement','name'=>'Festival de la ville'],
  ['id'=>3,'type'=>'Lieu','name'=>'Avenue Habib Bourguiba']
 ],'reviews'=>[]];}
 private function read(): array {
  if (!is_file($this->file)) return $this->initial();
  $d=json_decode((string)file_get_contents($this->file),true);
  return is_array($d)&&isset($d['reviews'],$d['targets'],$d['nextId'])?$d:$this->initial();
 }
 private function mutate(callable $callback): mixed {
  $lock=fopen(__DIR__.'/../../storage/.reviews.lock','c'); if(!$lock||!flock($lock,LOCK_EX)) throw new RuntimeException('Unable to lock review storage');
  try { $data=$this->read();$result=$callback($data);$tmp=tempnam(dirname($this->file),'rev');
   if(!$tmp||file_put_contents($tmp,json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR))===false) throw new RuntimeException('Unable to save reviews');
   rename($tmp,$this->file);return $result;
  } finally {flock($lock,LOCK_UN);fclose($lock);}
 }
 public function targets(): array {return $this->read()['targets'];}
 public function target(int $id): ?array { foreach($this->targets() as $t) if($t['id']===$id)return $t; return null; }
 public function all(bool $approvedOnly=false): array {
  $d=$this->read();$targets=array_column($d['targets'],null,'id');$res=[];
  foreach($d['reviews'] as $r){if($approvedOnly&&$r['status']!=='approved')continue;$r['target']=$targets[$r['targetId']]??['name'=>'Unknown','type'=>'—'];$res[]=$r;}
  return array_reverse($res);
 }
 public function one(int $id): ?array {foreach($this->all() as $r)if($r['id']===$id)return $r;return null;}
 public function average(int $targetId): array {
  $rows=array_filter($this->all(true),fn($r)=>$r['targetId']===$targetId);
  return ['count'=>count($rows),'average'=>$rows?round(array_sum(array_column($rows,'rating'))/count($rows),1):0];
 }
 public function add(array $input,string $owner): void {
  $this->mutate(function(&$d) use($input,$owner){
   $d['reviews'][]=['id'=>$d['nextId']++,'targetId'=>$input['targetId'],'author'=>$input['author'], 'owner'=>$owner,
     'rating'=>$input['rating'],'comment'=>$input['comment'],'status'=>'pending','created'=>date('Y-m-d H:i')];
  });
 }
 public function update(int $id,array $input,string $owner): bool {
  return $this->mutate(function(&$d)use($id,$input,$owner){foreach($d['reviews'] as &$r){if($r['id']===$id&&$r['owner']===$owner){
   $r['rating']=$input['rating'];$r['comment']=$input['comment'];$r['status']='pending';return true;}}return false;});
 }
 public function delete(int $id,string $owner,bool $moderator=false): bool {
  return $this->mutate(function(&$d)use($id,$owner,$moderator){foreach($d['reviews'] as $i=>$r){if($r['id']===$id&&($moderator||$r['owner']===$owner)){
   array_splice($d['reviews'],$i,1);return true;}}return false;});
 }
 public function moderate(int $id,string $status): bool {
  if(!in_array($status,['approved','rejected'],true))return false;
  return $this->mutate(function(&$d)use($id,$status){foreach($d['reviews'] as &$r){if($r['id']===$id){$r['status']=$status;return true;}}return false;});
 }
 public function addTarget(string $name,string $type): void {
  $this->mutate(function(&$d)use($name,$type){$ids=array_column($d['targets'],'id');$d['targets'][]=['id'=>$ids?max($ids)+1:1,'name'=>$name,'type'=>$type];});
 }
}
