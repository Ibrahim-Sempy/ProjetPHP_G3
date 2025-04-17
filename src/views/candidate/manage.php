<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <!-- En-tête avec titre et bouton d'ajout -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Gestion des Candidats</h2>
                <a href="index.php?page=candidate/create" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Ajouter un candidat
                </a>
            </div>

            <!-- Messages de succès/erreur -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (!empty($candidates)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parti</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($candidates as $candidate): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if (!empty($candidate['photo_url']) && file_exists(dirname(dirname(__DIR__)) . '/public' . str_replace('/projetPHP/election-guinee/public', '', $candidate['photo_url']))): ?>
                                            <img src="<?= htmlspecialchars($candidate['photo_url']) ?>"
                                                 alt="Photo de <?= htmlspecialchars($candidate['first_name']) ?>"
                                                 class="h-16 w-16 rounded-full object-cover">
                                        <?php else: ?>
                                            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?= htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?= htmlspecialchars($candidate['party_name']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full <?= $candidate['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= $candidate['is_active'] ? 'Actif' : 'Inactif' ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="index.php?page=candidate/edit&id=<?= htmlspecialchars($candidate['id']) ?>" 
                                           class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        <button onclick="toggleStatus(<?= $candidate['id'] ?>, <?= $candidate['is_active'] ?>)"
                                                class="text-<?= $candidate['is_active'] ? 'yellow' : 'green' ?>-600 hover:text-<?= $candidate['is_active'] ? 'yellow' : 'green' ?>-900">
                                            <?= $candidate['is_active'] ? 'Désactiver' : 'Activer' ?>
                                        </button>
                                        <button onclick="deleteCandidate(<?= $candidate['id'] ?>)" 
                                                class="text-red-600 hover:text-red-900">Supprimer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500 py-8">Aucun candidat enregistré.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function deleteCandidate(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?')) {
        window.location.href = `index.php?page=candidate/delete&id=${id}`;
    }
}

function toggleStatus(id, isActive) {
    if (confirm(`Êtes-vous sûr de vouloir ${isActive ? 'désactiver' : 'activer'} ce candidat ?`)) {
        window.location.href = `index.php?page=candidate/toggle&id=${id}`;
    }
}
</script>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>