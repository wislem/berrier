var CompNestable = function() {
    var updateOutput = function(e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));
        } else {
            alert('JSON browser support required!');
        }
    };
    return {
        init: function() {
            var nestLists = $('.dd');
            var nestList1 = $('#available_items');
            var nestList2 = $('#available_items_2');
            var nestList3 = $('#selected_items');
            var custom_link = $('#custom_link');
            var custom_label = $('#custom_label');
            var custom_target = $('#custom_target');
            var add_custom_item_btn = $('#add_selected_item');
            nestList1.nestable({
                maxDepth: 1,
                group: 1
            });
            nestList2.nestable({
                group: 1
            })
            nestList3.nestable({
                group: 1
            }).on('change', updateOutput);
            updateOutput(nestList3.data('output', $('input[name="items"]')));
            $('#nestable-actions > a').on('click', function(e) {
                var nestAction = $(this).data('action');
                if (nestAction == 'collapse') {
                    nestLists.nestable('collapseAll');
                } else if (nestAction == 'expand') {
                    nestLists.nestable('expandAll');
                }
            });
            add_custom_item_btn.click(function(e) {
                e.preventDefault();
                custom_link.next('span').remove();
                custom_label.next('span').remove();
                var link = custom_link.val();
                var label = custom_label.val();
                var target = custom_target.val();
                if (link != '') {
                    if (!(/^http:\/\//.test(link))) {
                        link = "http://" + link;
                    }
                    var nestlist_ol = nestList3.find('ol:first-child');
                    if (nestlist_ol.length == 0) {
                        nestList3.find('div.dd-empty').remove();
                        nestList3.append('<ol class="dd-list"></ol>');
                        nestlist_ol = nestList3.find('ol');
                    }
                    nestlist_ol.append('<li class="dd-item" data-id="Url:' + link + '|' + label + '|' + target + '"><div class="dd-handle"><i class="fa fa-fw fa-external-link-square"></i> ' + label + '</div></li>');
                } else {
                    custom_link.after('<span class="help-block">Required</span>');
                }
                if (label == '') {
                    custom_label.after('<span class="help-block">Required</span>');
                }
                updateOutput(nestList3.data('output', $('input[name="menuitems"]')));
                custom_link.val('');
                custom_label.val('');
                custom_target.val('_blank');
            });
        }
    };
}();