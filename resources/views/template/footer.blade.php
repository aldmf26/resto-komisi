<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="https://ptagafood.com"
            class="text-white">www.ptagafood.com</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap4-toggle.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="{{ asset('assets') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>
<script src="{{ asset('assets') }}/plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets') }}/dist/js/demo.js"></script>
<script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap-switch-button.min.js">
</script>

<script>
    function doubleClicked(element) {
        if (element.data('alreadyClicked')) {
            return true;
        } else {
            element.data('alreadyClicked', true);
            setTimeout(function() {
                element.removeData('alreadyClicked');
            }, 500); // (Prevent user from clicking the button more than once within 500ms (0.5s))
            return false;
        }
    }

    $(document).ready(function() {
        $('.first-button').on('click', function(e) {
            if (doubleClicked($(this))) {
                e.preventDefault(); // Prevent Default Action
                e.stopPropagation(); // Stop Navbar from opening/closing
                return;
            } else {
                $('.animated-icon1').toggleClass('open');
            }
        });
    });

    $(function() {
        $("#example1").DataTable({

            "lengthChange": false,
            "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#table').DataTable({

            "bSort": true,
            // "scrollX": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true
        });
        $('#table10').DataTable({

            "bSort": true,
            // "scrollX": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true
        });
        
        $('#tableLvl').DataTable({

            "bSort": false,
            // "scrollX": true,
            "paging": false,
            "stateSave": false,
            "scrollCollapse": false
        });

        $('#tabelAbsen').DataTable({

            "bSort": true,
            "scrollY": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true
        });

        $('#table2').DataTable({

            "bSort": true,
            // "scrollX": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true
        });
        $('#table3').DataTable({

            "bSort": true,
            // "scrollX": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true
        });

        $('#cek').DataTable({
            "paging": false,
            "pageLength": 100,
            "scrollY": "300px",
            "lengthChange": false,
            "ordering": false,
            "info": false,
            "stateSave": true,
            "autoWidth": true
        });

        $('#cek_kembali').DataTable({
            "paging": false,
            "pageLength": 100,
            "scrollY": "300px",
            "lengthChange": false,
            "ordering": false,
            "info": false,
            "stateSave": true,
            "autoWidth": true
        });

        $('#tabelMajoo').DataTable({

        "bSort": true,
        "scrollY": true,
        "paging": true,
        "stateSave": true,
        "scrollCollapse": true
        });

    });
</script>

<script>
    $(function() {
        $('.select').select2()
        $('.select').one('select2:open', function(e) {
            $('input.select2-search__field').prop('placeholder', 'Search...');
        });
    })
</script>
<script type="text/javascript" src="{{ asset('assets') }}/dropify/dist/js/dropify.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Drag',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    });
</script>
@yield('script')
</body>

</html>
