<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Candidats</h1>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="index.php?page=candidates/create" 
               class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark">
                Ajouter un candidat
            </a>
        <?php endif; ?>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($candidates as $candidate): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="flex justify-center p-6">
                    <?php if ($candidate['photo_url']): ?>
                        <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-primary shadow-lg">
                            <img src="<?php echo htmlspecialchars($candidate['photo_url']); ?>" 
                                alt="<?php echo htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']); ?>"
                                class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-300">
                        </div>
                    <?php else: ?>
                        <div class="w-48 h-48 rounded-full bg-gray-200 flex items-center justify-center border-4 border-primary shadow-lg">
                            <span class="text-4xl text-gray-500">
                                <?php echo strtoupper(substr($candidate['first_name'], 0, 1) . substr($candidate['last_name'], 0, 1)); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        <?php echo htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name']); ?>
                    </h2>
                    <p class="text-gray-600 mb-4">
                        <?php echo htmlspecialchars($candidate['party_name']); ?>
                    </p>
                    <div class="text-gray-500 mb-4">
                        <?php echo htmlspecialchars($candidate['biography']); ?>
                    </div>
                    
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <div class="flex justify-end space-x-2 mt-4">
                            <a href="index.php?page=candidates/edit&id=<?php echo $candidate['id']; ?>" 
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Modifier
                            </a>
                            <form action="index.php?page=candidates/delete" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?php echo $candidate['id']; ?>">
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?')"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>