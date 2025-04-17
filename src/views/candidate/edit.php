<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Modifier le candidat</h2>

            <?php if (isset($_SESSION['errors'])): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['errors']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?page=candidate/update&id=<?= htmlspecialchars($candidate['id']) ?>" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-6">

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" 
                           name="first_name" 
                           id="first_name" 
                           required
                           value="<?= htmlspecialchars($candidate['first_name']) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" 
                           name="last_name" 
                           id="last_name" 
                           required
                           value="<?= htmlspecialchars($candidate['last_name']) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label for="party_name" class="block text-sm font-medium text-gray-700">Parti politique</label>
                    <input type="text" 
                           name="party_name" 
                           id="party_name" 
                           required
                           value="<?= htmlspecialchars($candidate['party_name']) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label for="biography" class="block text-sm font-medium text-gray-700">Biographie</label>
                    <textarea name="biography" 
                              id="biography" 
                              rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    ><?= htmlspecialchars($candidate['biography'] ?? '') ?></textarea>
                </div>

                <div>
                    <?php if (!empty($candidate['photo_url'])): ?>
                        <label class="block text-sm font-medium text-gray-700">Photo actuelle</label>
                        <img src="<?= htmlspecialchars('/projetPHP/election-guinee/public' . $candidate['photo_url']) ?>" 
                             alt="Photo actuelle" 
                             class="mt-2 h-32 w-32 rounded-full object-cover">
                    <?php endif; ?>
                    
                    <label for="photo" class="block text-sm font-medium text-gray-700 mt-4">
                        <?= empty($candidate['photo_url']) ? 'Photo' : 'Nouvelle photo (optionnel)' ?>
                    </label>
                    <input type="file" 
                           name="photo" 
                           id="photo" 
                           accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <a href="index.php?page=candidate/manage" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>