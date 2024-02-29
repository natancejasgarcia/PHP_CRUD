<div class="container mt-5">
<a href="/logout" class="btn btn-warning">Cerrar Sesión</a>

    <!-- Mensaje de sesión -->
    <div class="alert alert-info" role="alert">
        <?= isset($_SESSION['message']) ? $_SESSION['message'] : ""; ?>
    </div>
    <a href="/admin/addUserForm" class="btn btn-success mb-3">Añadir Nuevo Usuario</a>
    <h2>Lista de usuarios</h2>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Es Admin</th>
            </tr>
        </thead>
        <tbody>
            <?= $listeUtilisateurs; ?>
        </tbody>
    </table>
    <!--Paginacion -->
<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
        <a class="page-link" href="/admin?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>

</div>
