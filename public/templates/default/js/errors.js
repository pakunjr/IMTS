$(document).ready(function () {

    // System Errors prompt alerts

    if ($('input[value="Archive Error"]').length > 0) {
        $('input[value="Archive Error"]').click(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            myConfirm('Do you want to archive this error?<div class="hr"></div><span style="color: #f00;">This action is unodable.</span>', function () {
                window.location = url;
            });
            return false;
        });
    }

    if ($('input[value="Archive All Errors"]').length > 0) {
        $('input[value="Archive All Errors"]').click(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            myConfirm('Do you want to archive all errors?<div class="hr"></div><span style="color: #f00;">This action is unodable.</span>', function () {
                window.location = url;
            });
            return false;
        });
    }



    // Database Errors prompt alerts

    if ($('input[value="Clean Database Errors Log"]').length > 0) {
        $('input[value="Clean Database Errors Log"]').click(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            myConfirm('Do you want to Clean the Database Errors log?<div class="hr"></div><span style="color: #f00;">Warning: This action is undoable and the deleted information/s can never be retrieved / recovered.</span>', function () {
                window.location = url;
            });
            return false;
        });
    }

});