/**
 * Copyright © Zemez, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery'
], function ($) {
    'use strict';

    var tmSearchMixin = {
        options: {
            template:
                '<li class="<%- data.row_class %> search-item" id="qs-option-<%- data.index %>" role="option">' +
                    //product item
                    '<% if(data.product) { %>' +
                        '<a href="<%- data.url %>">' +
                    '<% if(data.image) { %>' +
                        '<span class="search-thumb">' +
                            '<img src="<%- data.image %>"/>' +
                        '</span>' +
                    '<% } %>' +
                        '<div>' +
                        '<span class="qs-option-name">' +
                            ' <%- data.title %>' +
                        '</span>' +
                            '<%= data.price %>' +
                        '</div>' +
                        '</a>' +
                        //category item
                    '<% } else if(data.category) { %>' +
                        '<a href="<%- data.url %>">' +
                        '<span class="qs-option-name">' +
                            ' <%- data.title %>' +
                        '</span>' +
                        '</a>' +
                        //search item
                    '<% } else { %>' +
                        '<span class="qs-option-name">' +
                            '<%- data.title %>' +
                        '</span>' +
                        '<span aria-hidden="true" class="amount"> (' +
                            '<%- data.num_results %>' +
                        ')</span>' +
                    '<% } %>' +
                '</li>'
        }
    };

    return function (targetWidget) {
        $.widget('mage.quickSearch', targetWidget, tmSearchMixin);
        return $.mage.quickSearch;
    };
});
