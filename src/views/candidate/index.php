<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="sm:flex sm:items-center sm:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Gestion des Candidats</h1>
            <a href="index.php?page=candidate/create" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Ajouter un candidat
            </a>
        </div>

        <?php if (!empty($candidates)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parti politique</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($candidates as $candidate): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($candidate['photo_url']): ?>
                                        <img src="<?= htmlspecialchars($candidate['photo_url']) ?>" 
                                             alt="Photo" 
                                             class="h-10 w-10 rounded-full object-cover">
                                    <?php else: ?>
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="index.php?page=candidate/edit&id=<?= $candidate['id'] ?>" 
                                       class="text-green-600 hover:text-green-900 mr-3">Modifier</a>
                                    <button onclick="deleteCandidate(<?= $candidate['id'] ?>)" 
                                            class="text-red-600 hover:text-red-900">Supprimer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-gray-500">Aucun candidat n'a été ajouté pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteCandidate(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?')) {
        window.location.href = `index.php?page=candidate/delete&id=${id}`;
    }
}
</script>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>