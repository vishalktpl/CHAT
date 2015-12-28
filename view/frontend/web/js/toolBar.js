/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'underscore',
    'jquery',
    'mage/apply/scripts'
], function (_, $, processScripts) {
    'use strict';

    var dataAttr = 'data-mage-redirect',
        nodeSelector = '[' + dataAttr + ']';

    /**
     * Initializes components assigned to a specified element via data-* attribute.
     *
     * @param {HTMLElement} el - Element to initialize components with.
     * @param {Object|String} config - Initial components' config.
     * @param {String} component - Components' path.
     */
    function init(el, config, component) {
        if ($(el).is("select"))
        {
            $(el).on('change', function(e){
                window.location=this.value;
            });
        }

    }

    /**
     * Parses elements 'data-mage-init' attribute as a valid JSON data.
     * Note: data-mage-init attribute will be removed.
     *
     * @param {HTMLElement} el - Element whose attribute should be parsed.
     * @returns {Object}
     */
    function getData(el) {
        var data = el.getAttribute(dataAttr);

        el.removeAttribute(dataAttr);
        return {
            el: el,
            data: data//JSON.parse(data)
        };
    }

    return {
        /**
         * Initializes components assigned to HTML elements via [data-mage-init].
         *
         * @example Sample 'data-mage-init' declaration.
         *      data-mage-init='{"path/to/component": {"foo": "bar"}}'
         */
        apply: function () {
            var virtuals = processScripts(),
                nodes = document.querySelectorAll(nodeSelector);
            _.toArray(nodes)
                .map(getData)
                .concat(virtuals)
                .forEach(function (itemContainer) {
                    var element = itemContainer.el;
                   /* _.each(itemContainer.data, function (obj, key) {*/
                                init.call(null, element, "obj", "key");

                    /*});*/


                });
        },
        applyFor: init
    };
});
