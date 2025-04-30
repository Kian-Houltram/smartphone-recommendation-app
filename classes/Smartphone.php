<?php

//Represents a smartphone on the site.
class Smartphone {
    private $id;
    private $model;
    private $manufacturer;
    private $screenSize;
    private $dimensions;
    private $weight;
    private $releaseDate;
    private $os;
    private $score;
    private $description;
    private $image;

    // Smartphone constructor.
    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->model = $data['Model'];
        $this->manufacturer = $data['Manufacturer'];
        $this->screenSize = $data['Screen_Size'];
        $this->dimensions = $data['Dimensions'];
        $this->weight = $data['Weight'];
        $this->releaseDate = $data['Release_Date'];
        $this->os = $data['OS'];
        $this->score = $data['Score'];
        $this->description = $data['Description'];
        $this->image = $data['Image'];

    }

    // Getter methods for private properties. 
    public function getID() {return $this ->id; }
    public function getModel() { return $this->model; }
    public function getManufacturer() { return $this->manufacturer; }
    public function getScreenSize() { return $this->screenSize; }
    public function getDimensions() { return $this->dimensions; }
    public function getWeight() { return $this->weight; }
    public function getReleaseDate() { return $this->releaseDate; }
    public function getOS() { return $this->os; }
    public function getScore() { return $this->score; }
    public function getDescription() { return $this->description; }
    public function getImage() { return $this->image; }

    // Returns a display title with the model and manufacturer of the smartphone.
    public function getDisplayTitle() {
        return "{$this->model} ({$this->manufacturer})";
    }

}