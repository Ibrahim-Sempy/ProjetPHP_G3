<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Ajouter un candidat</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=candidates/create" method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Prénom</label>
            <input type="text" name="first_name" required 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="last_name" required 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Parti politique</label>
            <input type="text" name="party_name" required 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Biographie</label>
            <textarea name="biography" rows="4" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Photo</label>
            <input type="file" name="photo" accept="image/*" 
                   class="mt-1 block w-full">
        </div>

        <div class="flex justify-end space-x-4">
            <a href="index.php?page=admin/candidates" 
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Annuler
            </a>
            <button type="submit" 
                    class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">
                Ajouter
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>