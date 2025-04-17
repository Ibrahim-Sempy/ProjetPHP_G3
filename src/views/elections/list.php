<h2 class="mb-4">Élections en cours</h2>

<div class="row">
    <?php foreach($elections as $election): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($election['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($election['description']) ?></p>
                    <p>
                        <strong>Début:</strong> <?= date('d/m/Y H:i', strtotime($election['start_date'])) ?><br>
                        <strong>Fin:</strong> <?= date('d/m/Y H:i', strtotime($election['end_date'])) ?>
                    </p>
                    <?php if($election['status'] === 'active'): ?>
                        <a href="index.php?page=vote&id=<?= $election['id'] ?>" 
                           class="btn btn-primary">Voter</a>
                    <?php elseif($election['status'] === 'closed'): ?>
                        <a href="index.php?page=results&id=<?= $election['id'] ?>" 
                           class="btn btn-secondary">Voir les résultats</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>