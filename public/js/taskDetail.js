/**
 * Created by peteryan on 2018/1/2.
 */
$(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#taskName").on("blur", function () {
        var name = $(this).val();
        var inputDom = $(this);
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
    $("#taskCronTime").on("blur", function () {
        var name = $(this).val();
        var inputDom = $(this);
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

    var batch = $("#Batch").val();
    if (batch == 0) {
        $("#taskCronTime").val('');
        $("#taskCronTime").removeAttr('readonly');
    } else {
        $.ajax({
            url: '/batch/ajax/' + batch,
            type: 'post',
            data: {
                '_token':CSRF_TOKEN
            },
            dataType: 'json',
            success: function (data) {
                if (data.flag != true) {
                    $("#taskCronTime").val('');
                } else {
                    $("#taskCronTime").val(data.Crontime);
                    $("#taskCronTime").attr('readonly', 'readonly');
                }
            },
            error: function (data) {
                $("#taskCronTime").val('');
            }
        });
    }
    $("#Batch").on("change", function () {
        var inputDom = $(this);
        var batch = $(this).val();
        $("#taskCronTime").parent().removeClass('has-success has-error');
        $("#taskCronTime").next().removeClass('glyphicon-ok glyphicon-remove');
        if (batch == 0) {
            $("#taskCronTime").val('');
            $("#taskCronTime").removeAttr('readonly');
            $("#taskCronTime").focus();
        } else {
            $.ajax({
                url: '/batch/ajax/' + batch,
                type: 'post',
                data: {
                    '_token':CSRF_TOKEN
                },
                dataType: 'json',
                success: function (data) {
                    if (data.flag != true) {
                        $("#taskCronTime").val('');
                    } else {
                        $("#taskCronTime").val(data.Crontime);
                        $("#taskCronTime").attr('readonly', 'readonly');
                    }
                },
                error: function (data) {
                    $("#taskCronTime").val('');
                }
            });
        }
    });

    $("#taskAlertLimit").on("blur", function () {
        var tmp = $(this).val();
        var inputDom = $(this);
        if (tmp <= 0) {
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

    var notifyType = $("#taskNotifyType").val();
    switch (notifyType) {
        case "MAIL":
            var id = $('input[name="id"]').val();
            $.ajax({
                url: '/task/mail/' + id,
                type: 'post',
                data: {
                    '_token':CSRF_TOKEN
                },
                dataType: 'html',
                success: function (data) {
                    $(".tastNotifyContent").html(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
            break;
        case "OTHER":
        default:
            $(".tastNotifyContent").html('');
    }
    $("#taskNotifyType").on("change", function () {
        var notifyType = $(this).val();
        switch (notifyType) {
            case "MAIL":
                var id = $('input[name="id"]').val();
                $.ajax({
                    url: '/task/mail/' + id,
                    type: 'post',
                    data: {
                        '_token':CSRF_TOKEN
                    },
                    dataType: 'html',
                    success: function (data) {
                        $(".tastNotifyContent").html(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                break;
            case "OTHER":
            default:
                $(".tastNotifyContent").html('');
        }
    });

    var category = $("#taskCategory").val();
    var id = $('input[name="id"]').val();
    $.ajax({
        url: '/task/content/' + id,
        type: 'post',
        data: {
            'categoryId':category,
            '_token':CSRF_TOKEN
        },
        dataType: 'html',
        success: function (data) {
            $(".tastContent").html(data);
        },
        error: function (data) {
            console.log(data);
        }
    });
    $("#taskCategory").on("change", function () {
        var category = $(this).val();
            var id = $('input[name="id"]').val();
            $.ajax({
                url: '/task/content/' + id,
                type: 'post',
                data: {
                    'categoryId':category,
                    '_token':CSRF_TOKEN
                },
                dataType: 'html',
                success: function (data) {
                    $(".tastContent").html(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
    });
});