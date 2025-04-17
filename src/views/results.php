<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Résultats des élections</h1>

    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Taux de Participation</h3>
            <p class="text-3xl font-bold text-primary"><?php echo $stats['participation_rate']; ?>%</p>
            <p class="text-sm text-gray-500 mt-2">
                <?php echo number_format($stats['total_votes']); ?> votes sur 
                <?php echo number_format($stats['total_voters']); ?> électeurs
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Résultats par Candidat</h2>
            <div class="space-y-6">
                <?php foreach ($results as $result): ?>
                    <div class="border-b pb-4 last:border-b-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h3 class="font-bold text-lg">
                                    <?php echo htmlspecialchars($result['name']); ?>
                                </h3>
                                <p class="text-gray-600">
                                    <?php echo htmlspecialchars($result['party']); ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-primary">
                                    <?php echo number_format($result['percentage'], 1); ?>%
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?php echo number_format($result['votes']); ?> votes
                                </p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-primary h-4 rounded-full" 
                                 style="width: <?php echo $result['percentage']; ?>%">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Distribution géographique</h2>
            <div id="map" class="h-96 w-full">
                <!-- Intégration de la carte ici -->
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>