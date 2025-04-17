<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Résultats - <?= htmlspecialchars($election['title']) ?>
                </h2>
                <div class="h-1 w-24 bg-green-600 mx-auto mt-2 mb-4"></div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Décompte des votes</h3>
                    <span class="text-sm text-gray-600">
                        Total des votes: <?= number_format($totalVotes) ?>
                    </span>
                </div>

                <div class="space-y-4">
                    <?php foreach ($results as $candidate): ?>
                        <?php 
                        $percentage = number_format($candidate['percentage'], 1);
                        $barColor = $percentage > 50 ? 'bg-green-500' : 'bg-blue-500';
                        ?>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        <?= htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']) ?>
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        <?= htmlspecialchars($candidate['party_name']) ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-bold text-gray-900">
                                        <?= $percentage ?>%
                                    </span>
                                    <p class="text-sm text-gray-600">
                                        <?= number_format($candidate['vote_count']) ?> votes
                                    </p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="<?= $barColor ?> h-full transition-all duration-500" 
                                     style="width: <?= $percentage ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex justify-center mt-8">
                <a href="index.php?page=elections" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    Retour aux élections
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>