function showMessage(type, message, clear){
    switch(type) {
        case 'success':
            var alertClass = "alert alert-success alert-dismissible";
            break;
        case 'error':
            var alertClass = "alert alert-danger alert-dismissible";
            break;
        default:
            var alertClass = "alert alert-info alert-dismissible";
    }

    alertMessage = '<div class="' + alertClass + '" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + message + '</div>';
    if(clear){
        jQuery('#alert').empty();
    }
    jQuery('#alert').append(alertMessage);
    jQuery('#alert').show();
    jQuery("#alert").fadeTo(5000, 500).slideUp(1000, function(){
        jQuery("#alert").alert('close');
    });
}



