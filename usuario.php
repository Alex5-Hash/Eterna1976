<?php

$servername = "localhost";  
$username = "root";   
$password = "192005"; 
$dbname = "activos"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteSql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}

$sql = "SELECT id, usuario, nombre, clave, nivel FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Usuarios</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #F3F4F6;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #0078D4; /* Color principal de Microsoft */
        }
        .user-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .user-table th, .user-table td {
            border: 1px solid #E1E1E1;
            padding: 12px;
            text-align: left;
        }
        .user-table th {
            background-color: #0078D4;
            color: white;
        }
        .user-table tr:nth-child(even) {
            background-color: #F9F9F9;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-edit {
            background-color: #F3F4F6;
            color: #0078D4;
        }
        .btn-delete {
            background-color: #E74C3C;
            color: white;
        }
        .btn-edit:hover {
            background-color: #E1E1E1;
        }
        .btn-add {
            background-color: #0078D4;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
            display: inline-block;
        }
        .btn-add:hover {
            background-color: #005A9E;
        }
        .volver {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Datos de Usuarios</h1>

<table class="user-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Nivel</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["usuario"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nivel"]) . "</td>";
                echo "<td>
                        <a href='editar.php?id=" . htmlspecialchars($row["id"]) . "' class='btn btn-edit'>Editar</a>
                        <a href='?delete=" . htmlspecialchars($row["id"]) . "' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\")'>Eliminar</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 resultados</td></tr>";
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </tbody>
</table>

<div class="volver">
    <a href="index.php" class="btn btn-add">Volver</a>
</div>

</body>
</html>




