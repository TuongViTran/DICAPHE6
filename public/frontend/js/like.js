document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', function() {
        const shopId = this.getAttribute('data-id');
        const heartIcon = this;

        fetch(`/like-shop/${shopId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                heartIcon.innerText = data.liked ? '❤️' : '♡';
                heartIcon.style.color = data.liked ? '#FF4D4D' : '#e4e5e9';
                document.getElementById(`like-count-${shopId}`).innerText = data.likes;
            });
    });
});