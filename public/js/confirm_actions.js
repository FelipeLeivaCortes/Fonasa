$('.delete_hospital').submit(function(e)
{
    e.preventDefault();
    Swal.fire({
        title: '¿Estas seguro que desea eliminar este hospital?',
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

$('.delete_patient').submit(function(e)
{
    e.preventDefault();
    Swal.fire({
        title: '¿Estas seguro que desea eliminar este paciente?',
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

$('.delete_record').submit(function(e)
{
    e.preventDefault();
    Swal.fire({
        title: '¿Estas seguro que desea eliminar la consulta?',
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