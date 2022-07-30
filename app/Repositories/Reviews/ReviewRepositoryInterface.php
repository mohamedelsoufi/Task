<?php

namespace App\Repositories\Reviews;

interface ReviewRepositoryInterface
{
    public function getAllReviews();

    public function getReviewById($request);

    public function createReview($request);

    public function addAssignment($request);

    public function editReview($request);

    public function addFeedback($request);
}
