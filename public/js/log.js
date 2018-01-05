/**
 * Created by peteryan on 2018/1/5.
 */
/**
 * Created by peteryan on 2017/11/30.
 */
$(function () {
    $('#oneModal').on('show.bs.modal', function (event) {
        var element = $(event.relatedTarget) // element that triggered the modal
        var id = element.data('id'); // Extract info from data-* attributes
        var modal = $(this);
        $.ajax({
            url: '/log/' + id,
            type: 'get',
            data: [],
            async: false,
            dataType: 'html',
            success: function (data) {
                modal.find('.modal-title').text('Log Detail');
                modal.find('.modal-body').html(data);
                modal.find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
                console.log(data);
            },
            error: function (data) {
                console.log('error');
                console.log(data);
            }
        });
    });
    $('.pageInputLimit').on('blur', function () {
        var pageLimit = $(this).val();
        if (pageLimit > 0) {
            $('input[name="pageLimit"]').val(pageLimit);
            $('form').submit();

        }
    });
});