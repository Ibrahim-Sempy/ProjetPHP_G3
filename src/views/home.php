<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="max-w-4xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Élections Présidentielles Guinée</h1>
        <p class="text-xl text-gray-600">Votre voix compte pour l'avenir de notre nation</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Comment voter ?</h2>
            <ul class="space-y-3 text-gray-600">
                <li class="flex items-center">
                    <span class="bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">1</span>
                    Inscrivez-vous sur la plateforme
                </li>
                <li class="flex items-center">
                    <span class="bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">2</span>
                    Vérifiez votre éligibilité
                </li>
                <li class="flex items-center">
                    <span class="bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">3</span>
                    Choisissez votre candidat
                </li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Dates importantes</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-gray-700">Inscription des électeurs</h3>
                    <p class="text-gray-600">Du 1er au 30 mai 2025</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Jour du vote</h3>
                    <p class="text-gray-600">15 juin 2025</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <?php if (!isset($_SESSION['voter_id'])): ?>
            <a href="index.php?page=register" 
               class="inline-block bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                S'inscrire maintenant
            </a>
        <?php else: ?>
            <a href="index.php?page=vote" 
               class="inline-block bg-secondary text-white px-6 py-3 rounded-lg hover:bg-secondary-dark transition-colors">
                Voter maintenant
            </a>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>