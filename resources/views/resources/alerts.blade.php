<div>
    @if ( session('success') )
        @section('js')
            <script>
                Swal.fire({
                    icon:   'success',
                    title:  'Operación Exitosa',
                    text:   "<?=session('success')?>",
                })
            </script>
        @endsection
    @endif

    @if (session('warning'))
        @section('js')
            <script>
                Swal.fire({
                    icon:   'warning',
                    title:  'Advertencia',
                    text:   "<?=session('warning')?>",
                })
            </script>
        @endsection
    @endif

    @if (session('info'))
        @section('js')
            <script>
                Swal.fire({
                    icon:   'info',
                    title:  'Notificación',
                    text:   "<?=session('info')?>",
                })
            </script>
        @endsection
    @endif

    @if (session('error'))
        @section('js')
            <script>
                Swal.fire({
                    icon:   'error',
                    title:  'Error',
                    text:   "<?=session('error')?>",
                })
            </script>
        @endsection
    @endif

    @if ($errors->any())
        @php
            $error_list = "";

            foreach( $errors->all() as $error ){
                $error_list  = $error_list . $error .'<br>';
            }

        @endphp

        @section('js')
            <script>
                Swal.fire({
                    icon:   'error',
                    title:  'Error',
                    html:'<?=$error_list?>',
                })
            </script>
        @endsection
    @endif
</div>