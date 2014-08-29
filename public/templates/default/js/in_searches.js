$(document).ready(function () {

    //Package search for items
    if ($('#item-package').length > 0
        && $('#item-package-label').length > 0) {
        embedSearchFx({
            'url': $('#item-package').attr('data-url')
            ,'o_label': $('#item-package-label')
            ,'o_id': $('#item-package')
        });
    }

    //Component host search for items
    if ($('#item-component-of').length > 0
        && $('#item-component-of-label').length > 0) {
        embedSearchFx({
            'url': $('#item-component-of').attr('data-url')
            ,'o_label': $('#item-component-of-label')
            ,'o_id': $('#item-component-of')
        });
    }

    //Owner search for items
    if ($('#ownership-owner').length > 0
        && $('#ownership-owner-label').length > 0
        && $('#ownership-owner-type').length > 0) {
        embedSearchFx({
            'url': $('#ownership-owner').attr('data-url') + $('#ownership-owner-type').val() + '/'
            ,'o_label': $('#ownership-owner-label')
            ,'o_id': $('#ownership-owner')
        });

        $('#ownership-owner-type').change(function () {
            $('#ownership-owner').val('0');
            $('#ownership-owner-label').val('').prop('readonly', false).removeClass('searchbox-readonly');
            embedSearchFx({
                'url': $('#ownership-owner').attr('data-url') + $('#ownership-owner-type').val() + '/'
                ,'o_label': $('#ownership-owner-label')
                ,'o_id': $('#ownership-owner')
            });
        });
    }



    //Department head search for department
    if ($('#department-head').length > 0
        && $('#department-head-label').length > 0) {
        embedSearchFx({
            'url': $('#department-head').attr('data-url')
            ,'o_label': $('#department-head-label')
            ,'o_id': $('#department-head')
        });
    }



    //Department search for employees
    if ($('#employee-department-label').length > 0
        && $('#employee-department').length > 0) {
        embedSearchFx({
            'url': $('#employee-department').attr('data-url')
            ,'o_label': $('#employee-department-label')
            ,'o_id': $('#employee-department')
        });
    }

    //Job search for employees
    if ($('#employee-job-label').length > 0
        && $('#employee-job').length > 0) {
        embedSearchFx({
            'url': $('#employee-job').attr('data-url')
            ,'o_label': $('#employee-job-label')
            ,'o_id': $('#employee-job')
        });
    }

});