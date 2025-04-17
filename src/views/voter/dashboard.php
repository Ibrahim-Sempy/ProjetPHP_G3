<?php 
require_once dirname(__DIR__) . '/layout/header.php';
if (!isset($_SESSION['voter_id'])) {
    header('Location: index.php?page=login');
    exit;
}
?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête du tableau de bord -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Bienvenue, <?= htmlspecialchars($_SESSION['voter_name']) ?></h1>
                    <p class="text-gray-600 mt-1">Votre espace électeur personnel</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        Électeur vérifié
                    </span>
                </div>
            </div>
        </div>

        <!-- Grille des actions principales -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Carte des élections en cours -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Élections en cours</h2>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                        Actif
                    </span>
                </div>
                <p class="mt-2 text-gray-600">Consultez et participez aux élections en cours</p>
                <a href="index.php?page=elections" class="mt-4 inline-flex items-center text-yellow-600 hover:text-yellow-700">
                    Voir les élections
                    <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>

            <!-- Carte des résultats -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <h2 class="text-lg font-semibold text-gray-900">Résultats</h2>
                <p class="mt-2 text-gray-600">Consultez les résultats des élections terminées</p>
                <a href="index.php?page=results" class="mt-4 inline-flex items-center text-blue-600 hover:text-blue-700">
                    Voir les résultats
                    <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>

            <!-- Carte du profil -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <h2 class="text-lg font-semibold text-gray-900">Mon profil</h2>
                <p class="mt-2 text-gray-600">Gérez vos informations personnelles</p>
                <a href="index.php?page=profile" class="mt-4 inline-flex items-center text-green-600 hover:text-green-700">
                    Modifier le profil
                    <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Historique des votes -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Historique de participation</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Élection
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Les données seront insérées dynamiquement ici -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>