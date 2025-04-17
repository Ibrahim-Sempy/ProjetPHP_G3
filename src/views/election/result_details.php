<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- En-tête avec titre de l'élection -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Résultats - <?= htmlspecialchars($election['title']) ?>
                </h2>
                <div class="h-1 w-24 bg-green-600 mx-auto mt-2 mb-4"></div>
            </div>

            <!-- Statistiques générales -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Total des votes</p>
                        <p class="text-2xl font-bold text-gray-900"><?= number_format($totalVotes) ?></p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Date de clôture</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= date('d/m/Y H:i', strtotime($election['end_date'])) ?>
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Statut</p>
                        <p class="text-2xl font-bold text-gray-900"><?= ucfirst($election['status']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Résultats par candidat -->
            <div class="space-y-4">
                <?php foreach ($results as $candidate): ?>
                    <?php 
                    $percentage = $totalVotes > 0 ? ($candidate['vote_count'] / $totalVotes) * 100 : 0;
                    $barColor = $percentage > 50 ? 'bg-green-500' : 'bg-blue-500';
                    ?>
                    <div class="bg-white border rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">
                                    <?= htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']) ?>
                                </h4>
                                <p class="text-sm text-gray-600">
                                    <?= htmlspecialchars($candidate['party_name']) ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">
                                    <?= number_format($percentage, 1) ?>%
                                </p>
                                <p class="text-sm text-gray-600">
                                    <?= number_format($candidate['vote_count']) ?> votes
                                </p>
                            </div>
                        </div>
                        <!-- Barre de progression -->
                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                            <div class="<?= $barColor ?> h-full transition-all duration-500"
                                 style="width: <?= $percentage ?>%">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Bouton retour -->
            <div class="mt-8 text-center">
                <a href="index.php?page=results" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                    Retour à la liste des résultats
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>