<?php require_once 'app/Views/partials/app.twig'; ?>

    <form class="w-25 m-5" method="post" action="/login">
        <h4>Sign in</h4>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Login</button>
        <small class="d-block">Don't have an account? <a href="/register">Register here</a></small>
    </form>

<?php require_once 'app/Views/partials/footer.template.php';