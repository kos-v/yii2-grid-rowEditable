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
        this.selectMode = this.SELECT_MODE_CHECKBOX;
        this.selectModeParams = {};

        this.initEvents();
    };
    var proto = kosv.GridRowEditor.prototype;

    proto.initEvents = function () {
        var self = this;

        self.$grid.on(self.p('changeRowSelected'), function (e, $row) {
            self.revertSelectedRow($row);
        })
    };

    proto.dataAttr = function (name) {
        return 'data-' + this.p('-' + name);
    };

    proto.p = function (str) {
        return this.prefix + str;
    };

    proto.isSelectedRow = function ($row) {
        return $row.attr(this.dataAttr('selected')) === 'true';
    };

    proto.selectRow = function ($row) {
        if (!this.isSelectedRow($row)) {
            $row.attr(this.dataAttr('selected'), 'true');
            return true;
        }
        return false;
    };

    proto.unselectRow = function ($row) {
        if (this.isSelectedRow($row)) {
            $row.attr(this.dataAttr('selected'), 'false');
            return true;
        }
        return false;
    };

    proto.revertSelectedRow = function ($row) {
        if (this.isSelectedRow($row)) {
            this.unselectRow($row);
        } else {
            this.selectRow($row);
        }
    };


})(jQuery);