<?php
require_once __DIR__ . '/../../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';
?>

<div class="container py-4">
    <div class="mb-4 text-center">
        <p class="adminFlourish mb-2"><sub>⟡</sub>☾<sup>⟡</sup></p>
        <h1 class="montecarlo-regular mb-2 fw-bold">Manage User</h1>
        <p class="text-muted">Let's take a look at this journaler.</p>
    </div>

    <!-- User Details Card -->
    <div class="userCard card shadow-sm">
        <div class="card-body">
            
            <div class="d-flex justify-content-between">    
                <h5 class="mb-3"><?= htmlspecialchars($user['username']) ?></h5>

                <!-- Promote/Demote Button -->
                <form method="POST" action="<?= BASE_URL ?>controllers/admin_controller.php">
                    <input type="hidden" name="action" value="updateRole">
                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                    <?php if ($user['role'] === 'user'): ?>
                        <button type="submit" name="new_role" value="admin"
                            class="btn btn-xs btn-outline-success rounded-pill btn-sm">
                            Promote to Admin
                        </button>
                    <?php else: ?>
                        <button type="submit" name="new_role" value="user"
                            class="btn btn-xs btn-outline-danger rounded-pill btn-sm">
                            Demote to User
                        </button>
                    <?php endif; ?>
                </form>
            </div>            

            <p class="mb-2">
                <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
            </p>

                <p class="mb-2">
                    <strong>Role:</strong> <?= htmlspecialchars($user['role']) ?>
                </p>

            <p class="mb-2">
                <strong>Joined:</strong> <?= htmlspecialchars($user['date_joined']) ?>
            </p>

            <p class="mb-2">
                <strong>Total Entries:</strong> <?= $entryCount ?>
            </p>

            <p class="mb-2">
                <strong>This Week's Mood:</strong>
                <?= !empty($summary['dominantMood']) 
                    ? htmlspecialchars($summary['dominantMood']) 
                    : 'Still unfolding 🌱' ?>
            </p>

            <div class="mt-3">
                <p class="mb-2">
                    <strong>Mood Summary:</strong>
                    For a peek into their garden of emotions, visit their weekly mood tracker for the month below.
                </p>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="<?= BASE_URL ?>views/users/garden.php?id=<?= $user['user_id'] ?>"
                        class="btn btn-outline-success rounded-pill">
                        View Garden
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="<?= BASE_URL ?>controllers/admin_controller.php?action=manageUsers"
           class="btn btn-outline-secondary rounded-pill">
            Back
        </a>
        
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>