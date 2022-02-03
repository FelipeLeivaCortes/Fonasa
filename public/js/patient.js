setTimeout(()=>{
    $(document).ready(function(){
        $('#age').change(function(){

            if( $(this).val() < 1 ){
                Swal.fire({
                    icon:   'error',
                    title:  'Error',
                    html:   'La edad ingresada es incorrecta',
                })
            
                $(this).val('');

            //Child Category
            } else if ( $(this).val() >= 1 && $(this).val() <= 15 ) {
                $('#child_container').removeClass('d-none');

                $('#adult_container').addClass('d-none');
                $('#oldman_container').addClass('d-none');

            // Adult Category
            } else if ( $(this).val() >= 16 && $(this).val() <= 40 ) {
                $('#adult_container').removeClass('d-none');
                
                $('#child_container').addClass('d-none');
                $('#oldman_container').addClass('d-none');

                $('#is_smoker').unbind();   //Removing all previous events

                $('#is_smoker').change(function(){
                    if ($('#is_smoker').val() == '1') {
                        $('#time_container').removeClass('d-none');
                    }else{
                        $('#time_container').addClass('d-none');
                    }
                });

            // Oldman Category
            } else if ( $(this).val() >= 41 )  {
                $('#oldman_container').removeClass('d-none');
                
                $('#child_container').addClass('d-none');
                $('#adult_container').addClass('d-none');

            }
        });

        $('#time').change(function(){
            if( $(this).val() < 1 ){
                Swal.fire({
                    icon:   'error',
                    title:  'Error',
                    html:   'Los años que lleva fumando son incorrectos',
                })
            
                $(this).val('');
            }
        });

    });
}, 300);