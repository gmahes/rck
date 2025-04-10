const dppInput = document.getElementById("dpp");
const omzetInput = document.getElementById("omzet");
const editDpp = document.getElementsByName("dpp");
if (editDpp) {
    editDpp.forEach(function (input) {
        input.addEventListener("input", function () {
            // Hapus semua karakter non-angka
            let value = this.value.replace(/\D/g, "");
            // Format angka dengan titik ribuan
            this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    });
}
if (dppInput) {
    dppInput.addEventListener("input", function () {
        // Hapus semua karakter non-angka
        let value = this.value.replace(/\D/g, "");
        // Format angka dengan titik ribuan
        this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}
if (omzetInput) {
    omzetInput.addEventListener("input", function () {
        // Hapus semua karakter selain angka dan semicolon
        let value = this.value.replace(/[^0-9;]/g, "");
        // Format angka dengan titik ribuan
        this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}
