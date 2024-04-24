<?php
declare(strict_types=1);

class Review
{
    public int $reviewId;
    public int $buyerId;
    public int $sellerId;
    public int $rating;
    public string $review;
    public DateTime $timestamp;


    public function __construct(int $reviewId, int $buyerId, int $sellerId, int $rating, string $review, DateTime $timestamp)
    {
        $this->reviewId = $reviewId;
        $this->buyerId = $buyerId;
        $this->sellerId = $sellerId;
        $this->rating = $rating;
        $this->review = $review;
        $this->timestamp = $timestamp;
    }
}

?>