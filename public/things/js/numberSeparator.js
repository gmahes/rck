const dppInput = document.getElementById("dpp");
dppInput.addEventListener("input", function () {
    // Hapus semua karakter non-angka
    let value = this.value.replace(/\D/g, "");
    // Format angka dengan titik ribuan
    this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});
