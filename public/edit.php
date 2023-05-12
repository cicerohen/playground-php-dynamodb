<?php

    require_once "../vendor/autoload.php";
    require_once "../app/TemplateRenderer.php";
    require_once "../app/ToDoDAO.php";
    require_once "../app/ToDoDTO.php";
    require_once "../app/ToastDTO.php";
    require_once "../app/LoadEnv.php";

    LoadEnv::load();

    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST") {

      try {

        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $title = isset($_POST["title"]) ? $_POST["title"] : null;
        $description = isset($_POST["description"]) ? $_POST["description"] : null;

        $todoDTO = new ToDoDTO();
        $todoDTO->setId($id);
        $todoDTO->setTitle($title);
        $todoDTO->setDescription($description);

        if($todoDTO->getId() !== null) {
          $todoDAO = new ToDoDAO();
          $todoDAO->updateItem($todoDTO);
        }

        $_SESSION["toasts"][]  = new ToastDTO("success", "Item updated successfully");

      } catch(Exception $e) {
        $_SESSION["toasts"][]  = new ToastDTO("error", "Error on update item");
      }

      header("Location: " . $_SERVER["REQUEST_URI"]);
      exit;

    }

    $renderer = new TemplateRenderer();
    $todoDTO = new ToDoDTO();
    $toasts = isset($_SESSION["toasts"]) ? $_SESSION["toasts"] : [];

    try {

      $id = isset($_GET["id"]) ? $_GET["id"] : null;
      $todoDTO->setId($id);

      if($id !== null) {
        $todoDAO = new ToDoDAO();
        $todoDTO = $todoDAO->getItem($todoDTO);
      }

    } catch (Exception $e) {
      // echo $e->getMessage();
    }

    echo $renderer->render("edit.twig",
      [
        "todo" => $todoDTO,
        "toasts" => $toasts,
        "action" => $_SERVER["REQUEST_URI"]
      ]
    );

  session_destroy();

?>
