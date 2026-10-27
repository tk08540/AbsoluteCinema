<div class="container mt-5" style="max-width:500px">
    <h2 class="mb-4">Register</h2>

    <?php
    //ce je error ga tukaj prikazemo
    if (isset($error) && !empty($error)) { ?>
        <div class="alert alert-danger">
            <p><?= htmlspecialchars($error) ?></p>
        </div>

    <?php } ?>

    <form method="POST" action="<?= BASE_URL . "register-submit" ?>">
        <div class="mb-3">
        <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
        </div>

        <div class="mb-3">
        <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $username ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Register
        </button>
    </form>

</div>