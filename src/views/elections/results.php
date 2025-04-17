<h2 class="mb-4">Résultats de l'élection</h2>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Candidat</th>
                <th>Parti</th>
                <th>Nombre de votes</th>
                <th>Pourcentage</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $totalVotes = array_sum(array_column($results, 'vote_count'));
            foreach($results as $result): 
                $percentage = ($totalVotes > 0) ? 
                    round(($result['vote_count'] / $totalVotes) * 100, 2) : 0;
            ?>
                <tr>
                    <td><?= htmlspecialchars($result['first_name'] . ' ' . $result['last_name']) ?></td>
                    <td><?= htmlspecialchars($result['party_name']) ?></td>
                    <td><?= $result['vote_count'] ?></td>
                    <td><?= $percentage ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>