<?php

require __DIR__ . '/connect.php';

session_start();

$file_name = '';

if ( isset($_POST['task_id']) && isset($_POST['task_id'])) {
    if ($_POST['task_name'] !== "") {

        if (isset($_FILES['task_image'])) {
            $ext = strtolower(substr($_FILES['task_image']['name'], -4));
            $file_name = md5(date('Y.m.d.H.i.s')) . $ext;
            $dir = 'uploads/';

            move_uploaded_file($_FILES['task_image']['tmp_name'], $dir . $file_name);
        }

        $stmt = $conn->prepare('UPDATE tasks SET task_name = :name, task_description = :description, task_image = :image, task_date = :date WHERE id = :id');
        $stmt->bindParam(':name', $_POST['task_name']);
        $stmt->bindParam(':description', $_POST['task_description']);
        $stmt->bindParam(':image', $file_name);
        $stmt->bindParam(':date', $_POST['task_date']);
        $stmt->bindParam(':id', $_POST['task_id']);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Dados atualizados.";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Falha ao atualizar os dados.";
            header('Location: index.php');
            exit();
        }
    }
} elseif ( isset($_POST['task_name']) ) {
    if ( $_POST['task_name'] != "" ){

        if (isset($_FILES['task_image'])) {
            $ext =strtolower(substr($_FILES['task_image']['name'], -4));
            $file_name = md5(date('Y.m.d.H.i.s')) . $ext;
            $dir='uploads/';

            move_uploaded_file($_FILES['task_image']['tmp_name'], $dir.$file_name);
        }

        $stmt = $conn->prepare('INSERT INTO tasks (task_name, task_description, task_image, task_date)
                            VALUES (:name, :description, :image, :date)');
        $stmt ->bindParam('name', $_POST['task_name']);
        $stmt ->bindParam('description', $_POST['task_description']);
        $stmt ->bindParam('image', $file_name);
        $stmt ->bindParam('date', $_POST['task_date']);

        if ($stmt->execute() ) {
            $_SESSION['success'] = "Dados cadastrados.";
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['error'] = "Dados não cadastrados.";
            header('Location: index.php;');
            exit();
        }

    } else {
        $_SESSION['message']="O campo nome da tarefa não pode ser vazio!";
        header('Location:index.php');
        exit();
    }
}

if (isset($_GET['key'])) {
    $stmt = $conn->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->bindParam(':id', $_GET['key']);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Dados Removidos";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Dados não Removidos";
        header('Location: index.php');
    }
    
}
?>