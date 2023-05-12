<?php
class ToDoDTO
{
    private $id;
    private $title;
    private $description;

    public function __construct(string $id = null, string $title = null, string $description = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        return $this->id = $id;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        return $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        return $this->description = $description;
    }
}
