<?php
$servername = "localhost";
$username = "root"; 
$password = "192005"; 
$dbname = "activos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM eterna WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Activo = $conn->real_escape_string($_POST['Activo']);
    $Serie = $conn->real_escape_string($_POST['Serie']);
    $Ubicacion = $conn->real_escape_string($_POST['Ubicacion']);
    $Fecha = $conn->real_escape_string($_POST['Fecha']);
    $Pais = $conn->real_escape_string($_POST['Pais']);

    $sql = "UPDATE eterna SET `Activo`=?, Serie=?, Ubicacion=?, Fecha=?, Pais=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $Activo, $Serie, $Ubicacion, $Fecha, $Pais, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al modificar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Activo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        img {
            width: 200px;
            height: 100px;
            margin-bottom: 20px;
        }
        h1 {
            color: #0d5588;
            font-size: 36px;
            margin: 0;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        form h2 {
            color: #0d5588;
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        form input, form select {
            padding: 10px;
            margin-bottom: 15px;
            width: calc(100% - 22px);
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form button, .btn-cancel {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 48%;
            margin-right: 4%;
            display: inline-block;
            text-align: center;
        }
        form button {
            background-color: #CD5328;
        }
        form button:hover {
            background-color: #094d6c;
        }
        .btn-cancel {
            background-color: #D2B48C; /* Color café claro */
            text-decoration: none; /* Sin subrayado */
        }
        .btn-cancel:hover {
            background-color: #C2A86A; /* Color más oscuro al pasar el mouse */
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="eterna.png" alt="Descripción de la imagen">
    <h1>Equipo de Cómputo Eterna</h1>
</div>

<form action="" method="post">
    <h2>Modificar Activo</h2>

    <label for="Categoria">Categoría:</label>
    <input type="text" id="Categoria" name="Categoria" value="<?php echo htmlspecialchars($row['Categoria']); ?>" readonly>

    <label for="Codigo">Código:</label>
    <input type="text" id="Codigo" name="Codigo" value="<?php echo htmlspecialchars($row['Codigo']); ?>" readonly>

    <label for="Activo">Descripción Activo:</label>
    <input type="text" id="Activo" name="Activo" value="<?php echo htmlspecialchars($row['Activo']); ?>" required>

    <label for="Serie">Serie:</label>
    <input type="text" id="Serie" name="Serie" value="<?php echo htmlspecialchars($row['Serie']); ?>" required>

    <label for="Ubicacion">Ubicación:</label>
    <input type="text" id="Ubicacion" name="Ubicacion" value="<?php echo htmlspecialchars($row['Ubicacion']); ?>" required>

    <label for="Fecha">Fecha:</label>
    <input type="date" id="fecha" name="Fecha" value="<?php echo htmlspecialchars($row['Fecha']); ?>" required>

    <label for="Pais">País:</label>
    <input type="text" id="Pais" name="Pais" value="<?php echo htmlspecialchars($row['Pais']); ?>" required>

    <div class="btn-container">
        <button type="submit">Guardar Cambios</button>
        <a href="index.php" class="btn-cancel">Cancelar</a>
    </div>
</form>

</body>
</html>

