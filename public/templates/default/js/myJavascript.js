var myBootstrapJs = function () {
    /**
     * Calls and execute all javascript
     * functions in this file
     */
    mySystemFx();
    formsFx();
    accountFx();
    itemFx();
    employmentFx();
    errorsFx();
    formSearchesFx();
    buttonsConfirmFx();
};



var mySystemFx = function () {
    /**
     * Concerns system functions such as
     * the clock, menus, and other effects
     * required to have the template running
     * smoothly
     */

    // System clock
    if ($('#breadcrumb-clock-timer-hours, #breadcrumb-clock-timer-minutes, #breadcrumb-clock-timer-seconds').length > 0) {
        var $hours = $('#breadcrumb-clock-timer-hours')
            ,$minutes = $('#breadcrumb-clock-timer-minutes')
            ,$seconds = $('#breadcrumb-clock-timer-seconds');

        window.setInterval(function () {
            var hours = parseInt($hours.html())
                ,minutes = parseInt($minutes.html())
                ,seconds = parseInt($seconds.html());

            seconds++;

            if (seconds == 60) {
                minutes++;
                $seconds.html('00');
            } else {
                if (seconds.toString().length < 2)
                    $seconds.html('0' + seconds.toString());
                else
                    $seconds.html(seconds);
            }

            if (minutes == 60) {
                hours++;
                $minutes.html('00');
            } else {
                if (minutes.toString().length < 2)
                    $minutes.html('0' + minutes.toString());
                else
                    $minutes.html(minutes);
            }

            if (hours == 25)
                $hours.html('01');
            else {
                if (hours.toString().length < 2)
                    $hours.html('0' + hours.toString());
                else
                    $hours.html(hours);
            }
        }, 1000);
    }

    // Enables the layout of the system to be fluid
    // based on the size of the window or browser
    if ($('#main-content').length > 0) {
        var $mc = $('#main-content');

        if ($(window).width() > 400)
            $mc.css('width', ($(window).width() - 150) + 'px');
        else
            $mc.css('width', (400 - 150) + 'px');

        $(window).on('resize', function () {
            if ($(window).width() > 400)
                $mc.css('width', ($(window).width() - 150) + 'px');
            else
                $mc.css('width', (400 - 150) + 'px')
        });
    }

    // Navigation of the theme
    if ($('#main-navigation .sub-menu').length > 0) {
        $('#main-navigation').find('.sub-menu').each(function () {
            var $this = $(this)
                ,$trig = $this.parent('li');

            $this.css({
                'top': ($trig.offset().top + $trig.height() - 1) + 'px'
            }).stop(true, true).slideUp(0);

            $(window).on('resize', function () {
                $this.css('top', ($trig.offset().top + $trig.height() - 1) + 'px');
            });

            $trig.hover(function () {
                $this.show(0);
            }, function () {
                $this.hide(0);
            });
        });
    }
};



var formsFx = function () {

};



var accountFx = function () {

};



var itemFx = function () {
    // Set special features of the multiple
    // items input form, the form will not
    // work properly without these scripts
    if ($('#form-multiple-items').length > 0) {
        // Hide unnecessary form elements to avoid
        // complications later on and to simplify
        // the form
        $('label[for="item-has-components"], label[for="item-component-of-label"], #item-has-components, #item-component-of-label, #item-component-of').each(function () {
            var $this = $(this);
            $this.remove();
        });

        // Feature to multiply the selected types
        // for items that are of the same type
        // but has such differences
        var $form = $('#form-multiple-items');
        $form.find('.item-type').each(function () {
            var $this = $(this)
                ,dataType = $this.attr('data-type');
            $this.addClass('unselectable').hover(function () {
                $this.css({
                    'background': '#d9efff'
                    ,'text-shadow': '2px 2px 3px rgba(0, 0, 0, 0.2)'
                });
            }, function () {
                $this.css({
                    'background': 'transparent'
                    ,'text-shadow': '0px 0px 0px transparent'
                });
            }).css({
                'cursor': 'pointer'
            }).on('click', function () {
                // Duplicate the row related
                // to this type
                var rowspan = parseInt($this.attr('rowspan'))
                    ,htmlContents = ''
                    ,rowContents = '<td>'
                        + $this.parent('tr').children('td:nth-child(2)').html()
                        +'</td>'
                        +'<td>'
                        + $this.parent('tr').children('td:nth-child(3)').html()
                        +'</td>';

                rowspan++;
                $this.parent('tr').find('input, textarea, select').each(function () {
                    var $element = $(this)
                        ,dataCount = $element.attr('data-count')
                        ,dataType = $element.attr('data-type')
                        ,dataCategory = $element.attr('data-category')
                        ,currentId = dataCategory+'-'+dataType+'-'+dataCount
                        ,newId = dataCategory+'-'+dataType+'-'+rowspan;

                    rowContents = rowContents.replace(new RegExp(currentId, 'g'), newId);
                });

                htmlContents = '<tr>'
                    + rowContents
                    +'</tr>';
                $this.parent('tr').after(htmlContents);
                $this.find('input, textarea, select').attr('data-count', rowspan);
                $this.prop('rowspan', rowspan);
                systemBootstrapJs();
            });
        });
    }
};



var employmentFx = function () {

};



var errorsFx = function () {

};



var formSearchesFx = function () {
    // Package the item belongs to
    if ($('#item-package').length > 0
        && $('#item-package-label').length > 0) {
        embedSearchFx({
            'url': $('#item-package').attr('data-url')
            ,'o_label': $('#item-package-label')
            ,'o_id': $('#item-package')
        });
    }

    // Item host for the component
    if ($('#item-component-of').length > 0
        && $('#item-component-of-label').length > 0) {
        embedSearchFx({
            'url': $('#item-component-of').attr('data-url')
            ,'o_label': $('#item-component-of-label')
            ,'o_id': $('#item-component-of')
        });
    }

    // Owner of an item, either a person
    // or a department
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

    // Person for department as department head
    if ($('#department-head').length > 0
        && $('#department-head-label').length > 0) {
        embedSearchFx({
            'url': $('#department-head').attr('data-url')
            ,'o_label': $('#department-head-label')
            ,'o_id': $('#department-head')
        });
    }

    // Department
    if ($('#employee-department-label').length > 0
        && $('#employee-department').length > 0) {
        embedSearchFx({
            'url': $('#employee-department').attr('data-url')
            ,'o_label': $('#employee-department-label')
            ,'o_id': $('#employee-department')
        });
    }

    // Job
    if ($('#employee-job-label').length > 0
        && $('#employee-job').length > 0) {
        embedSearchFx({
            'url': $('#employee-job').attr('data-url')
            ,'o_label': $('#employee-job-label')
            ,'o_id': $('#employee-job')
        });
    }
};



var buttonsConfirmFx = function () {
    if ($('input[value="Deactivate Account"]').length > 0) {
        $('input[value="Deactivate Account"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            $this.on('click', function () {
                myConfirm('Do you want to Deactivate this account?', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

    if ($('input[value="Activate Account"]').length > 0) {
        $('input[value="Activate Account"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            $this.on('click', function () {
                myConfirm('Do you want to Activate this account?', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

    if ($('input[value="End Employment"]').length > 0) {
        $('input[value="End Employment"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            $this.on('click', function () {
                myConfirm('Do you want to end this person\'s employment?<div class="hr"></div><span style="color: #f00;">Warning: This action is undoable. You will need an admin access to reverse its effects.</span>', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

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

    /**
     * This is still in progress, will be continued
     * to be developed after the input of the CCSE
     * laboratory custodian is finished
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

    if ($('input[value="Delete Department"]').length > 0) {
        $('input[value="Delete Department"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');

            $this.on('click', function () {
                myConfirm('Are you sure you want to delete this Department?'
                    +'<div class="hr-light"></div>'
                    +'<span style="color: #f00;">WARNING: This action is undoable and the effects were irreversible.</span>', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

    if ($('input[value="Delete Person"]').length > 0) {
        $('input[value="Delete Person"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');

            $this.on('click', function () {
                myConfirm('Are you sure you want to delete this Person?'
                    +'<div class="hr-light"></div>'
                    +'<span style="color: #f00;">WARNING: This action is undoable and the effects were irreversible.</span>', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

    if ($('form').length > 0) {
        $('form').each(function () {
            var $this = $(this)
                ,$btnSubmit = $this.find('input[type="submit"]');

            if ($this.hasClass('main-form')) {
                $btnSubmit.on('click', function () {
                    myConfirm('Submit this form?<div class="hr"></div><span style="color: #03f;">Note: Please make sure that all information you have entered is correct.</span>', function () {
                        $this.submit();
                    });
                    return false;
                });
            }
        });
    }
};



$(document).ready(function () {
    systemBootstrapJs();
    myBootstrapJs();

    // Show the page contents after all html
    // contents and javascripts are loaded into
    // the system
    $('#page').fadeIn(150, function () {
        var $this = $(this);
        $this.css({
            'display': 'block'
        });
    });
});