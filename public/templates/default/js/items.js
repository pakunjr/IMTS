$(document).ready(function () {

    /**
     * Place confirm alerts on selected buttons
     * and form submissions
     */
    if ($('input[value="Archive Item"]').length > 0) {
        $('input[value="Archive Item"]').each(function () {
            var $this = $(this)
                ,itemName = $this.attr('data-item-name')
                ,url = $this.parent('a').attr('href');
            $this.on('click', function () {
                myConfirm('Do you want to archive this item?<div class="hr"></div><small>Item Name: '+itemName+'</small><br /><br /><span style="color: #f00;">Warning: This action is undoable, you will need an admin access to reverse this action.</span>', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }



    /*
    if ($('input[value="Save Item"]').length > 0) {
        $('input[value="Save Item"]').each(function () {
            var $this = $(this)
                ,$parentForm = $this.closest('form')
                ,$itemNameBox = $parentForm.find('#item-name')
                ,itemName = $itemNameBox.val();

            if ($.trim(itemName).length < 1) {
                $parentForm.on('submit', function () {
                    myAlert('Please provide an item name, thank you.', function () {
                        $('#item-name').focus();
                    });
                    return false;
                });
            }
        });
    }
    */

});