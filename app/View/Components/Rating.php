<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rating extends Component
{
    public float $score;
    public int $fullStars = 0;
    public bool $halfStar = false;

    public function __construct(float $score)
    {
        $this->score = $score;
        $this->calculateStars();
    }

    private function calculateStars(): void
    {
        $rating = $this->score;

        if ($rating < 0.3) {
            $this->fullStars = 0;
            $this->halfStar = false;
        } elseif ($rating < 0.8) {
            $this->fullStars = 0;
            $this->halfStar = true;
        } elseif ($rating < 1.3) {
            $this->fullStars = 1;
            $this->halfStar = false;
        } elseif ($rating < 1.6) {
            $this->fullStars = 1;
            $this->halfStar = true;
        } elseif ($rating < 2.1) {
            $this->fullStars = 2;
            $this->halfStar = false;
        } elseif ($rating < 2.6) {
            $this->fullStars = 2;
            $this->halfStar = true;
        } elseif ($rating < 3.1) {
            $this->fullStars = 3;
            $this->halfStar = false;
        } elseif ($rating < 3.6) {
            $this->fullStars = 3;
            $this->halfStar = true;
        } elseif ($rating < 4.1) {
            $this->fullStars = 4;
            $this->halfStar = false;
        } elseif ($rating < 4.6) {
            $this->fullStars = 4;
            $this->halfStar = true;
        } else {
            $this->fullStars = 5;
            $this->halfStar = false;
        }
    }

    public function render()
    {
        return view('components.rating');
    }
}
