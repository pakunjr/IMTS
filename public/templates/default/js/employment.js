$(document).ready(function () {

    if ($('input[value="End Employment"]').length > 0) {
        $('input[value="End Employment"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
                
            $this.on('click', function () {
                myConfirm('Do you want to end this employment', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

});