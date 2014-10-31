var fnEmbeddedSearches = function () {
    if ($('.embedded-search').length > 0) {
        $('.embedded-search').each(function () {
            var $embeddedSearch = $(this),
                searchUrl = $embeddedSearch.attr('data-url'),
                searchDelayer = null,
                searchKeyword = '';
            $embeddedSearch.on('click focusin keyup', function () {
                clearTimeout(searchDelayer);
                searchKeyword = $embeddedSearch.val();
                searchDelayer = setTimeout(function () {
                    var appendHtml = '<div id="embedded-search-results-container"></div>',
                        closeBtnHtml = '<div id="embedded-search-results-container-close-btn"></div>';

                    if (
                        $('#embedded-search-results-container').length < 1
                    ) {
                        $('body').append(appendHtml);
                    }

                    var $container = $('#embedded-search-results-container'),
                        searchDatas = {
                            'search-keyword': searchKeyword
                        };

                    $embeddedSearch.on('focusout', function () {
                        if ($('#embedded-search-results-container:hover').length > 0) {
                            $container.on('mouseleave', function () {
                                $container.remove();
                            });
                        } else {
                            $container.remove();
                        }
                    });

                    if (searchKeyword.length > 0) {
                        $container.load(searchUrl, searchDatas, function () {
                            $container.prepend(closeBtnHtml);
                            var $containerCloseBtn = $('#embedded-search-results-container-close-btn');
                            $containerCloseBtn.on('click', function () {
                                $container.remove();
                            });

                            $container.
                                children('table').
                                children('tbody').
                                children('tr').each(function () {
                                    var $data = $(this),
                                        dataValue = $data.find('.data-value').val(),
                                        dataLabel = $data.find('.data-label').html();

                                    $data.click(function () {
                                        $container.remove();
                                        $embeddedSearch.hide(0, function () {
                                            $embeddedSearch.val(dataValue);
                                        });

                                        var searchPickHtml = '<span class="embedded-search-pick unhighlightable" title="Cancel"><span class="embedded-search-pick-btn-cancel"></span>'+dataLabel+'</span>';
                                        $embeddedSearch.after(searchPickHtml);

                                        var $searchPick = $embeddedSearch.next('.embedded-search-pick'),
                                            $searchPickBtnClose = $searchPick.find('.embedded-search-pick-btn-cancel');

                                        $searchPickBtnClose.click(function () {
                                            $embeddedSearch.val('').show(0);
                                            $searchPick.remove();
                                        });
                                    });
                                });
                        });
                    } else {
                        $container.html('Insert any keyword to start searching.');
                    }

                    var relocateContainer = function () {
                        $container.css({
                            'top': parseInt($embeddedSearch.offset().top) +
                                (
                                    parseInt($embeddedSearch.height()) +
                                    (parseInt($embeddedSearch.css('margin-top')) * 2) +
                                    (parseInt($embeddedSearch.css('padding-top')) * 2) +
                                    (parseInt($embeddedSearch.css('border-top-width')) * 2)
                                    ) +
                                'px',
                            'left': parseInt($embeddedSearch.offset().left) +'px'
                        });
                    };

                    relocateContainer();
                    $(window).on('resize', function () {
                        relocateContainer();
                    });
                }, 650);
            });
        });
    }
};



$(document).ready(function () {
    fnEmbeddedSearches();
});