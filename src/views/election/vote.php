<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- En-tête -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Vote - <?= htmlspecialchars($election['title']) ?>
                </h2>
                <div class="h-1 w-24 bg-green-600 mx-auto mt-2 mb-4"></div>
                <p class="text-gray-600"><?= htmlspecialchars($election['description']) ?></p>
            </div>

            <?php if (!empty($candidates)): ?>
                <form action="index.php?page=vote&id=<?= $election['id'] ?>" method="POST" class="space-y-6">
                    <div class="space-y-4">
                        <?php foreach ($candidates as $candidate): ?>
                            <label class="block bg-gray-50 p-4 rounded-lg hover:bg-gray-100 cursor-pointer transition duration-150">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="radio" 
                                               name="candidate_id" 
                                               value="<?= $candidate['id'] ?>"
                                               required
                                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <?= htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']) ?>
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <?= htmlspecialchars($candidate['party_name']) ?>
                                        </p>
                                        <?php if (!empty($candidate['biography'])): ?>
                                            <p class="mt-1 text-sm text-gray-500">
                                                <?= htmlspecialchars($candidate['biography']) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="index.php?page=elections" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md text-white bg-green-600 hover:bg-green-700">
                            Voter
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-600">Aucun candidat n'est enregistré pour cette élection.</p>
                    <a href="index.php?page=elections" 
                       class="mt-4 inline-block px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Retour aux élections
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>