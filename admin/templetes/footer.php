<!-- Footer -->
      <footer class="footer-responsive sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span class="copyright">
                Copyright ©
                <script>
                  document.write(new Date().getFullYear())
                </script> Andhika Prastya
              </span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header modal-bg">
          <h5 class="modal-title modal-text" id="exampleModalLabel">Logout</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Apakah anda yakin ingin keluar?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="../logout.php">Ok</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../assets/js/demo/datatables-demo.js"></script>

  <script>
    $(function(){
      $("dataTable").DataTable({
        "paging":true,
        "lengthChange":false,
        "searching": false,
        "ordering":true,
        "info":true,
        "autoWidth":false,
      });
   })
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
            $.ajax({
                type: 'POST',
                url: "get_kecamatan.php",
                cache: false, 
                success: function(msg){
                  $("#kecamatan").html(msg);
                }
            });

            $("#kecamatan").change(function(){
            var kecamatan = $("#kecamatan").val();
              $.ajax({
                type: 'POST',
                  url: "get_desa.php",
                  data: {kecamatan: kecamatan},
                  cache: false,
                  success: function(msg){
                    $("#desa").html(msg);
                  }
              });
            });
         });
  </script>


</body>

</html>