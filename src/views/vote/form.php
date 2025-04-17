<?php require_once __DIR__ . '/../layout/header.php'; ?>

 <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Voter</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=vote/submit" method="POST" class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="nin" class="block text-sm font-medium text-gray-700">NIN</label>
                <input type="text" id="nin" name="nin" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>
            <div>
                <label for="voter_card" class="block text-sm font-medium text-gray-700">Carte d'électeur</label>
                <input type="text" id="voter_card" name="voter_card" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">Choisissez votre candidat</label>
            <?php foreach ($candidates as $candidate): ?>
                <div class="flex items-center p-4 border rounded-lg hover:bg-gray-50">
                    <input type="radio" name="candidate_id" value="<?php echo $candidate['id']; ?>" required
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                    <label class="ml-3">
                        <span class="block text-sm font-medium text-gray-700">
                            <?php echo htmlspecialchars($candidate['name']); ?>
                        </span>
                        <span class="block text-sm text-gray-500">
                            <?php echo htmlspecialchars($candidate['party']); ?>
                        </span>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
            Voter
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>