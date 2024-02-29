<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header">
                    <h3>Verificación de Cuenta</h3>
                </div>
                <div class="card-body">
                    <p>Ingresa el código de verificación que hemos enviado a tu correo electrónico.</p>

                    <!-- Muestra mensajes de sesión si los hay -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-info">
                            <?= $_SESSION['message']; ?>
                            <?php unset($_SESSION['message']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/verify/verification" method="post">
                        <div class="form-group">
                            <label for="code">Código de Verificación:</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Verificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>