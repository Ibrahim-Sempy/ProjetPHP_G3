<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Élections Guinée</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a56db',
                        secondary: '#059669'
                    }
                }
            }
        }
    </script>
    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="index.php" class="text-2xl font-bold text-primary">Élections Guinée</a>
                    </div>
                    <!-- Menu desktop -->
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="index.php" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                            Accueil
                        </a>
                        <?php if (isset($_SESSION['voter_id'])): ?>
                            <a href="index.php?page=vote" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Voter
                            </a>
                        <?php endif; ?>
                        <a href="index.php?page=candidates" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                            Candidats
                        </a>
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <a href="index.php?page=admin" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Administration
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Bouton menu mobile -->
                <div class="md:hidden flex items-center">
                    <button onclick="toggleMobileMenu()" class="text-gray-500 hover:text-gray-700 p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Boutons de connexion/déconnexion desktop -->
                <div class="hidden md:flex md:items-center">
                    <?php if (isset($_SESSION['voter_id'])): ?>
                        <a href="index.php?page=logout" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                           onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                            Déconnexion
                        </a>
                    <?php else: ?>
                        <a href="index.php?page=login" class="text-gray-500 hover:text-gray-700 px-3 py-2">
                            Connexion
                        </a>
                        <a href="index.php?page=register" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Inscription
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Menu mobile -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Accueil
                </a>
                <?php if (isset($_SESSION['voter_id'])): ?>
                    <a href="index.php?page=vote" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        Voter
                    </a>
                <?php endif; ?>
                <a href="index.php?page=candidates" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Candidats
                </a>
                <?php if (isset($_SESSION['voter_id'])): ?>
                    <a href="index.php?page=logout" 
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                       onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                        Déconnexion
                    </a>
                <?php else: ?>
                    <a href="index.php?page=login" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        Connexion
                    </a>
                    <a href="index.php?page=register" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 py-8">
</body>
</html>