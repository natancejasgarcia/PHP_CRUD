<div class="container mt-5">
<a href="/logout" class="btn btn-warning">Cerrar Sesión</a>

    <h2>Añadir Nuevo Usuario</h2>

    <form action="/admin/addUserPost" method="post">
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="is_admin">Rol:</label>
            <select class="form-control" name="is_admin" id="is_admin">
                <option value="0">Usuario</option>
                <option value="1">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
    </form>
</div>
