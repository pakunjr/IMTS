var itemForm = function () {
    if ($('#form-item').length > 0) {
        var $form = $('#form-item')
            ,$componentBox = $form.find('#item-has-components');

        $componentBox.click(function () {
            var $this = $(this);

            if ($this.prop('checked')) {
                $('label[for="item-component-of"], #item-component-of')
                    .stop(true, true)
                    .fadeOut(150, function () {
                    $('#item-component-of').val('');
                });

                var formExtensionHtml = '<div id="form-item-extension" style="display: none;">'
                    +'<div class="hr-light"></div>'
                    +'<fieldset>'
                        +'<legend>Components</legend>'
                        +'<div id="add-components-container">'
                            +'<div class="hr-light"></div>'
                        +'</div>'
                    +'</fieldset>'
                    +'<input id="add-components-button" class="btn-green" type="button" value="Add More Components" />'
                    +'</div>';

                if ($('#form-item-extension').length < 1) {
                    $form.append(formExtensionHtml);
                    $('#form-item-extension').slideDown(150);
                }

                var $container = $('#add-components-container')
                    ,$addBtn = $('#add-components-button')
                    ,optionType = $('#item-type').html()
                    ,optionState = $('#item-state').html()
                    ,addCount = 0;

                $addBtn.click(function () {
                    addCount++;

                    var componentHtml = '<div id="added-component-'+ addCount +'" style="display: none;">'
                        +'<span class="column">'
                            +'<label for="item-name-'+ addCount +'">Name</label>'
                            +'<input id="item-name-'+ addCount +'" class="text" type="text" name="item-name[]" placeholder="Name" /><br />'
                            +'<label for="item-serial-no-'+ addCount +'">Serial No.</label>'
                            +'<input id="item-serial-no-'+ addCount +'" class="text" type="text" name="item-serial-no[]" placeholder="Serial No." /><br />'
                            +'<label for="item-model-no-'+ addCount +'">Model No.</label>'
                            +'<input id="item-model-no-'+ addCount +'" class="text" type="text" name="item-model-no[]" placeholder="Model No." /><br />'
                            +'<label for="item-type-'+ addCount +'">Type</label>'
                            +'<select id="item-type-'+ addCount +'" class="select" name="item-type[]">'+optionType+'</select><br />'
                            +'<label for="item-state-'+ addCount +'">State</label>'
                            +'<select id="item-state-'+ addCount +'" class="select" name="item-state[]">'+optionState+'</select>'
                        +'</span>'
                        +'<span class="column">'
                            +'<label for="item-description-'+ addCount +'">Description / Notes</label>'
                            +'<textarea id="item-description-'+ addCount +'" class="textarea" name="item-description[]" placeholder="Description"></textarea><br />'
                            +'<label for="item-quantity-'+ addCount +'">Quantity</label>'
                            +'<input id="item-quantity-'+ addCount +'" class="text" type="text" name="item-quantity[]" placeholder="Quantity" /><br />'
                            +'<label for="item-date-of-purchase-'+ addCount +'">Date of Purchase</label>'
                            +'<input id="item-date-of-purchase-'+ addCount +'" class="text datepicker" type="text" name="item-date-of-purchase[]" /><br />'
                            +'<label for="item-package-'+ addCount +'">Package</label>'
                            +'<input id="item-package-'+ addCount +'" class="text" type="text" name="item-package[]" placeholder="Package" /><br />'
                        +'</span>'
                        +'<span class="column">'
                            +'<label for="item-cost-'+ addCount +'">Cost</label>'
                            +'<input id="item-cost-'+ addCount +'" class="text" type="text" name="item-cost[]" placeholder="Cost" /><br />'
                            +'<label for="item-depreciation-'+ addCount +'">Depreciation</label>'
                            +'<input id="item-depreciation-'+ addCount +'" class="text" type="text" name="item-depreciation[]" placeholder="Depreciation" /><br />'
                        +'</span>'
                        +'</div>'
                        +'<div class="hr-light"></div>';

                    $container.append(componentHtml);
                    $('#added-component-'+ addCount).slideDown(150, function () {
                        formFx();
                    });
                });

                $addBtn.trigger('click');
            } else {
                if ($('#form-item-extension').length > 0) {
                    var $formExtension = $('#form-item-extension')
                        ,$fe = $formExtension
                        ,formExtensionHeight = parseInt($fe.height())
                            + (parseInt($fe.css('margin-top')) * 2)
                            + (parseInt($fe.css('padding-top')) * 2)
                            + (parseInt($fe.css('border-top-width')) * 2);

                    if (formExtensionHeight > 800) {
                        formExtensionHeight = 800;
                    }

                    $('#form-item-extension')
                        .stop(true, true)
                        .slideUp(formExtensionHeight, function () {
                        $(this).remove();
                    });

                    $('label[for="item-component-of"], #item-component-of').fadeIn(150);
                }
            }
        });
    }
};

$(document).ready(function () {
    itemForm();
});
