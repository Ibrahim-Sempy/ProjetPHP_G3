<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Voter pour un candidat</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Modal de vérification -->
    <div id="voteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form id="voteForm" method="POST" action="index.php?page=vote/cast" class="space-y-4">
                <input type="hidden" id="selectedCandidateId" name="candidate_id" value="">
                
                <div>
                    <label for="nin" class="block text-sm font-medium text-gray-700">NIN</label>
                    <input type="text" id="nin" name="nin" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>

                <div>
                    <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeVoteModal()" 
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <?php foreach ($candidates as $candidate): ?>
                <li class="p-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <?php if ($candidate['photo_url']): ?>
                                <div class="h-16 w-16 rounded-full overflow-hidden">
                                    <img src="<?php echo htmlspecialchars($candidate['photo_url']); ?>" 
                                         alt="Photo de <?php echo htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']); ?>"
                                         class="h-full w-full object-cover">
                                </div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <h2 class="text-lg font-medium text-gray-900">
                                    <?php echo htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']); ?>
                                </h2>
                                <p class="text-gray-500">
                                    <?php echo htmlspecialchars($candidate['party_name']); ?>
                                </p>
                            </div>
                        </div>
                        <button type="button" 
                                onclick="openVoteModal(<?php echo $candidate['id']; ?>)"
                                class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark">
                            Voter
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
function openVoteModal(candidateId) {
    document.getElementById('selectedCandidateId').value = candidateId;
    document.getElementById('voteModal').classList.remove('hidden');
}

function closeVoteModal() {
    document.getElementById('voteModal').classList.add('hidden');
    document.getElementById('voteForm').reset();
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>