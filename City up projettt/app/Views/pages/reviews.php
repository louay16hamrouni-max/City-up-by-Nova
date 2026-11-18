<section class="review-hero"><div><span class="review-kicker">CITYUP COMMUNITY</span><h1>Avis &amp; Évaluations</h1>
<p>Découvrez les expériences des visiteurs, partagez votre avis et attribuez une note de 1 à 5 étoiles.</p></div><div class="hero-stars">★★★★★</div></section>
<div class="review-container">
<?php if(isset($_GET['notice'])): ?><div class="review-alert"><?= $_GET['notice']==='deleted'?'Avis supprimé.':'Avis enregistré ! Il sera visible après validation.' ?></div><?php endif; ?>
<div class="review-columns"><section class="review-panel"><h2><?= $edit?'Modifier mon avis':'Donner mon avis' ?></h2><p>Les avis sont examinés avant leur publication.</p>
<form method="post" action="index.php?page=review-save" class="review-form">
<input type="hidden" name="csrf" value="<?= h(csrf()) ?>"><input type="hidden" name="id" value="<?= h($edit['id']??0) ?>">
<label>Commerce, événement ou lieu
<select name="targetId" required <?= $edit?'disabled':'' ?>><?php foreach($targets as $target): ?><option value="<?= $target['id'] ?>" <?= ($edit['targetId']??0)===$target['id']?'selected':'' ?>><?= h($target['type']) ?> · <?= h($target['name']) ?></option><?php endforeach; ?></select></label>
<?php if($edit): ?><input type="hidden" name="targetId" value="<?= h($edit['targetId']) ?>"><?php endif; ?>
<label>Votre nom <input name="author" maxlength="70" required value="<?= h($edit['author']??'') ?>" placeholder="Votre nom"></label>
<label>Note (1 à 5 étoiles) <select name="rating" required><?php for($n=5;$n>=1;$n--): ?><option value="<?= $n ?>" <?= ($edit['rating']??5)===$n?'selected':'' ?>><?= str_repeat('★',$n).str_repeat('☆',5-$n) ?> — <?= $n ?>/5</option><?php endfor; ?></select></label>
<label>Votre avis <textarea name="comment" rows="5" maxlength="1200" required placeholder="Parlez-nous de votre expérience…"><?= h($edit['comment']??'') ?></textarea></label>
<div class="review-buttons"><button class="review-primary" type="submit"><?= $edit?'Enregistrer les modifications':'Publier mon avis' ?></button><?php if($edit): ?><a class="review-link" href="index.php?page=reviews">Annuler</a><?php endif; ?></div>
</form></section><section class="review-panel"><h2>Notes moyennes</h2><p>Calculées uniquement à partir des avis validés.</p>
<?php foreach($targets as $target): $s=(new Review())->average($target['id']); ?><div class="target-score"><div><strong><?= h($target['name']) ?></strong><small><?= h($target['type']) ?> · <?= $s['count'] ?> avis</small></div><div class="score-number"><b><?= number_format($s['average'],1) ?></b><span>★</span></div></div><?php endforeach; ?>
</section></div>
<section class="review-panel review-feed"><h2>Avis de la communauté</h2><p>Uniquement les avis approuvés par la modération.</p>
<div class="review-cards"><?php if(!$items): ?><div class="review-empty">Aucun avis publié pour le moment. Soyez le premier à donner votre avis !</div><?php endif; ?>
<?php foreach($items as $r): ?><article class="review-card"><div class="review-card-top"><div><strong><?= h($r['author']) ?></strong><small><?= h($r['target']['type']) ?> · <?= h($r['target']['name']) ?></small></div><span class="review-stars"><?= str_repeat('★',$r['rating']).str_repeat('☆',5-$r['rating']) ?></span></div><p><?= nl2br(h($r['comment'])) ?></p><small><?= h($r['created']) ?></small></article><?php endforeach; ?></div></section>
<section class="review-panel review-feed"><h2>Mes avis (cette session)</h2><p>Vous pouvez modifier ou supprimer vos propres avis depuis ce navigateur tant que votre session reste active.</p>
<?php if(!$mine): ?><div class="review-empty">Vous n'avez pas encore publié d'avis.</div><?php endif; ?>
<?php foreach($mine as $r): ?><div class="my-review"><span><?= h($r['target']['name']) ?> · <?= $r['rating'] ?>/5 · <b><?= h($r['status']) ?></b></span><span><a class="review-link" href="index.php?page=reviews&amp;edit=<?= $r['id'] ?>">Modifier</a>
<form method="post" action="index.php?page=review-delete" onsubmit="return confirm('Supprimer cet avis ?')"><input type="hidden" name="csrf" value="<?= h(csrf()) ?>"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="review-danger" type="submit">Supprimer</button></form></span></div><?php endforeach; ?></section></div>
