<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Liste des Élections</h2>
            <div class="h-1 w-24 bg-green-600 mx-auto mt-2"></div>
        </div>

        <!-- Élections en cours -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Élections en cours</h3>
            <?php if (!empty($activeElections)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($activeElections as $election): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-l-4 border-green-500">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-xl font-semibold text-gray-900 mb-2">
                                        <?= htmlspecialchars($election['title']) ?>
                                    </h4>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                        En cours
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-4"><?= htmlspecialchars($election['description']) ?></p>
                                <div class="text-sm text-gray-500 mb-4">
                                    <p><strong>Début:</strong> <?= date('d/m/Y H:i', strtotime($election['start_date'])) ?></p>
                                    <p><strong>Fin:</strong> <?= date('d/m/Y H:i', strtotime($election['end_date'])) ?></p>
                                </div>
                                <a href="index.php?page=vote&id=<?= $election['id'] ?>" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition duration-150">
                                    Participer au vote
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-gray-50 rounded-lg p-6 text-center">
                    <p class="text-gray-600">Aucune élection en cours actuellement.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>