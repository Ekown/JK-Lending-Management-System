
{{-- <!-- Popper 1.11 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script> --}}

<!-- Twitter Bootstrap 4 Beta Script -->
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script> --}}

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('plugins/popper/popper.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- JQuery Backstretch 2.0.4 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js" integrity="sha256-V52dl3OFjoY+fYAkifhLJ7f1V7mZAKPGCQoWzoQxrEU=" crossorigin="anonymous"></script>

<!-- DataTables 1.10.16 Script -->
<script src="{{ asset('plugins/datatables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- DataTables Button 1.4.2 Script -->
{{-- <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script> --}}
<script src="{{ asset('plugins/datatables/Buttons-1.4.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/Buttons-1.4.2/js/buttons.bootstrap4.min.js') }}"></script>

<!-- Sum() DataTable Plugin -->
{{-- <script src="https://cdn.datatables.net/plug-ins/1.10.16/api/sum().js"></script> --}}
<script src="{{ asset('plugins/datatables/Sum/sum.js') }}"></script>

<!-- Bootstrap DatePicker 1.7.1 Script -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js" integrity="sha256-TueWqYu0G+lYIimeIcMI8x1m14QH/DQVt4s9m/uuhPw=" crossorigin="anonymous"></script> --}}
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>


<!-- Selectize jQuery Select Boxes Replacement Script -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js" integrity="sha256-HyBiZFJAMvxOhZoWOc5LWIWaN1gcFi8LjS75BZF4afg=" crossorigin="anonymous"></script> --}}
<script src="{{ asset('plugins/selectize/js/selectize.min.js') }}"></script>

<!--Wave Effects -->
<script src="{{ asset('plugins/waves/dist/waves.min.js') }}"></script>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

<!-- App scripts -->
@stack('scripts')



