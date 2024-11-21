// JavaScript untuk menangani klik pada tombol submit
document.getElementById('submit-btn').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah form untuk disubmit secara otomatis
    alert('Payment Successful!');
});
