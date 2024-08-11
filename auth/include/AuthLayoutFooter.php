  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->

  <script src="../dashboard/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../dashboard/assets/vendor/libs/popper/popper.js"></script>
  <script src="../dashboard/assets/vendor/js/bootstrap.js"></script>
  <script src="../dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../dashboard/assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="../dashboard/assets/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag before closing body tag for github widget button. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });
  </script>
  </body>

  </html>