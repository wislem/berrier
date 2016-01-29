var token = $('meta[name="csrf-token"]').attr('content');

$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader('X-CSRF-Token', token);
});

// configure spinner
$spinner = $(".loading");
$spinner.toggle();

// configure editable
//$.fn.editableform.buttons = '<button type="submit" class="btn btn-sm btn-success editable-submit">OK</button>'
//    + '<a href="/admin/categories/" type="button" class="btn btn-sm btn-info editable-cancel">Cancel</a>'
//    + '<button type="button" class="btn btn-sm btn-warning editable-cancel">Cancel</button>'
//    + '<button type="button" class="btn btn-sm btn-danger editable-delete">Delete</button>';
//$.fn.editable.defaults.mode = 'inline';

// configure tree
var $tree = $("#categories-tree");
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
            //.addClass("editable-click editable-container")
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
        url: serverUrl + '/' + e.move_info.moved_node.id + '/move',
        type: "POST",
        data: {
            "_method": "PATCH",
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
            if(response.status == 422) {
                $.each(response.responseJSON, function (index, value) {
                    $.bootstrapGrowl(value, {
                        type: 'danger'
                    });
                })
            }else {
                $.bootstrapGrowl(response.responseJSON.msg, {
                    type: 'danger'
                });
            }
        }
    });
}) // END move

// add category
$(".createCategory").click(function (e) {
    e.preventDefault();

    $.ajax({
        url: '/admin/categories/create',
        method: 'GET',
        success: function(data) {
            bootbox.dialog({
                title: "Create new Category",
                message: data,
                buttons: {
                    main: {
                        label: 'Save',
                        className: 'btn-primary',
                        callback: function(){
                            var data = $('#modal-form').serialize();

                            $spinner.toggle();
                            $.ajax({
                                url: serverUrl,
                                type: 'POST',
                                data: data,
                                success: function(response) {
                                    $spinner.toggle();
                                    var parent_node = $tree.tree('getNodeById', response.parent_id);
                                    $tree.tree(
                                        "appendNode", {
                                            name: response.name,
                                            id: response.id,
                                            parent_id: response.parent_id
                                        },
                                        parent_node
                                    );
                                    $.bootstrapGrowl(response.msg, {type: 'success'});
                                },
                                error: function(response) {
                                    $spinner.toggle();
                                    if(response.status == 422) {
                                        $.each(response.responseJSON, function (index, value) {
                                            $.bootstrapGrowl(value, {
                                                type: 'danger'
                                            });
                                        })
                                    }else {
                                        $.bootstrapGrowl(response.responseJSON.msg, {
                                            type: 'danger'
                                        });
                                    }
                                }
                            });
                        }
                    },
                    Cancel: {
                        label: 'Cancel',
                        className: 'btn-default'
                    }
                }
            });
        }
    })
}) // END add

// edit
$('.jqtree-element').click(function(e){
    e.preventDefault();
    var self = $(this);

    $.ajax({
        url: '/admin/categories/' + self.find('.jqtree-title').data('pk') + '/edit',
        method: 'GET',
        success: function(data) {
            bootbox.dialog({
                title: 'Edit Category',
                message: data,
                buttons: {
                    main: {
                        label: 'Save',
                        className: 'btn-primary',
                        callback: function() {
                            $('#modal-form').submit();
                        }
                    },
                    Cancel: {
                        label: 'Cancel',
                        className: 'btn-default'
                    }
                }
            })
        }
    })
})

//// rename category
//$tree.editable({
//    ajaxOptions: {
//        type: 'POST'
//    },
//    selector: "span.jqtree-title",
//    url: serverUrl + '/1',
//    params: function (params) {
//        var data = {};
//        data._method = 'PATCH';
//        data.action = "rename";
//        data.id = params.pk;
//        data.name = params.value;
//        data.originalname = params.name;
//        return data;
//    },
//    success: function (r, v) {
//        var node = $tree.tree("getNodeById", $(this).attr("data-pk"));
//        node.name = v;
//        $(this).editable("option", "name", v);
//        $.bootstrapGrowl(r.msg, {type: 'success'});
//    },
//    error: function (response) {
//        if(response.status == 422) {
//            $.each(response.responseJSON, function (index, value) {
//                $.bootstrapGrowl(value, {
//                    type: 'danger'
//                });
//            })
//        }else {
//            $.bootstrapGrowl(response.responseJSON.msg, {
//                type: 'danger'
//            });
//        }
//    }
//}) // END rename
//
//// delete category
//$(document).on("click", ".editable-delete", function () {
//    var nodeId = $(this).closest(".jqtree-element").find("span:eq(0)").data("pk");
//    var node = $tree.tree("getNodeById", nodeId)
//    bootbox.confirm('Are you sure?', function(result) {
//        if (result) {
//            $spinner.toggle();
//            $.ajax({
//                url: serverUrl + '/' + node.id,
//                type: "POST",
//                dataType: 'json',
//                data: {
//                    "_method": "DELETE",
//                    "action": "delete",
//                    "id": node.id,
//                    "name": node.name
//                },
//                success: function (response) {
//                    $spinner.toggle();
//                    $tree.tree("removeNode", node);
//                    checkData();
//                    $.bootstrapGrowl(response.msg, {type: 'success'});
//                },
//                error: function (response) {
//                    $spinner.toggle();
//                    if(response.status == 422) {
//                        $.each(response.responseJSON, function (index, value) {
//                            $.bootstrapGrowl(value, {
//                                type: 'danger'
//                            });
//                        })
//                    }else {
//                        $.bootstrapGrowl(response.responseJSON.msg, {
//                            type: 'danger'
//                        });
//                    }
//                }
//            });
//        }
//    });
//}); // END delete