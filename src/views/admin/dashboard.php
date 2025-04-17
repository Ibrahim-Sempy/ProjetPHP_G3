<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Administration</h1>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Total des électeurs</h2>
            <p class="text-3xl font-bold text-primary"><?php echo $totalVoters; ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Votes exprimés</h2>
            <p class="text-3xl font-bold text-primary"><?php echo $totalVotes; ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Taux de participation</h2>
            <p class="text-3xl font-bold text-primary">
                <?php echo $totalVoters > 0 ? round(($totalVotes / $totalVoters) * 100, 2) : 0; ?>%
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Gestion des candidats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des candidats</h2>
            <a href="index.php?page=candidate/manage" 
               class="block w-full bg-primary text-white text-center px-4 py-2 rounded hover:bg-primary-dark">
                Gérer les candidats
            </a>
        </div>

        <!-- Gestion des photos -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des photos</h2>
            <a href="index.php?page=admin/photos" 
               class="block w-full bg-primary text-white text-center px-4 py-2 rounded hover:bg-primary-dark">
                Gérer les photos
            </a>
        </div>

        <!-- Résultats des votes -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Résultats des votes</h2>
            <a href="index.php?page=vote-results" 
               class="block w-full bg-primary text-white text-center px-4 py-2 rounded hover:bg-primary-dark">
                Voir les résultats
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>