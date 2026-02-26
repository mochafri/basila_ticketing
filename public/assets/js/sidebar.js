const toggleButton = document.querySelector(".sidebar-toggle");
const sidebar = document.querySelector(".sidebar");

let isSidebarCollapsed = false;

toggleButton.addEventListener("click", () => {
  isSidebarCollapsed = !isSidebarCollapsed;

  if (isSidebarCollapsed) {
    sidebar.classList.add("collapsed");
  } else {
    sidebar.classList.remove("collapsed");
  }
});

// Hover expand sementara
sidebar.addEventListener("mouseenter", () => {
  if (isSidebarCollapsed) {
    sidebar.classList.remove("collapsed");
  }
});

sidebar.addEventListener("mouseleave", () => {
  if (isSidebarCollapsed) {
    sidebar.classList.add("collapsed");
  }
});

// Active untuk parent menu
document.querySelectorAll(".menu-item").forEach((item) => {
  item.addEventListener("click", function () {
    // Hapus active dari semua parent
    document.querySelectorAll(".menu-item").forEach((el) => {
      el.classList.remove("active");
    });

    this.classList.add("active");
  });
});

// Active untuk submenu
document.querySelectorAll(".submenu-item").forEach((item) => {
  item.addEventListener("click", function (e) {
    e.stopPropagation(); // supaya parent tidak ikut ke-reset

    // Hapus active dari semua submenu
    document.querySelectorAll(".submenu-item").forEach((el) => {
      el.classList.remove("active");
    });

    // Hapus active parent lain
    document.querySelectorAll(".menu-item").forEach((el) => {
      el.classList.remove("active");
    });

    // Tambahkan active
    this.classList.add("active");

    // Aktifkan parent juga
    const parentMenu = this.closest("li")
      .closest("li")
      .querySelector(".menu-item");
    if (parentMenu) {
      parentMenu.classList.add("active");
    }
  });
});
