/**
 * Created by peteryan on 2018/1/5.
 */
$(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#batchName").on("blur", function () {
        var id = $(this).data('id');
        var name = $(this).val();
        var inputDom = $(this);
        if (name == '') {
            $(".errorDiv").html('');
            $(inputDom).parent().removeClass('has-success');
            $(inputDom).parent().addClass('has-error');
            $(inputDom).next().removeClass('glyphicon-ok');
            $(inputDom).next().addClass('glyphicon-remove');
            $(inputDom).focus();
            return;
        }
        $.ajax({
            url: '/batch/validate',
            type: 'post',
            data: {
                'id':id,
                'name':name,
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
    $("#batchCrontime").on("blur", function () {
        var cronTime = $(this).val();
        $(".errorDiv").html('');
        var inputDom = $(this);
        if (cronTime == '') {
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
});