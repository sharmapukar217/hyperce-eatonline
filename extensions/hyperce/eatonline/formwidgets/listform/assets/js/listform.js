+(function ($) {
    "use strict";

    var ListForm = function (element, options) {
        this.$el = $(element);
        this.$form = this.$el.closest("form");
        this.$mapView = null;
        this.options = options || {};
        this.$sortable = null;
        this.$sortableContainer = $(this.options.sortableContainer, this.$el);

        this.init();
    };

    ListForm.prototype.init = function () {
        this.$el.on(
            "click",
            '[data-control="load-record"]',
            $.proxy(this.onLoadRecord, this)
        );
        this.$el.on(
            "click",
            '[data-control="remove-record"]',
            $.proxy(this.onRemoveRecord, this)
        );
        this.bindSorting();
    };

    ListForm.prototype.bindSorting = function () {
        var sortableOptions = {
            handle: this.options.sortableHandle,
        };

        if (this.$sortableContainer.get(0)) {
            this.$sortable = Sortable.create(
                this.$sortableContainer.get(0),
                sortableOptions
            );
        }
    };

    ListForm.prototype.onLoadRecord = function (event) {
        var self = this,
            $button = $(event.currentTarget),
            $record = $button.closest('[data-control="record"]');

        new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $record.data("recordId"),
            onSubmit: $.proxy(self.onSubmitForm, self),
            onSave: function () {
                this.hide();
            },
        });
    };

    ListForm.prototype.onRemoveRecord = function (event) {
        var $button = $(event.currentTarget),
            confirmMsg = $button.data("confirmMessage"),
            $selectedHeader = $button.closest('[data-control="record"]'),
            recordId = $selectedHeader.data("recordId");

        if (confirmMsg.length && !confirm(confirmMsg)) return;

        $.ti.loadingIndicator.show();
        $.request(this.options.removeHandler, {
            data: { recordId: recordId },
        })
            .done(function () {
                $selectedHeader.remove();
            })
            .always(function () {
                $.ti.loadingIndicator.hide();
            });
    };

    // HELPER METHODS
    // ============================

    ListForm.DEFAULTS = {
        alias: "",
        removeHandler: undefined,
        sortableHandle: ".record-item-handle",
        sortableContainer: ".field-record-items",
    };

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.listform;

    $.fn.listform = function (option) {
        var args = arguments;

        return this.each(function () {
            var $this = $(this);
            var data = $this.data("ti.listform");
            var options = $.extend(
                {},
                ListForm.DEFAULTS,
                $this.data(),
                typeof option == "object" && option
            );
            if (!data)
                $this.data("ti.listform", (data = new ListForm(this, options)));
            if (typeof option == "string") data[option].apply(data, args);
        });
    };

    $.fn.listform.Constructor = ListForm;

    $.fn.listform.noConflict = function () {
        $.fn.listform = old;
        return this;
    };

    $(document).render(function () {
        $('[data-control="records-container"]').listform();
    });
})(window.jQuery);
