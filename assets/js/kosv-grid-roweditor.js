/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */
if (typeof kosv == 'undefined' || !kosv) {
    var kosv = {};
}

(function ($) {
    kosv.GridRowEditor = function (gridSelector, params) {
        this.SELECT_MODE_CHECKBOX = 0x1;
        this.SELECT_MODE_CLICK = 0x2;

        this.$grid = $(gridSelector).eq(0);
        this.prefix = 'gre';
        this.saveAjax = false;
        this.saveUrl = location.pathname;
        this.selectMode = this.SELECT_MODE_CHECKBOX;
        this.selectParams = {};

        $.extend(this, params);

        this._initEvents();
    };
    var proto = kosv.GridRowEditor.prototype;

    proto.dataAttr = function (name) {
        return 'data-' + this.p('-' + name);
    };

    proto.p = function (str) {
        return this.prefix + str;
    };

    proto.invertSelectedRow = function ($row) {
        this.selectRow($row, !this.isSelectedRow($row));
    };

    proto.isSelectedRow = function ($row) {
        return $row.attr(this.dataAttr('selected')) === 'true';
    };

    proto.selectRow = function ($row, state) {
        state = state ? 'true' : 'false';
        $row.attr(this.dataAttr('selected'), state);
    };

    proto._initEvents = function () {
        this._initRowSelectorEvents();
    };

    proto._initRowSelectorEvents = function () {
        var self = this;
        var selectParams = self.selectParams[self.selectMode];

        self.$grid.on(self.p('rowSelected'), function (e, $row, state) {
            self.selectRow($row, state)
        });

        if (self.selectMode & self.SELECT_MODE_CHECKBOX) {
            $(selectParams.itemSelector).on('change', function () {
                var row = $(this).closest('tr');
                self.$grid
                    .trigger(self.p('rowSelected'), [row, !!this.checked]);
            });

            $(selectParams.allSelector).on('change', function () {
                $(this).closest('table')
                    .find(selectParams.itemSelector)
                    .change();
            });
        }
    };

})(jQuery);