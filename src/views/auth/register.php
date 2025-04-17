<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Inscription</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=register" method="POST" class="space-y-6">
        <div>
            <label for="nin" class="block text-sm font-medium text-gray-700">NIN</label>
            <input type="text" 
                   id="nin" 
                   name="nin" 
                   value="<?php echo isset($_POST['nin']) ? htmlspecialchars($_POST['nin']) : ''; ?>"
                   placeholder="Ex: AB12345678"
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" 
                       id="first_name" 
                       name="first_name"
                       value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" 
                       id="last_name" 
                       name="last_name"
                       value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
            <input type="tel" 
                   id="phone" 
                   name="phone"
                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                   placeholder="+224XXXXXXXXX"
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" 
                   id="email" 
                   name="email"
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input type="password" 
                   id="password" 
                   name="password"
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            <p class="mt-1 text-sm text-gray-500">
                Minimum 8 caractères, une majuscule et un chiffre
            </p>
        </div>

        <div>
            <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input type="password" 
                   id="mot_de_passe" 
                   name="mot_de_passe"
                   required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            <p class="mt-1 text-sm text-gray-500">
                Minimum 8 caractères, une majuscule et un chiffre
            </p>
        </div>

        <button type="submit"
                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
            S'inscrire
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>