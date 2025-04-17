<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Liste des Candidats</h1>
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin']): ?>
            <a href="index.php?page=candidates/create" 
               class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark">
                Ajouter un candidat
            </a>
        <?php endif; ?>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($candidates as $candidate): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="<?php echo htmlspecialchars($candidate['photo_url']); ?>" 
                         alt="<?php echo htmlspecialchars($candidate['name']); ?>"
                         class="object-cover w-full h-48">
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">
                        <?php echo htmlspecialchars($candidate['name']); ?>
                    </h2>
                    <p class="text-gray-600 mb-4">
                        <?php echo htmlspecialchars($candidate['party']); ?>
                    </p>
                    <div class="text-sm text-gray-500 mb-4">
                        <?php echo htmlspecialchars($candidate['platform']); ?>
                    </div>
                    <?php if (isset($_SESSION['voter_id'])): ?>
                        <a href="index.php?page=vote/form&candidate=<?php echo $candidate['id']; ?>" 
                           class="block w-full text-center bg-secondary text-white px-4 py-2 rounded hover:bg-secondary-dark">
                            Voter pour ce candidat
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>