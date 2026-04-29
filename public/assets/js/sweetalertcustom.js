const btnKategori = document.querySelector(".btn-kategori");
const btnLayanan = document.querySelector(".btn-layanan");
const btnDeletes = document.querySelectorAll(".btn-delete");
const inputKategori = document.querySelector("#inputKategori");
const inputLayanan = document.querySelector("#inputLayanan");
const selectKategori = document.querySelector(".select-kategori");

// =====================
// HAPUS KATEGORI
// =====================
btnDeletes.forEach((btn) => {
  btn.addEventListener("click", function () {
    const id = this.getAttribute("data-id"); // ambil id dari data-id

    Swal.fire({
      title: "Apakah Anda yakin ingin menghapus kategori ini?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        // Panggil method deleteKategori via fetch
        fetch(`${BASE_URL}master-data/delete-kategori/${id}`, {
          method: "DELETE",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
            // Jika headerName = 'X-CSRF-TOKEN'
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="X-CSRF-TOKEN"]')
              .getAttribute("content"),
          },
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Kategori berhasil dihapus!",
                timer: 1500,
                showConfirmButton: false,
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: data.message || "Kategori gagal dihapus!",
              });
            }
          })
          .catch(() => {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: "Terjadi kesalahan, coba lagi!",
            });
          });
      }
    });
  });
});
// =====================
// HAPUS LAYANAN
// =====================
document.querySelectorAll(".btn-delete-layanan").forEach((btn) => {
  btn.addEventListener("click", function () {
    const id = this.getAttribute("data-id");

    Swal.fire({
      title: "Apakah Anda yakin ingin menghapus layanan ini?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`${BASE_URL}master-data/delete-layanan/${id}`, {
          method: "DELETE",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="X-CSRF-TOKEN"]')
              .getAttribute("content"),
          },
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Layanan berhasil dihapus!",
                timer: 1500,
                showConfirmButton: false,
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: data.message || "Layanan gagal dihapus!",
              });
            }
          })
          .catch(() => {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: "Terjadi kesalahan, coba lagi!",
            });
          });
      }
    });
  });
});
