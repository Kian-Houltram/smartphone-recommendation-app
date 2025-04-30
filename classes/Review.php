<?php

//Represents a review of a smartphone on the site.
class Review {
    private $username;
    private $rating;
    private $comment;
    private $phoneId;

    // Review constructor. 
    public function __construct(array $data) {
        $this->username = $data['username'] ?? '';
        $this->rating = $data['rating'] ?? 0;
        $this->comment = $data['comment'] ?? '';
        $this->phoneId = $data['phone_id'] ?? '';
    }

    // Getter methods for private properties.
    public function getUsername() {
        return $this->username;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getPhoneId() {
        return $this->phoneId;
    }

    // Converts the review object to an array for saving to JSON file.
    public function toArray() {
        return [
            'username' => $this->username,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'phone_id' => $this->phoneId,
        ];
    }
}
