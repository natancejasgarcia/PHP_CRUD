<?php if (isset($_SESSION['user'])): ?>
    <h2>Hola usuario <?= $_SESSION['user'] ?></h2>
<?php else: ?>
    <h2>Hola usuario</h2>
<?php endif; ?>
<a href="/logout" class="btn btn-warning">Cerrar Sesión</a>
