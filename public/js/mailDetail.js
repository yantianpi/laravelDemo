/**
 * Created by peteryan on 2018/1/5.
 */
$(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#mailName").on("blur", function () {
        var name = $(this).val();
        var inputDom = $(this);
        $(".errorDiv").html('');
        if (name == '') {
            $(inputDom).parent().removeClass('has-success');
            $(inputDom).parent().addClass('has-error');
            $(inputDom).next().removeClass('glyphicon-ok');
            $(inputDom).next().addClass('glyphicon-remove');
            $(inputDom).focus();
        } else {
            $(inputDom).parent().removeClass('has-error');
            $(inputDom).parent().addClass('has-success');
            $(inputDom).next().removeClass('glyphicon-remove');
            $(inputDom).next().addClass('glyphicon-ok');
        }
    });
    $("#mailMail").on("blur", function () {
        var id = $(this).data('id');
        var mail = $(this).val();
        var inputDom = $(this);
        if (mail == '') {
            $(".errorDiv").html('');
            $(inputDom).parent().removeClass('has-success');
            $(inputDom).parent().addClass('has-error');
            $(inputDom).next().removeClass('glyphicon-ok');
            $(inputDom).next().addClass('glyphicon-remove');
            $(inputDom).focus();
            return;
        }
        $.ajax({
            url: '/mail/validate',
            type: 'post',
            data: {
                'id':id,
                'mail':mail,
                '_token':CSRF_TOKEN
            },
            dataType: 'json',
            success: function (data) {
                if (data.flag != true) {
                    $(".errorDiv").html(data.message);
                    $(inputDom).parent().removeClass('has-success');
                    $(inputDom).parent().addClass('has-error');
                    $(inputDom).next().removeClass('glyphicon-ok');
                    $(inputDom).next().addClass('glyphicon-remove');
                    $(inputDom).focus();
                } else {
                    $(".errorDiv").html('');
                    $(inputDom).parent().removeClass('has-error');
                    $(inputDom).parent().addClass('has-success');
                    $(inputDom).next().removeClass('glyphicon-remove');
                    $(inputDom).next().addClass('glyphicon-ok');
                }
            },
            error: function (data) {
                $(inputDom).parent().removeClass('has-success has-error');
                $(inputDom).next().removeClass('glyphicon-remove glyphicon-ok');
                console.log('error');
                console.log(data);
            }
        });
    });
});