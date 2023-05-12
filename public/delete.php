<?php

    require_once "../vendor/autoload.php";
    require_once "../app/TemplateRenderer.php";
    require_once "../app/ToDoDAO.php";
    require_once "../app/ToDoDTO.php";
    require_once "../app/ToastDTO.php";
    require_once "../app/LoadEnv.php";

    LoadEnv::load();

    $renderer = new TemplateRenderer();
    $toDoDTO = new ToDoDTO();
    $toasts = [];

    try {

      $id = isset($_GET["id"]) ? $_GET["id"] : null;

      if($id === null) {
        throw new Exception();
      }

      if($id !== null) {
        $todoDAO = new ToDoDAO();
        $toDoDTO->setId($id);
        $toDoDTO = $todoDAO->getItem($toDoDTO);
        $todoDAO->deleteItem($toDoDTO);
        $toasts[]  = new ToastDTO("success", "Item removed successfully");
      }


    } catch (Exception $e) {
      echo $e->getMessage();
      $toasts[]  = new ToastDTO("error", "Error on remove item");
    }

    echo $renderer->render("delete.twig", ["toasts" => $toasts]);

?>
