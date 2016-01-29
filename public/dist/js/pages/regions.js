var token = $('meta[name="csrf-token"]').attr('content');

$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader('X-CSRF-Token', token);
});

// configure spinner
$spinner = $(".loading");
$spinner.toggle();

// configure editable
$.fn.editableform.buttons = '<button type="submit" class="btn btn-sm btn-success editable-submit">OK</button>'
    + '<button type="button" class="btn btn-sm btn-warning editable-cancel">Cancel</button>'
    + '<button type="button" class="btn btn-sm btn-danger editable-delete">Delete</button>';
$.fn.editable.defaults.mode = 'inline';

// configure tree
var $tree = $("#region-tree");
var opts = {
    data: data,
    dragAndDrop: true,
    autoOpen: true,
    selectable: false,
    useContextMenu: false,
    onCreateLi: function (node, $li) {
        var li = $li.find(".jqtree-title");
        li
            .attr("data-pk", node.id)
            .attr("data-type", "text")
            .addClass("editable-click editable-container")
            .attr("data-name", node.name)
    }
}
function checkData() { if ($tree.find("ul").children().length === 0) $tree.html("Empty :)"); }
$tree.bind("tree.init", checkData)

// initialize tree
$tree.tree(opts)

// move category
$tree.bind("tree.move", function (e) {
    $spinner.toggle();
    e.preventDefault();
    $.ajax({
        url: serverUrl + '/' + e.move_info.moved_node.id,
        type: "POST",
        data: {
            "_method": "PATCH",
            "action": "move",
            "id": e.move_info.moved_node.id,
            "parent_id": e.move_info.moved_node.parent_id,
            "to": e.move_info.target_node.id,
            "name": e.move_info.moved_node.name,
            "direction": e.move_info.position
        },
        success: function (response) {
            $spinner.toggle();
            e.move_info.do_move();
            e.move_info.moved_node["parent_id"] = (e.move_info.position == "inside") ? e.move_info.target_node["id"] : e.move_info.target_node["parent_id"];
            $.bootstrapGrowl(response.msg, {type: 'success'});
        },
        error: function (response) {
            $spinner.toggle();
            if(response.status === 422) {
                var errors = $.parseJSON(response.responseText);
                $.each(errors, function (index, value) {
                    $.bootstrapGrowl(value, {
                        type: 'danger'
                    });
                })
            }else {
                $.bootstrapGrowl(response.msg, {
                    type: 'danger'
                });
            }
        }
    });
}) // END move

// add category
$(".createCategory").click(function (e) {
    e.preventDefault();
    bootbox.prompt({
        title: "Category name:",
        callback: function(result) {
            if(result !== null) {
                $spinner.toggle();
                $.ajax({
                    url: '/admin/regions',
                    type: 'POST',
                    data: {
                        "name": result
                    },
                    success: function(response) {
                        $spinner.toggle();
                        var root = $tree.tree("getTree");
                        $tree.tree(
                            "appendNode", {
                                name: response.name,
                                id: response.id,
                                parent_id: response.parent_id
                            },
                            root
                        );
                        $.bootstrapGrowl(response.msg, {type: 'success'});
                    },
                    error: function(response) {
                        $spinner.toggle();
                        if(response.status === 422) {
                            var errors = $.parseJSON(response.responseText);
                            $.each(errors, function (index, value) {
                                $.bootstrapGrowl(value, {
                                    type: 'danger'
                                });
                            })
                        }else {
                            $.bootstrapGrowl(response.msg, {
                                type: 'danger'
                            });
                        }
                    }
                });
            }
        }
    });
}) // END add

// rename category
$tree.editable({
    ajaxOptions: {
        type: 'POST'
    },
    selector: "span.jqtree-title",
    url: serverUrl + '/1',
    params: function (params) {
        var data = {};
        data._method = 'PATCH';
        data.action = "rename";
        data.id = params.pk;
        data.name = params.value;
        data.originalname = params.name;
        return data;
    },
    success: function (r, v) {
        var node = $tree.tree("getNodeById", $(this).attr("data-pk"));
        node.name = v;
        $(this).editable("option", "name", v);
        $.bootstrapGrowl(r.msg, {type: 'success'});
    },
    error: function (response) {
        if(response.status == 422) {
            var errors = $.parseJSON(response.responseText);
            $.each(errors, function (index, value) {
                $.bootstrapGrowl(value, {
                    type: 'danger'
                });
            })
        }else {
            $.bootstrapGrowl(response.msg, {
                type: 'danger'
            });
        }
    }
}) // END rename

// delete category
$(document).on("click", ".editable-delete", function () {
    var nodeId = $(this).closest(".jqtree-element").find("span:eq(0)").data("pk");
    var node = $tree.tree("getNodeById", nodeId)
    bootbox.confirm('Are you sure?', function(result) {
        if (result) {
            $spinner.toggle();
            $.ajax({
                url: serverUrl + '/' + node.id,
                type: "POST",
                data: {
                    "_method": "DELETE",
                    "action": "delete",
                    "id": node.id,
                    "name": node.name
                },
                success: function (response) {
                    $spinner.toggle();
                    $tree.tree("removeNode", node);
                    checkData();
                    $.bootstrapGrowl(response.msg, {type: 'success'});
                },
                error: function (response) {
                    $spinner.toggle();
                    if(response.status === 422) {
                        var errors = $.parseJSON(response.responseText);
                        $.each(errors, function (index, value) {
                            $.bootstrapGrowl(value, {
                                type: 'danger'
                            });
                        })
                    }else {
                        $.bootstrapGrowl(response.msg, {
                            type: 'danger'
                        });
                    }
                }
            });
        }
    });
}); // END delete