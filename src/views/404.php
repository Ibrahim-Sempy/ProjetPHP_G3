<?php require_once dirname(__DIR__) . '/views/layout/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-8">Page introuvable</h2>
        <p class="text-gray-600 mb-8">Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
        <a href="index.php" class="inline-block px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700">
            Retour à l'accueil
        </a>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/views/layout/footer.php'; ?>