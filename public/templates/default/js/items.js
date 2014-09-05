$(document).ready(function () {

    if ($('#search-box-container').length < 1
        && $('.data').length > 0) {
        $('.data').each(function () {
            var $this = $(this)
                ,url = $this.attr('data-url');

            if (!$this.hasClass('disabled')) {
                $this.addClass('special-hover').on('click', function () {
                    window.location = url;
                });
            }
        });
    }



    //Alerts
    //- Archiving items
    //- Submitting main forms (create and update form)
    if ($('input[value="Archive Item"]').length > 0) {
        $('input[value="Archive Item"]').each(function () {
            var $this = $(this)
                ,itemName = $this.attr('data-item-name')
                ,url = $this.parent('a').attr('href');
            $this.on('click', function () {
                myConfirm('Do you want to archive this item?<br /><br />Item Name:<br />'+itemName, function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

});