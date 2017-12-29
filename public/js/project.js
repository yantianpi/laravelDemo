/**
 * Created by peteryan on 2017/12/29.
 */
$(function () {
    $('.pageInputLimit').on('blur', function () {
        var pageLimit = $(this).val();
        if (pageLimit > 0) {
            $('input[name="pageLimit"]').val(pageLimit);
            $('form').submit();

        }
    });
});