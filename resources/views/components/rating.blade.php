
@for ($i = 1; $i <= 5; $i++)
    @if ($i <= $fullStars)
        <i class="fas fa-star text-yellow-500"></i>
    @elseif ($i == $fullStars + 1 && $halfStar)
        <i class="fas fa-star-half-alt text-yellow-500"></i>
    @else
        <i class="far fa-star text-gray-300"></i>
    @endif
@endfor

