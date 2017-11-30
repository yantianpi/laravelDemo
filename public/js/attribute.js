/**
 * Created by peteryan on 2017/11/30.
 */
$(function () {
    $('#oneModal').on('show.bs.modal', function (event) {
        var element = $(event.relatedTarget) // element that triggered the modal
        var id = element.data('id'); // Extract info from data-* attributes
        console.log(id);        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        $.ajax({
            url: '/attribute/' + id,
            type: 'get',
            async: false,
            dataType: 'html',
            success: function (data) {
                console.log(data);
                modal.find('.modal-title').text('Attribute Detail');
                modal.find('.modal-body').html(data);
                modal.find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
            },
            error: function (data) {
                console.log('error');
                console.log(data);
            }
        });
    });
});