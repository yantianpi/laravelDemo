/**
 * Created by peteryan on 2017/11/29.
 */
$(function () {
});
sflag = false;
function selectAllItems() {
    if (sflag == true) {
        sflag = false;
    } else {
        sflag = true;
    }
    if (sflag) {
        $("." + arguments[0]).attr('checked', 'checked');
        $("." + arguments[1]).attr('checked', 'checked');
    } else {
        $("." + arguments[0]).removeAttr('checked');
        $("." + arguments[1]).removeAttr('checked');
    }
}