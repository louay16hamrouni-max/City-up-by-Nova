<?php
return [
 'home'=>[HomeController::class,'index'],'dashboard'=>[HomeController::class,'dashboard'],
 'reviews'=>[ReviewController::class,'index'],'review-save'=>[ReviewController::class,'save'],
 'review-delete'=>[ReviewController::class,'remove'],'moderation'=>[ReviewController::class,'admin'],
 'review-moderate'=>[ReviewController::class,'moderate'],'target-add'=>[ReviewController::class,'addTarget']
];
