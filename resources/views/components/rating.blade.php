
@for ($i = 1; $i <= 5; $i++)
    @if ($i <= $fullStars)
        <i class="fas fa-star text-yellow-400" ></i>
    @elseif ($i == $fullStars + 1 && $halfStar)
        <i class="fas fa-star-half-alt text-yellow-400"></i>
    @else
        <i class="far fa-star text-yellow-400"></i> 
    @endif
@endfor

