<?php

namespace App\Observers\Business;

use App\Models\Business\BusinessReview;

class BusinessReviewObserver
{
    /**
     * Handle the BusinessReview "created" event.
     */
    public function created(BusinessReview $businessReview): void
    {
        $this->updateBusinessRating($businessReview);
    }

    /**
     * Handle the BusinessReview "updated" event.
     */
    public function updated(BusinessReview $businessReview): void
    {
        $this->updateBusinessRating($businessReview);
    }

    /**
     * Handle the BusinessReview "deleted" event.
     */
    public function deleted(BusinessReview $businessReview): void
    {
        $this->updateBusinessRating($businessReview);
    }

    /**
     * Update the business rating when review changes
     */
    private function updateBusinessRating(BusinessReview $businessReview): void
    {
        if ($businessReview->business) {
            $businessReview->business->updateRating();
        }
    }
}
