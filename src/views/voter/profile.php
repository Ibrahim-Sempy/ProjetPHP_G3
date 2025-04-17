<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Mon Profil</h2>

            <form action="index.php?page=profile" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prénom -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="<?= htmlspecialchars($voter['first_name']) ?>" 
                               required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="<?= htmlspecialchars($voter['last_name']) ?>" 
                               required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="<?= htmlspecialchars($voter['email']) ?>" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="<?= htmlspecialchars($voter['phone']) ?>" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <!-- Date de naissance -->
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" 
                               name="birth_date" 
                               id="birth_date" 
                               value="<?= htmlspecialchars($voter['birth_date']) ?>" 
                               required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <!-- Adresse -->
                    <div class="col-span-2">
                        <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <textarea name="adresse" 
                                  id="adresse" 
                                  required 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                                  rows="3"><?= htmlspecialchars($voter['adresse']) ?></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="index.php?page=elections" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md text-white bg-green-600 hover:bg-green-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>