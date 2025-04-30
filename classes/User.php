<?php

// Represents a user of the site.
class User {
    private $username;
    private $firstName;
    private $surname;
    private $email;
    private $password;
    private $favourite;

    /**
     * Constructor method that sets user properties.
     * Used for loading users from JSON file.
     */
    public function __construct($data) {
        $this->username = $data['username'];
        $this->firstName = $data['firstName'];
        $this->surname = $data['surname'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->favourite = $data['favourite'] ?? null; // Handles cases where favourite is not set. 
    }

    // Getters to access private propeties.
    public function getUsername() {
        return $this->username;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFavourite() {
        return $this->favourite;
    }

    // Allows a user to update their favourite smartphone.
    public function setFavourite($favourite) {
        $this->favourite = $favourite;
    }

    /**
     * Converts object into an array.
     * Useful for saving data back to the JSON file.
     */
    public function toArray() {
        return [
            'username' => $this->username,
            'firstName' => $this->firstName,
            'surname' => $this->surname,
            'email' => $this->email,
            'password' => $this->password,
            'favourite' => $this->favourite
        ];
    }
}
