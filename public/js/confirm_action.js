setTimeout(()=>{
    $(document).ready(function(){
        $('.confirm_action').submit(function(e)
        {
            e.preventDefault();
            Swal.fire({
                title: '¿Estas seguro que desea eliminar?',
                text: "Esta acción es irreversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    });
}, 300);