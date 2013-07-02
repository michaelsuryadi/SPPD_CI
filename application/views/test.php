<html>
    <head>
        <title>Test</title>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/ui-darkness/jquery-ui-1.10.3.custom.css" />
        <style>
            .custom-combobox {
                position: relative;
                display: inline-block;
            }
            .custom-combobox-toggle {
                position: absolute;
                top: 0;
                bottom: 0;
                margin-left: -1px;
                padding: 0;
                /* support: IE7 */
                *height: 1.7em;
                *top: 0.1em;
            }
            .custom-combobox-input {
                margin: 0;
                padding: 0.3em;
            }

            .ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all {
                list-style-type: none;
            }

            ul.ui-autocomplete {
                list-style: none;
            }
        </style>

        <script>
            function monkeyPatchAutocomplete() {

                // Don't really need to save the old fn, 
                // but I could chain if I wanted to
                var oldFn = $.ui.autocomplete.prototype._renderItem;

                $.ui.autocomplete.prototype._renderItem = function(ul, item) {
                    var re = new RegExp("^" + this.term, "i");
                    var t = item.label.replace(re, "<span style='font-weight:bold;color:Blue;'>" + this.term + "</span>");
                    return $("<li></li>")
                            .data("item.autocomplete", item)
                            .append("<a>" + t + "</a>")
                            .appendTo(ul);
                };
            }
            (function($) {
                $.widget("custom.combobox", {
                    _create: function() {
                        this.wrapper = $("<span>")
                                .addClass("custom-combobox")
                                .insertAfter(this.element);

                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                    },
                    _createAutocomplete: function() {
                        var selected = this.element.children(":selected"),
                                value = selected.val() ? selected.text() : "";

                        this.input = $("<input>")
                                .appendTo(this.wrapper)
                                .val(value)
                                .attr("title", "")
                                .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                                .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                                .tooltip({
                            tooltipClass: "ui-state-highlight"
                        });

                        this._on(this.input, {
                            autocompleteselect: function(event, ui) {
                                ui.item.option.selected = true;
                                this._trigger("select", event, {
                                    item: ui.item.option
                                });
                            },
                            autocompletechange: "_removeIfInvalid"
                        });
                    },
                    _createShowAllButton: function() {
                        var input = this.input,
                                wasOpen = false;

                        $("<a>")
                                .attr("tabIndex", -1)
                                .attr("title", "Show All Items")
                                .tooltip()
                                .appendTo(this.wrapper)
                                .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: false
                        })
                                .removeClass("ui-corner-all")
                                .addClass("custom-combobox-toggle ui-corner-right")
                                .mousedown(function() {
                            wasOpen = input.autocomplete("widget").is(":visible");
                        })
                                .click(function() {
                            input.focus();

                            // Close if already visible
                            if (wasOpen) {
                                return;
                            }

                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete("search", "");
                        });
                    },
                    _source: function(request, response) {
                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                        response(this.element.children("option").map(function() {
                            var text = $(this).text();
                            if (this.value && (!request.term || matcher.test(text)))
                                return {
                                    label: text,
                                    value: text,
                                    option: this
                                };
                        }));
                    },
                    _removeIfInvalid: function(event, ui) {

                        // Selected an item, nothing to do
                        if (ui.item) {
                            return;
                        }
                        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                                valueLowerCase = value.toLowerCase(),
                                valid = false;
                        this.element.children("option").each(function() {
                            if ($(this).text().toLowerCase() === valueLowerCase) {
                                this.selected = valid = true;
                                return false;
                            }
                        });

                        // Found a match, nothing to do
                        if (valid) {
                            return;
                        }

                        // Remove invalid value
                        this.input
                                .val("")
                                .attr("title", value + " didn't match any item")
                                .tooltip("open");
                        this.element.val("");
                        this._delay(function() {
                            this.input.tooltip("close").attr("title", "");
                        }, 2500);
                        this.input.data("ui-autocomplete").term = "";
                    },
                    _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                    },
                    _renderMenu: function(ul, items) {
                        var self = this;
                        $.each(items, function(index, item) {
                            self._renderItem(ul, item);
                        });
                    }
                });
            })(jQuery);
            $(function() {
                $("#combobox").combobox();
                $("#combobox2").combobox();
            });
        </script>
    </head>

    <body>
        <h2 style="margin-left:20px;">Airline Reservation</h2>
        <div class="ui-widget">
            <table>
                <tr>
                    <td>From : </td>
                    <td><select id="combobox">
                            <option value="">--Pilih--</option>
                            <?php
                            foreach ($airport['pointer'] as $key => $value) {
//                    echo $value->id . " " . $value->name . " " . $value->country . '<br/>';
                                ?>
                                <option value="<?php echo $value->name; ?>"><?php echo $value->name . ',' . $value->city . '(' . $value->id . ')'; ?></option>
                                <?php
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>To : </td>
                    <td><select id="combobox2">
                            <option value="">--Pilih--</option>
                            <?php
                            foreach ($airport['pointer'] as $key => $value) {
//                    echo $value->id . " " . $value->name . " " . $value->country . '<br/>';
                                ?>
                                <option value="<?php echo $value->name; ?>"><?php echo $value->name . ',' . $value->city . '(' . $value->id . ')'; ?></option>
                                <?php
                            }
                            ?>
                        </select></td>
                </tr>
            </table>

        </div>
        <div class="ui-widget">

        </div>
        <?php
        ?>
    </body>
</html>
