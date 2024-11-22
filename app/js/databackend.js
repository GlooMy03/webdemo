document.addEventListener('DOMContentLoaded', function () {
    const bookingsTable = document.getElementById('bookingsTable'); // Tabel untuk menampilkan data booking
    const loadingElement = document.getElementById('loading'); // Elemen untuk indikator loading
    const errorElement = document.getElementById('error'); // Elemen untuk pesan error

    // Fungsi untuk menampilkan indikator loading
    function showLoading() {
        loadingElement.style.display = 'block';
        errorElement.style.display = 'none';
        bookingsTable.style.display = 'none';
    }

    // Fungsi untuk menyembunyikan indikator loading
    function hideLoading() {
        loadingElement.style.display = 'none';
        bookingsTable.style.display = 'table';
    }

    // Fungsi untuk menampilkan pesan error
    function showError(message) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        bookingsTable.style.display = 'none';
        loadingElement.style.display = 'none';
    }

});
