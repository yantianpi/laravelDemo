/**
 * Created by peteryan on 2017/11/30.
 */
$(function () {
    $(".categoryDetail").on("click", function () {
        var id = $(this).data('id');
        var modal = $("#oneModal");
        $.ajax({
            url: '/category/' + id,
            type: 'get',
            data: [],
            async: false,
            dataType: 'html',
            success: function (data) {
                modal.find('.modal-title').text('Category Detail');
                modal.find('.modal-body').html(data);
                modal.find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
                $("#oneModal").modal({
                    backdrop: "static"
                });
                console.log(data);
            },
            error: function (data) {
                modal.find('.modal-title').text('Category Detail');
                modal.find('.modal-body').html(data.statusText);
                modal.find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
                $("#oneModal").modal({
                    backdrop: "static"
                });
                console.log('error');
                console.log(data);
            }
        });
    });
    $(".categoryAttributeList").on("click", function () {
        var id = $(this).data('id');
        var alias = $(this).data('alias');
        var modal = $("#oneModal");
        $.ajax({
            url: '/category/attributelist/' + id,
            type: 'get',
            data: [],
            async: false,
            dataType: 'html',
            success: function (data) {
                modal.find('.modal-title').text("Category: " + alias);
                modal.find('.modal-body').html(data);
                modal.find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
                $("#oneModal").modal({
                    backdrop: "static"
                });
                console.log(data);
            },
            error: function (data) {
                modal.find('.modal-title').text("Category: " + alias);
                modal.find('.modal-body').html(data.statusText);
                modal.find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
                $("#oneModal").modal({
                    backdrop: "static"
                });
                console.log('error');
                console.log(data);
            }
        });
    });
});