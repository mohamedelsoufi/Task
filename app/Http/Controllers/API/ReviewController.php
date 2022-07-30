<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AddAssignRequest;
use App\Http\Requests\API\FeedbackRequest;
use App\Http\Requests\API\ShowReviewRequest;
use App\Http\Requests\API\StoreReviewRequest;
use App\Http\Requests\API\UpdateReviewRequest;
use App\Repositories\Reviews\ReviewRepositoryInterface;

class ReviewController extends Controller
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    //get all reviews
    public function index(){
        return $this->reviewRepository->getAllReviews();
    }

    //show reviews
    public function show(ShowReviewRequest $request){
        return $this->reviewRepository->getReviewById($request);
    }

    //store review
    public function store(StoreReviewRequest $request){
        return $this->reviewRepository->createReview($request);
    }

    //add assign to use
    public function addAssign(AddAssignRequest $request){
        return $this->reviewRepository->addAssignment($request);
    }

    // update review
    public function update(UpdateReviewRequest $request){
        return $this->reviewRepository->editReview($request);
    }

    // add feedback
    public function feedback(FeedbackRequest $request){
        return $this->reviewRepository->addFeedback($request);
    }
}
