<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Candidats à l'élection</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($candidates as $candidate): ?>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-col items-center">
                    <!-- Photo -->
                    <?php if (!empty($candidate['photo_url'])): ?>
                        <img src="<?= htmlspecialchars($candidate['photo_url']) ?>"
                             alt="Photo de <?= htmlspecialchars($candidate['first_name']) ?>"
                             class="w-32 h-32 rounded-full object-cover">
                    <?php endif; ?>

                    <!-- Nom et parti -->
                    <h2 class="text-xl font-semibold mt-4">
                        <?= htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']) ?>
                    </h2>
                    <p class="text-gray-600 mt-2">
                        <?= htmlspecialchars($candidate['party_name']) ?>
                    </p>

                    <!-- Bouton Voter -->
                    <button onclick="openVoteModal(<?= $candidate['id'] ?>)"
                            class="mt-4 w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition-colors duration-200">
                        Voter
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal de vote -->
    <div id="voteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto md:mt-24">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold mb-4">Voter pour un candidat</h3>
                <form id="voteForm" action="index.php?page=vote/submit" method="POST">
                    <input type="hidden" name="candidate_id" id="candidateId">
                    
                    <div class="mb-4">
                        <label for="nin" class="block text-sm font-medium text-gray-700">
                            Numéro d'Identification Nationale
                        </label>
                        <input type="text" id="nin" name="nin" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="mb-6">
                        <label for="voter_card" class="block text-sm font-medium text-gray-700">
                            Numéro de carte d'électeur
                        </label>
                        <input type="text" id="voter_card" name="voter_card" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeVoteModal()"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page chargée, vérification des boutons...');
        // Vérifier que les boutons sont présents
        const buttons = document.querySelectorAll('button[onclick^="openVoteModal"]');
        console.log('Nombre de boutons trouvés :', buttons.length);
    });

    function openVoteModal(candidateId) {
        console.log('Ouverture de la modale pour le candidat:', candidateId);
        const modal = document.getElementById('voteModal');
        document.getElementById('candidateId').value = candidateId;
        modal.classList.remove('hidden');
    }

    function closeVoteModal() {
        console.log('Fermeture de la modale');
        const modal = document.getElementById('voteModal');
        modal.classList.add('hidden');
        document.getElementById('voteForm').reset();
    }
    </script>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>