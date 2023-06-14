<?php

require __DIR__ . '/connect.php';

session_start();

$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->bindParam(':id', $_GET['key']);
$stmt->execute();
$data = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Editando a Tarefa</title>
</head>

<body>
    <div class="details-container">
        <div class="header">
            <h1>
                Editando
            </h1>
        </div>
        <form class="box-campos" action="task.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="details">
                    <dl>
                        <input type="hidden" name="task_id" value="<?php echo $data[0]['id']; ?>">
                        <dt>Nome da tarefa:</dt>
                        <dd>
                            <input type="text" name="task_name" value="<?php echo $data[0]['task_name'] ?>">
                        </dd>
                        <dt>Descrição da tarefa:</dt>
                        <dd>
                            <input type="text" name="task_description"
                                value="<?php echo $data[0]['task_description'] ?>">
                        </dd>
                        <dt>Data da tarefa:</dt>
                        <dd>
                            <input type="text" name="task_date" value="<?php echo $data[0]['task_date'] ?>">
                        </dd>
                    </dl>
                </div>
                <div class="image">
                    <img src="uploads/<?php echo $data[0]['task_image'] ?>" alt="Imagem da tarefa">
                    <input type="file" name="task_image">
                </div>

            </div>
            <button type="submit" class='btn-save'>Salvar</button>
            <button type="submit" class='btn-cancel' value="Cancelar"
                onclick="window.location.href='index.php'">Cancelar</button>
        </form>

        <div class="footer">
            <p>Desenvolvido por Larissa Lunguinho</p>
        </div>
    </div>
</body>

</html>