<?php require_once 'app/Views/partials/header.template.php'; ?>

    <form class="w-25 m-5" method="post" action="/register">
        <h4>Register a new account</h4>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="passwordConfirm">Confirm Password</label>
            <input type="password" class="form-control" id="passwordConfirm"
                   name="passwordConfirm" placeholder="Confirm your password">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Register</button>
        <small class="d-block">Already have an account? <a href="/login">Login here</a></small>
    </form>

<?php require_once 'app/Views/partials/footer.template.php';