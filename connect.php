<?php

try {
    $conn = new pdo('mysql:host=localhost;dbname=todolist', 'root', '');
} catch (PDOException $e) {
    echo "Erro ao se conectar: " . $e->getMessage();
}
