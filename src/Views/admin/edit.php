<div class="container mt-5">
<a href="/logout" class="btn btn-warning">Cerrar Sesión</a>

    <h2>Editar usuario <?= $userId ?></h2>

    <form action="/admin/edit" method="post" class="mb-4">
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= $name ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="emailEdit" value="<?= $email ?>" required>
        </div>
        <input type="email" name="currentEmail" value="<?= $email ?>" hidden>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="passwordEdit" value="<?= $password ?>" required>
        </div>
        <div class="form-group">
            <label for="is_admin">Rol:</label>
            <select class="form-control" name="is_admin" id="is_admin">
                <option value="1">Admin</option>
                <option value="0">Usuario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Editar</button>
    </form>
</div>
