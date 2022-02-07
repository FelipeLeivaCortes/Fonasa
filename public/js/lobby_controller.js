
/**
 * Controlling events once the page has patients
 */
setTimeout(()=>{
    $(document).ready(function(){
        $('#hospital_id').change(function(){
            $('#btn_search').removeAttr('disabled');
        });
    });

    $('#btn_oldest').click(function(){
        if ( $(this).hasClass('btn-primary') ){
            var ages    = [];
            var ids     = [];

            $('tbody tr').each(function(){
                ids.push($(this).attr('id'));
                ages.push( $(this).find('td').eq(2).html() );
            });

            for ( i=0; i<ages.length; i++ ) {
                if ( ages[i] != Math.max.apply(null, ages) ) {
                    $( eval('"#' + ids[i] + '"') ).addClass('d-none');
                    $( eval('"#' + ids[i] + '"') ).removeClass('waiting');
                }
            }

            $(this).addClass('btn-success');
            $(this).removeClass('btn-primary');
            $(this).text('- El paciente mayor');

        } else {
            $('tbody tr').each(function(){
                $(this).removeClass('d-none');
                $(this).addClass('waiting');
            });

            $(this).addClass('btn-primary');
            $(this).removeClass('btn-success');
            $(this).text('El paciente mayor');
        }
    });

}, 300);

function attend_patient(hospital_id){
    let row     = $('tbody').children('.waiting').eq(0).children();
    let data    = { patient_id:     row.eq(0).html(),
                    hospital_id:    hospital_id};

    $.ajax({
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type:       "POST",
        url:        "./lobby/get_records",
        data:       data,
        cache:      false,

    }).fail(function(error){
        console.log(error);

    }).done(function(response){
        if ( response.records.length == 0 ) {
            Swal.fire({
                icon: 'info',
                title: 'Sin consultas ' + response.type + ' disponibles ',
                text: 'Se ha derivado el paciente a la sala de pendientes',
            
            }).then(()=>{
                $( eval('"#row_' + row.eq(0).html() + '"') ).remove();

            });

        } else {
            $('#patient_id').val(           row.eq(0).html() );
            $('#patient_name').html(        row.eq(1).html() );
            $('#patient_age').html(         row.eq(2).html() );
            $('#patient_category').html(    row.eq(3).html() );
            $('#patient_priority').html(    row.eq(4).html() );
            $('#patient_risk').html(        row.eq(5).html() );

            $('#record_id').empty();

            response.records.forEach(element => {
                let option  = $('<option></option>', {
                    value:  element.id,
                    text:   element.professional,
                });

                $('#record_id').append(option);
            });

            $('#attendPatientModal').modal({
                backdrop:   'static',
                keyboard:   false,
            });
        }
    });
}

function attend_pending_patients(hospital_id){
    let row     = $('tbody').children('.waiting').eq(0).children();
    let data    = { patient_id:     row.eq(0).html(),
                    hospital_id:    hospital_id};

    $.ajax({
        headers:    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type:       "POST",
        url:        "./awaiting_room/get_records",
        data:       data,
        cache:      false,

    }).fail(function(error){
        console.log(error);

    }).done(function(response){
        if ( response.records.length == 0 ) {
            Swal.fire({
                icon: 'info',
                title: 'Sin consultas ' + response.type + ' disponibles ',
                text: 'Aún no hay consultas disponibles para atender al paciente',
            
            }).then(()=>{
                $( eval('"#row_' + row.eq(0).html() + '"') ).remove();

            });

        } else {
            $('#patient_id').val(           row.eq(0).html() );
            $('#patient_name').html(        row.eq(1).html() );
            $('#patient_age').html(         row.eq(2).html() );
            $('#patient_category').html(    row.eq(3).html() );
            $('#patient_priority').html(    row.eq(4).html() );
            $('#patient_risk').html(        row.eq(5).html() );

            $('#record_id').empty();



            $.each( response.records, function(element){
                console.log(element);
                let option  = $('<option></option>', {
                    value:  element.id,
                    text:   element.professional,
                });

                $('#record_id').append(option);
            });              

            $('#attendPatientModal').modal({
                backdrop:   'static',
                keyboard:   false,
            });
        }
    });
}