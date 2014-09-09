$(document).ready(function () {

    if ($('input[value="End Employment"]').length > 0) {
        $('input[value="End Employment"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
                
            $this.on('click', function () {
                myConfirm('Do you want to end this person\'s employment?<div class="hr"></div><span style="color: #f00;">Warning: This action is undoable. You will need an admin access to reverse it\'s effects.</span>', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

});