<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Résultats des Élections</h2>
            <div class="h-1 w-24 bg-green-600 mx-auto mt-2"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($closedElections as $election): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-l-4 border-gray-500">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">
                            <?= htmlspecialchars($election['title']) ?>
                        </h4>
                        <div class="text-sm text-gray-500 mb-4">
                            <p><strong>Date de clôture:</strong> <?= date('d/m/Y H:i', strtotime($election['end_date'])) ?></p>
                        </div>
                        <a href="index.php?page=results&id=<?= $election['id'] ?>" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Voir les résultats détaillés
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($closedElections)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600">Aucune élection terminée pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>