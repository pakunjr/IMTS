$(document).ready(function () {

    //Item form searches
    if ($('#item-package, #item-package-label, #item-component-of, #item-component-of-label, #ownership-owner, #ownership-owner-label, #ownership-owner-type').length > 0) {
        embedSearchFx({
            'url': $('#item-package').attr('data-url')
            ,'o_label': $('#item-package-label')
            ,'o_id': $('#item-package')
        });

        embedSearchFx({
            'url': $('#item-component-of').attr('data-url')
            ,'o_label': $('#item-component-of-label')
            ,'o_id': $('#item-component-of')
        });

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



    //Department head search
    if ($('#department-head, #department-head-label').length > 0) {
        embedSearchFx({
            'url': $('#department-head').attr('data-url')
            ,'o_label': $('#department-head-label')
            ,'o_id': $('#department-head')
        });
    }

});