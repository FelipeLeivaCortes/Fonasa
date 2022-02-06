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
                }
            }

            $(this).addClass('btn-success');
            $(this).removeClass('btn-primary');
            $(this).text('- Mayor Edad');

        } else {
            $('tbody tr').each(function(){
                $(this).removeClass('d-none');
            });

            $(this).addClass('btn-primary');
            $(this).removeClass('btn-success');
            $(this).text('Paciente más viejo');
        }
    });
}, 300);
