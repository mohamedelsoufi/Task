<?php


namespace App\Repositories\Reviews;


use App\Http\Resources\Reviews\GetReviewsResource;
use App\Models\Review;

class ReviewRepository implements ReviewRepositoryInterface
{
    // get all reviews start
    public function getAllReviews()
    {
        try {
            $reviews = Review::latest()->paginate(PAGINATION_COUNT);
            return successResponse(GetReviewsResource::collection($reviews)->response()->getData(true));
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }//end of get all reviews start

    // show review by id
    public function getReviewById($request)
    {
        try {
            $review = Review::find($request->id);
            return successResponse(new GetReviewsResource($review));
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }//end of show review by id

    // create review (only admin can do it)
    public function createReview($request)
    {
        try {
            $auth_user = getAuthAPIUser();
            if ($auth_user->is_admin == 0)
                return failureResponse("You don't have Admin access to create review");

            $requested_data = $request->except('assign_to');
            $review = $auth_user->reviews()->create($requested_data);
            if ($request->has('assign_to')) {
                foreach ($request->assign_to as $assign) {
                    $review->assignments()->attach([
                        'user_id' => $assign
                    ]);
                }
            }
            return successResponse('Review Created Successfully');
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }//end of create review for admin only

    // add assignment to review (only admin can do it)
    public function addAssignment($request)
    {
        try {
            $auth_user = getAuthAPIUser();
            if ($auth_user->is_admin == 0)
                return failureResponse("You don't have Admin access to assign any user");

            $review = Review::find($request->id);

            foreach ($request->assign_to as $assign) {
                $assignment = $review->assignments()->where('user_id', $assign)->first();
                if ($assignment)
                    return failureResponse('You have added assign to this user id:' . $assign . ' before');
                $review->assignments()->attach([
                    'user_id' => $assign
                ]);
                return successResponse('You have add assigns to this review successfully');
            }

        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }//add assignment to review

    // edit review (only admin can do it)
    public function editReview($request)
    {
        try {
            $auth_user = getAuthAPIUser();
            if ($auth_user->is_admin == 0)
                return failureResponse("You don't have Admin access to edit review");

            $review = Review::find($request->id);
            $requested_data = $request->except('assign_to', 'delete_assign_to');

            // add assign to review
            $review->assignments()->sync($request->assign_to);

            $review->update($requested_data);
            return successResponse('Review Updated Successfully');
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }//end of edit review

    // user add feedback to review
    public function addFeedback($request)
    {
        try {
            $user = getAuthAPIUser();
            $review = Review::find($request->review_id);

            // check if user has feedback
            $feedback =  $review->feedback()->first();
            if (isset($feedback))
                return failureResponse('You have entered a feedback beck, so you can not add another feedback');

            $request['user_id'] = $user->id;
            $review->feedback()->create($request->all());
            return successResponse('Feedback Added Successfully');
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }//end of user add feedback to review

}
