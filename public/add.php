<?php

    require_once "../vendor/autoload.php";
    require_once "../app/TemplateRenderer.php";
    require_once "../app/ToDoDAO.php";
    require_once "../app/ToDoDTO.php";
    require_once "../app/ToastDTO.php";
    require_once "../app/LoadEnv.php";

    LoadEnv::load();

    $renderer = new TemplateRenderer();

    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST") {

      try {

        $title = isset($_POST["title"]) ? $_POST["title"] : null;
        $description = isset($_POST["description"]) ? $_POST["description"] : null;

        $todoDAO = new ToDoDAO();
        $todoDTO = new ToDoDTO();

        $todoDTO->setTitle($title);
        $todoDTO->setDescription($description);

        $todoDAO->addItem($todoDTO);

        $_SESSION["toasts"][] = new ToastDTO("success", "Item added successfully");

      } catch(Exception $e) {
        $_SESSION["toasts"][] = new ToastDTO("error", "Error on add item");
      }

      header("Location: " . $_SERVER["REQUEST_URI"]);
      exit;

    }

    $toasts = isset($_SESSION["toasts"]) ? $_SESSION["toasts"] : [];

    echo $renderer->render("add.twig",[ "toasts" => $toasts, "action" => $_SERVER["REQUEST_URI"] ]);

    session_destroy();

?>
