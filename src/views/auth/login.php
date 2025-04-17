<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Connexion</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=login" method="POST" class="space-y-6">
        <div>
            <label for="nin" class="block text-sm font-medium text-gray-700">NIN</label>
            <input type="text" 
                   id="nin" 
                   name="nin"
                   required
                   placeholder="Ex: AB12345678"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <div>
            <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input type="password" 
                   id="mot_de_passe" 
                   name="mot_de_passe"
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <button type="submit"
                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
            Se connecter
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Pas encore inscrit ? 
        <a href="index.php?page=register" class="text-primary hover:text-primary-dark">
            Créer un compte
        </a>
    </p>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>