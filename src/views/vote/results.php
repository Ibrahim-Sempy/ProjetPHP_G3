<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Résultats du vote</h2>
            
            <?php if ($totalVotes > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($results as $result): ?>
                        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                            <div class="flex flex-col items-center">
                                <?php if (!empty($result['photo_url'])): ?>
                                    <img src="<?= htmlspecialchars('/projetPHP/election-guinee/public' . $result['photo_url']) ?>"
                                         alt="Photo de <?= htmlspecialchars($result['first_name']) ?>"
                                         class="w-24 h-24 rounded-full object-cover mb-4">
                                <?php endif; ?>
                                
                                <h3 class="text-lg font-semibold text-center">
                                    <?= htmlspecialchars($result['first_name'] . ' ' . $result['last_name']) ?>
                                </h3>
                                <p class="text-sm text-gray-600 text-center mb-4">
                                    <?= htmlspecialchars($result['party_name']) ?>
                                </p>
                                
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    <div class="bg-green-600 h-2 rounded-full" 
                                         style="width: <?= ($result['vote_count'] / $totalVotes) * 100 ?>%">
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <span class="text-2xl font-bold text-gray-900">
                                        <?= $result['vote_count'] ?>
                                    </span>
                                    <span class="text-gray-600">
                                        votes (<?= number_format(($result['vote_count'] / $totalVotes) * 100, 1) ?>%)
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-8 text-center text-gray-600">
                    Total des votes : <span class="font-bold"><?= $totalVotes ?></span>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500 py-8">
                    Aucun vote n'a encore été enregistré.
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>