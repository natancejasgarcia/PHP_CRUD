<div class="container mt-5">


    <!-- Mensaje de sesión -->
    <div class="alert alert-info" role="alert">
        <?= isset($_SESSION['message']) ? $_SESSION['message'] : ""; ?>
    </div>

    <!-- Formulario de Login -->
    <h2>Login</h2>
    <form action="/login" method="post" class="mb-4">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <!-- Formulario de Registro -->
    <h2>Registrar</h2>
    <form action="/register" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="emailReg">Email:</label>
            <input type="email" class="form-control" name="email" id="emailReg" required>
        </div>
        <div class="form-group">
            <label for="passwordReg">Password:</label>
            <input type="password" class="form-control" name="password" id="passwordReg" required>
        </div>
        <button type="submit" class="btn btn-success">Registrar</button>
    </form>
</div>
