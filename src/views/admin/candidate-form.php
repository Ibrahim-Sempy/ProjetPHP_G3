<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <?php echo isset($candidate) ? 'Modifier le candidat' : 'Ajouter un candidat'; ?>
    </h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=candidates/<?php echo isset($candidate) ? 'update&id=' . $candidate['id'] : 'create'; ?>" 
          method="POST" 
          enctype="multipart/form-data" 
          class="bg-white shadow-md rounded-lg p-6">
        
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="<?php echo isset($candidate) ? htmlspecialchars($candidate['name']) : ''; ?>"
                   required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
        </div>

        <div class="mb-6">
            <label for="party" class="block text-sm font-medium text-gray-700 mb-2">Parti politique</label>
            <input type="text" 
                   id="party" 
                   name="party" 
                   value="<?php echo isset($candidate) ? htmlspecialchars($candidate['party']) : ''; ?>"
                   required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
        </div>

        <div class="mb-6">
            <label for="platform" class="block text-sm font-medium text-gray-700 mb-2">Programme électoral</label>
            <textarea id="platform" 
                      name="platform" 
                      rows="4" 
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
            ><?php echo isset($candidate) ? htmlspecialchars($candidate['platform']) : ''; ?></textarea>
        </div>

        <div class="mb-6">
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
            <?php if (isset($candidate) && $candidate['photo_url']): ?>
                <div class="mb-2">
                    <img src="<?php echo htmlspecialchars($candidate['photo_url']); ?>" 
                         alt="Photo actuelle" 
                         class="h-32 w-32 object-cover rounded">
                </div>
            <?php endif; ?>
            <input type="file" 
                   id="photo" 
                   name="photo" 
                   accept="image/*"
                   <?php echo !isset($candidate) ? 'required' : ''; ?>
                   class="w-full">
        </div>

        <div class="flex justify-between">
            <button type="submit" 
                    class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                <?php echo isset($candidate) ? 'Mettre à jour' : 'Ajouter'; ?>
            </button>
            <a href="index.php?page=candidates" 
               class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                Annuler
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>