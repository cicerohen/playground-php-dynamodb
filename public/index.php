<?php

    require_once "../vendor/autoload.php";
    require_once "../app/TemplateRenderer.php";
    require_once "../app/ToDoDAO.php";
    require_once "../app/LoadEnv.php";

    LoadEnv::load();

    $renderer = new TemplateRenderer();
    $todos = [];

    try {
      $todoDAO = new ToDoDAO();
      $todos = $todoDAO->getItems();

    } catch (Exception $e) {
        // echo $e->getMessage();
    }

    echo $renderer->render("index.twig", ["todos" => $todos]);

?>
