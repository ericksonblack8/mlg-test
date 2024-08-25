<?php

    // Display errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include database connection file
    require 'db/db_connection.php';

    function validateRequiredFields($fields) {
        $requiredFields = ['full-name', 'email', 'message', 'subject'];
        $errors = [];
        foreach ($requiredFields as $field) {
            if ( empty($_POST[$field]) ) {
                $errors[$field] = "El campo {$field} es requerido";
            }
        }
        return $errors;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ( validateRequiredFields($_POST) ) {
            // Return json data
            echo json_encode([
                'error' => true,
                'data' => validateRequiredFields($_POST)
            ]);
            exit;
        }

        if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
            // Return json data
            echo json_encode([
                'error' => true,
                'data' => [
                    'email' => 'El email no es válido'
                ]
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Check for valid phone
        if ( !empty($_POST['phone']) && !preg_match('/^\d{10}$/', $_POST['phone']) ) {
            // Return json data
            echo json_encode([
                'error' => true,
                'data' => [
                    'phone' => 'El teléfono no es válido'
                ]
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Example of inserting data into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (full_name, subject, email, phone, message, created_at) VALUES (:full_name, :subject, :email, :phone, :message, now())");
            $stmt->execute([
                ':full_name' => $_POST['full-name'],
                ':subject' => $_POST['subject'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':message' => $_POST['message']
            ]);

            echo json_encode([
                'error' => false,
                'data' => 'Mensaje enviado correctamente'
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo json_encode([
                'error' => true,
                'data' => [
                    'database' => 'Error al insertar datos en la base de datos: ' . $e->getMessage()
                ]
            ], JSON_UNESCAPED_UNICODE);
        }

    }